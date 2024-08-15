<?php

namespace App\Http\Controllers;

use App\Models\MagangModel;
use App\Models\Master\AspekModel;
use App\Models\Master\PeriodeModel;
use App\Models\PenilaianModel;
use App\Models\PesertaModel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PenilaianController extends Controller
{
    public function index(Request $request, $lowongan_uid)
    {
        $user = Auth::user();
        $today = Carbon::now();

        if ($user->role_id == 0) {
            // Admin: Ambil semua magang terkait dengan lowongan tersebut
            $magangs = MagangModel::whereHas('lowongan', function ($query) use ($lowongan_uid) {
                $query->where('uid', $lowongan_uid);
            })->get();
        } elseif ($user->role_id == 1) {
            // Mentor: Ambil magang yang terkait dengan mentor ini dan lowongan tersebut
            $mentor_id = $user->mentor->id;
            $magangs = MagangModel::whereHas('lowongan', function ($query) use ($lowongan_uid) {
                $query->where('uid', $lowongan_uid);
            })->where('mentor_id', $mentor_id)->get();
        } else {
            // Peserta: Ambil magang yang terkait dengan peserta ini dan lowongan tersebut
            $magangs = MagangModel::whereHas('peserta', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        }

        // Ambil id periode dari tabel lowongan
        $periodeIds = $magangs->pluck('lowongan.periode_id')->unique();

        // Ambil data periode
        $periodes = PeriodeModel::whereIn('id', $periodeIds)->get();

        // Cek apakah hari ini berada di dalam rentang tanggal periode
        $is_within_period = false;

        foreach ($periodes as $periode) {
            $start_date = Carbon::parse($periode->tanggal_mulai);
            $end_date = Carbon::parse($periode->tanggal_selesai)->endOfDay(); // Akhiri hari pada tanggal selesai

            // Periksa apakah hari ini di antara rentang tanggal mulai dan tanggal selesai
            if ($today->between($start_date, $end_date)) {
                $is_within_period = true;
                break;
            }

            // Periksa apakah hari ini sama dengan tanggal selesai
            if ($today->equalTo($end_date)) {
                $is_within_period = true;
                break;
            }
        }

        // Ambil peserta yang terdaftar di magang
        $pesertaIds = $magangs->pluck('peserta_id');

        $penilaianPesertaIds = PenilaianModel::whereIn('magang_id', $magangs->pluck('id'))
            ->join('magang', 'penilaian.magang_id', '=', 'magang.id')
            ->pluck('magang.peserta_id');
        $pesertas = PesertaModel::whereIn('id', $pesertaIds)
            ->whereNotIn('id', $penilaianPesertaIds)
            ->get();

        // Ambil semua penilaian berdasarkan magang yang ada
        $penilaians = PenilaianModel::with('magang')
            ->whereIn('magang_id', $magangs->pluck('id'))
            ->get();

        // Ambil semua aspek penilaian
        $aspeks = AspekModel::all();

        // Hitung total nilai untuk setiap penilaian
        foreach ($penilaians as $penilaian) {
            $totalNilai = 0;

            foreach ($aspeks as $aspek) {
                // Pastikan aspek ada dalam penilaian sebelum mengaksesnya
                if (property_exists($penilaian, 'aspek_' . $aspek->id)) {
                    $totalNilai += $penilaian->{'aspek_' . $aspek->id};
                }
            }

            // Update total nilai pada model penilaian
            $penilaian->update(['total_nilai' => $totalNilai]);
        }

        return view('pages.penilaian.penilaian', compact('penilaians', 'aspeks', 'magangs', 'pesertas', 'lowongan_uid', 'is_within_period'));
    }




    // public function getPenilaianPeserta(Request $request, $magang_uid)
    // {
    //     $user = Auth::user();

    //     // Check if the user is a peserta
    //     if ($user->role_id == 2) {
    //         $peserta = PesertaModel::where('user_id', $user->id)->first();

    //         if (!$peserta) {
    //             return redirect()->back()->with('error', 'Peserta not found');
    //         }

    //         // Get magang associated with the peserta
    //         $magangs = MagangModel::where('peserta_id', $peserta->id)->get();

    //         // Get penilaian for the peserta's magang
    //         $penilaians = PenilaianModel::whereIn('magang_id', $magangs->pluck('id'))->get();
    //         $aspeks = AspekModel::all();

    //         return view('pages.penilaian.penilaian', compact('penilaians', 'aspeks'));
    //     }

    //     return redirect()->back()->with('error', 'Unauthorized access');
    // }
    public function getPenilaianPeserta(Request $request, $magang_uid)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mendapatkan data peserta berdasarkan user_id
        $peserta = PesertaModel::where('user_id', $user->id)->first();

        // Jika peserta tidak ditemukan, kembalikan respons dengan pesan error
        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta not found');
        }

        // Ambil magang yang terkait dengan peserta dan magang_uid
        $magangs = MagangModel::where('peserta_id', $peserta->id)
            ->where('uid', $magang_uid)
            ->get();

        // Ambil penilaian berdasarkan magang yang terkait dengan peserta
        $penilaians = PenilaianModel::whereIn('magang_id', $magangs->pluck('id'))->get();
        $aspeks = AspekModel::all();

        // Load view dengan data penilaian dan aspek
        return view('pages.penilaian.penilaian', compact('penilaians', 'aspeks', 'magang_uid'));
    }




    public function create()
    {
        //
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'peserta_id' => 'required',
    //         'aspek_id' => 'required|exists:aspek,id',
    //         'nilai' => 'required|integer',
    //     ]);

    //     PenilaianModel::create($request->all());

    //     return redirect('/penilaian')->with('success', 'Berhasil tambah data');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'peserta' => 'required', // Assuming the name attribute in the select field is 'peserta'
    //     ]);

    //     $pesertaId = $request->input('peserta');
    //     $aspeks = AspekModel::all();

    //     foreach ($aspeks as $aspek) {
    //         $request->validate([
    //             'aspek_' . $aspek->id => 'required|integer',
    //         ]);

    //         $nilai = $request->input('aspek_' . $aspek->id);

    //         // Save the data to the database
    //         PenilaianModel::create([
    //             'uid' => Str::uuid(),
    //             'peserta_id' => $pesertaId,
    //             'aspek_id' => $aspek->id,
    //             'nilai' => $nilai,
    //         ]);
    //     }

    //     return redirect('/penilaian')->with('success', 'Berhasil tambah data');
    // }

    public function store(Request $request, $lowongan_uid)
    {
        $request->validate([
            'magang_id' => 'required',
            'nilai' => 'required|array',
        ]);

        // Ambil nilai dari request
        $nilaiArray = $request->nilai;

        // Menghitung total nilai berbobot
        $totalNilai = 0;
        $aspeks = AspekModel::all();

        foreach ($aspeks as $aspek) {
            if (isset($nilaiArray[$aspek->id])) {
                $nilai = $nilaiArray[$aspek->id];
                $bobot = $aspek->bobot / 100; // Mengubah bobot menjadi persentase
                $totalNilai += $nilai * $bobot; // Hitung nilai berbobot
            }
        }

        // Simpan penilaian beserta total_nilai
        PenilaianModel::create([
            'uid' => Str::uuid(),
            'magang_id' => $request->input('magang_id'),
            'nilai' => $nilaiArray,
            'total_nilai' => $totalNilai,
        ]);

        return redirect()->route('data-penilaian.index', ['uid' => $lowongan_uid])->with('success', 'Berhasil tambah data penilaian');
    }





    public function show(Request $request, $id)
    {
        $penilaian = PenilaianModel::where('uid', $id)->first();

        if (!$penilaian) {
            return response()->json(['message' => 'Penilaian not found'], 404);
        }

        return response()->json($penilaian);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'magang_id' => 'required',
            'nilai' => 'required|array',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Temukan penilaian berdasarkan UID
        $penilaian = PenilaianModel::where('uid', $id)->first();

        // Ambil nilai dari request
        $nilaiArray = $request->nilai;

        // Menghitung total nilai berbobot
        $totalNilai = 0;
        $aspeks = AspekModel::all();

        foreach ($aspeks as $aspek) {
            if (isset($nilaiArray[$aspek->id])) {
                $nilai = $nilaiArray[$aspek->id];
                $bobot = $aspek->bobot / 100; // Mengubah bobot menjadi persentase
                $totalNilai += $nilai * $bobot; // Hitung nilai berbobot
            }
        }

        // Perbarui data penilaian
        $penilaian->magang_id = $request->magang_id;
        $penilaian->nilai = $nilaiArray; // Asumsi 'nilai' di-cast ke JSON di model
        $penilaian->total_nilai = $totalNilai;
        $penilaian->save();

        return redirect()->route('data-penilaian.index', ['uid' => $request->uid])->with('success', 'Berhasil update data');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $lowongan_uid)
    {
        PenilaianModel::where('uid', $id)->delete();
        return redirect()->route('data-penilaian.index', ['uid' => $lowongan_uid])->with('success', 'Berhasil hapus Penilaian');
    }



public function cetakPenilaian($magang_uid)
    {
        $user = Auth::user();

        // Mendapatkan penilaian yang terkait dengan peserta yang sedang login
        $penilaians = PenilaianModel::whereHas('magang', function ($query) use ($user, $magang_uid) {
            $query->where('peserta_id', $user->peserta->id)
                ->where('uid', $magang_uid);
        })->get();

        // Ambil data aspek
        $aspeks = AspekModel::all();

        // Load view untuk cetak PDF dengan menyertakan data penilaian dan aspek
        $pdf = FacadePdf::loadView('pages.penilaian.cetakpenilaian', compact('penilaians', 'aspeks'));

        // Mengatur nama file PDF yang akan diunduh
        $pdfFileName = 'laporan-penilaian-' . now()->format('YmdHis') . '.pdf';

        // Mengembalikan respons untuk menampilkan PDF di tab baru
        return $pdf->stream($pdfFileName);
    }
}
