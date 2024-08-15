<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LowonganModel;
use App\Models\MagangModel;
use App\Models\Master\PosisiModel;
use App\Models\Master\PeriodeModel;
use App\Models\PesertaModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LowonganController extends Controller
{
    public function index()
    {
        $data['lowongan'] = LowonganModel::get();
        $data['posisi'] = PosisiModel::get();
        $data['periode'] = PeriodeModel::get();
        return view('pages.lowongan.lowongan', $data);
    }

    public function getAvailablePeriodes($posisiId)
    {
        // Ambil periode yang belum digunakan oleh posisi yang dipilih
        $usedPeriodes = LowonganModel::where('posisi_id', $posisiId)->pluck('periode_id');
        $availablePeriodes = PeriodeModel::whereNotIn('id', $usedPeriodes)->get();

        // Format the dates using Carbon and translate them to Indonesian
        $formattedPeriodes = $availablePeriodes->map(function ($periode) {
            $periode->tanggal_mulai = Carbon::parse($periode->tanggal_mulai)->translatedFormat('j F Y');
            $periode->tanggal_selesai = Carbon::parse($periode->tanggal_selesai)->translatedFormat('j F Y');
            return $periode;
        });

        return response()->json($formattedPeriodes);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'posisi' => 'required',
            'periode' => 'required',
            'metode' => 'required',
            'level' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'keahlian_yang_dibutuhkan' => 'required|array',
            'requires_english' => 'boolean',
            'kuota' => 'required',
        ]);

        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        LowonganModel::create([
            'uid' => Str::uuid(),
            'posisi_id' => $request->posisi,
            'periode_id' => $request->periode,
            'metode' => $request->metode,
            'level' => $request->level,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'keahlian_yang_dibutuhkan' => json_encode($request->keahlian_yang_dibutuhkan),
            'requires_english' => $request->requires_english,
            'kuota' => $request->kuota,
        ]);

        return redirect('/lowongan')->with('success', 'Berhasil tambah data');
    }

    public function show($uid)
{
    // Ambil data lowongan berdasarkan UID
    $lowongan = LowonganModel::where('uid', $uid)->first();

    // Ambil user yang sedang login
    $user = auth()->user();

    // Periksa apakah user sudah melamar untuk lowongan ini
    $hasApplied = false;
    if ($user) {
        // Temukan peserta yang terkait dengan lowongan ini
        $peserta = PesertaModel::where('user_id', $user->id)
                          ->whereHas('magang', function ($query) use ($lowongan) {
                              $query->where('lowongan_id', $lowongan->id);
                          })
                          ->exists();

        $hasApplied = $peserta;
    }

    // Kirim data ke view
    return view('front.pages.job-details', compact('lowongan', 'hasApplied'));
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

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'posisi' => 'required',
            'periode' => 'required',
            'metode' => 'required',
            'level' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'keahlian_yang_dibutuhkan' => 'required|array',
            'requires_english' => 'required|boolean',
            'kuota' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        LowonganModel::where('uid', $id)->update([
            'posisi_id' => $request->posisi,
            'periode_id' => $request->periode,
            'metode' => $request->metode,
            'level' => $request->level,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'keahlian_yang_dibutuhkan' => json_encode($request->keahlian_yang_dibutuhkan),
            'requires_english' => $request->requires_english,
            'kuota' => $request->kuota,
        ]);

        return redirect('/lowongan')->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LowonganModel::where('uid', $id)->delete();
        return redirect('/lowongan');
    }


    public function getlowonganhome()
    {
        $today = Carbon::today();

        $data['lowongan'] = LowonganModel::whereHas('periode', function ($query) use ($today) {
            $query->where('batas_pendaftaran', '>=', $today);
        })
            ->with('periode') // Include periode data
            ->limit(5)
            ->get();

        $data['posisi'] = PosisiModel::get();
        $data['periode'] = PeriodeModel::get();

        return view('front.pages.home', $data);
    }
    public function getlowongan()
    {
        $today = now()->toDateString();

        $lowongan = LowonganModel::join('periode', 'lowongan.periode_id', '=', 'periode.id')
            ->orderByRaw("CASE WHEN periode.batas_pendaftaran >= '$today' THEN 0 ELSE 1 END, periode.batas_pendaftaran")
            ->select('lowongan.*', 'periode.batas_pendaftaran') // Pastikan memilih field yang diperlukan
            ->paginate(12);

        $lowongan->transform(function ($job) use ($today) {
            $deadline = Carbon::parse($job->batas_pendaftaran);
            $job->days_left = now()->diffInDays($deadline, false);

            // Hitung sisa jam jika hari ini adalah batas pendaftaran
            if ($job->days_left == 0) {
                $job->hours_left = $deadline->diffInHours();
            }

            return $job;
        });

        return view('front.pages.jobs', [
            'lowongan' => $lowongan,
            'posisi' => PosisiModel::all(),
            'periode' => PeriodeModel::all()
        ]);
    }







    // public function detaillowongan(Request $request)
    // {
    //     $data['detail'] = LowonganModel::where('posisi_id', str_replace('-', ' ', $request->deskripsi))->first();
    //     $data['lowongan'] = LowonganModel::get();
    //     $data['posisi'] = PosisiModel::get();
    //     $data['periode'] = PeriodeModel::get();
    //     return view('front.pages.job-details', $data);
    // }
}
