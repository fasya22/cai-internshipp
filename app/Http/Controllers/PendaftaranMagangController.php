<?php

namespace App\Http\Controllers;

use App\Exports\PendaftarExport;
use App\Mail\PenerimaanEmail;
use App\Mail\PenolakanEmail;
use App\Models\HrdModel;
use Illuminate\Http\Request;
use App\Models\LowonganModel;
use App\Models\MagangModel;
use App\Models\Master\PosisiModel;
use App\Models\Master\PeriodeModel;
use App\Models\MentorModel;
use App\Models\SeleksiModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PendaftaranMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     $userRole = Auth::user()->role_id;

    //     // Initialize lowonganData
    //     $lowonganData = collect();

    //     if ($userRole == 0) {
    //         // For role_id 0, fetch all data
    //         $data['pendaftaran'] = MagangModel::with('englishCertificate')->get();
    //         $magang = MagangModel::with(['peserta.user', 'lowongan.posisi', 'lowongan.periode'])
    //             ->get()
    //             ->groupBy('lowongan_id');

    //         // Fetch all lowongan data
    //         $lowonganData = LowonganModel::with('posisi', 'periode')->get();
    //     } elseif ($userRole == 3) {
    //         // For role_id 3, fetch data based on HRD level
    //         $userId = Auth::user()->id;
    //         $hrd = HrdModel::where('user_id', $userId)->first();

    //         if ($hrd) {
    //             $hrdLevel = $hrd->level;

    //             $data['pendaftaran'] = MagangModel::with('englishCertificate', 'lowongan')
    //                 ->whereHas('lowongan', function ($query) use ($hrdLevel) {
    //                     $query->where('level', $hrdLevel);
    //                 })
    //                 ->whereIn('status_rekomendasi', [1, 2, 3])
    //                 ->get();

    //             // Fetch lowongan data based on HRD level
    //             $lowonganData = LowonganModel::with('posisi', 'periode')
    //                 ->where('level', $hrdLevel)
    //                 ->get();
    //         } else {
    //             // Handle case where HRD data is not found
    //             $data['pendaftaran'] = collect(); // empty collection
    //         }
    //     }

    //     // Group the magang data by lowongan_id
    //     $magang = MagangModel::with(['peserta.user', 'lowongan.posisi', 'lowongan.periode'])
    //         ->get()
    //         ->groupBy('lowongan_id');

    //     // Map the lowongan data to include jumlah_peserta and status
    //     $magangData = $lowonganData->map(function ($lowongan) use ($magang) {
    //         $group = $magang->get($lowongan->id, collect());

    //         $periode = $lowongan->periode;
    //         $today = now();
    //         $status = 'Selesai';

    //         if ($today < \Carbon\Carbon::parse($periode->tanggal_mulai)) {
    //             $status = 'Belum Dimulai';
    //         } elseif ($today <= \Carbon\Carbon::parse($periode->tanggal_selesai)->endOfDay()) {
    //             $status = 'Sedang Berlangsung';
    //         }

    //         return [
    //             'lowongan_id' => $lowongan->id,
    //             'lowongan_uid' => $lowongan->uid,
    //             'posisi' => $lowongan->posisi->posisi,
    //             'periode_judul' => $periode->judul_periode,
    //             'jumlah_peserta' => $group->count(),
    //             'status' => $status,
    //         ];
    //     });

    //     $data['lowongan'] = $lowonganData;
    //     $data['posisi'] = PosisiModel::get();


    //     return view('pages.pendaftaran.list_pendaftar', $data, ['magangData' => $magangData]);
    // }

    public function index(Request $request)
{
    $user = auth()->user();
    $userRole = $user->role_id;

    // Fetch all lowongan data
    $lowonganData = LowonganModel::with('posisi', 'periode')->get();

    // Initialize empty collection for magangData
    $magangData = collect();

    if ($userRole == 0) {
        // Admin: Fetch all magang data
        $magangData = MagangModel::with(['englishCertificate' => function ($query) {
            $query->withTrashed();
        }, 'peserta.user', 'lowongan.posisi', 'lowongan.periode'])
            ->leftJoin('seleksi', 'magang.id', '=', 'seleksi.magang_id')
            ->orderBy('seleksi.nilai_seleksi', 'desc')
            ->orderBy('magang.created_at', 'desc')
            ->select('magang.*')
            ->get();
    } elseif ($userRole == 3) {
        // HRD: Fetch magang data based on HRD level
        $userId = $user->id;
        $hrd = HrdModel::where('user_id', $userId)->first();

        if ($hrd) {
            $hrdLevel = $hrd->level;

            $magangData = MagangModel::with(['englishCertificate' => function ($query) {
                $query->withTrashed();
            }, 'peserta.user', 'lowongan.posisi', 'lowongan.periode'])
                ->leftJoin('seleksi', 'magang.id', '=', 'seleksi.magang_id')
                ->whereHas('lowongan', function ($query) use ($hrdLevel) {
                    $query->where('level', $hrdLevel);
                })
                ->where('status_rekomendasi', 1)
                ->orderBy('seleksi.nilai_seleksi', 'desc')
                ->orderBy('magang.created_at', 'desc')
                ->select('magang.*')
                ->get();

            // Calculate status_penerimaan based on kuota
            $magangData = $magangData->map(function ($item, $key) use ($lowonganData) {
                $lowongan = $lowonganData->firstWhere('id', $item->lowongan_id);
                $kuota = $lowongan ? $lowongan->kuota : 0;

                if ($item->status_rekomendasi == 1 && $item->nilai_seleksi !== null) {
                    $item->status_rekomendasi = $key < $kuota ? 2 : 3; // 2 = diterima, 3 = ditolak
                } else {
                    $item->status_rekomendasi = 1; // If no selection score yet
                }
                return $item;
            });
        }
    }

    // Apply additional filters
    if ($request->filled('posisi')) {
        $magangData = $magangData->filter(function ($item) use ($request) {
            return $item->lowongan->posisi_id == $request->posisi;
        });
    }

    if ($request->filled('periode')) {
        $magangData = $magangData->filter(function ($item) use ($request) {
            return $item->lowongan->periode_id == $request->periode;
        });
    }

    // Filter by year if provided
    if ($request->filled('year')) {
        $magangData = $magangData->filter(function ($item) use ($request) {
            $periodeYear = \Carbon\Carbon::parse($item->lowongan->periode->tanggal_mulai)->year;
            return $periodeYear == $request->year;
        });
    }

    $magangData = $magangData->map(function ($magang) {
        // Decode link_portfolio if it's a string
        if (is_string($magang->link_portfolio)) {
            $magang->link_portfolio = json_decode($magang->link_portfolio, true);
        } else {
            $magang->link_portfolio = [];
        }

        return $magang;
    });

    // Fetch posisi and periode data
    $data['posisi'] = PosisiModel::get();
    $data['periode'] = PeriodeModel::get();

    // Extract years from periode data
    $years = $data['periode']->map(function ($item) {
        return \Carbon\Carbon::parse($item->tanggal_mulai)->year;
    })->unique()->sort()->values();

    if ($userRole === 3) {
        return view('pages.pendaftaran.list_pendaftar', [
            'magangData' => $magangData,
            'lowonganData' => $lowonganData,
            'posisi' => $data['posisi'],
            'periode' => $data['periode'],
            'years' => $years, // Pass years to the view
            'kuota' => $kuota ?? null,
        ]);
    } else {
        return view('pages.pendaftaran.list_pendaftar', [
            'magangData' => $magangData,
            'lowonganData' => $lowonganData,
            'posisi' => $data['posisi'],
            'periode' => $data['periode'],
            'years' => $years, // Pass years to the view
        ]);
    }
}


public function getlistpendaftarhrd(Request $request)
    {
        $userRole = Auth::user()->role_id;

        // Initialize lowonganData
        $lowonganData = collect();

        if ($userRole == 0) {
            // For role_id 0, fetch all data
            $data['pendaftaran'] = MagangModel::with('englishCertificate')->get();

            // Fetch all lowongan data
            $lowonganData = LowonganModel::with('posisi', 'periode')->get();
        } elseif ($userRole == 3) {
            // For role_id 3, fetch data based on HRD level
            $userId = Auth::user()->id;
            $hrd = HrdModel::where('user_id', $userId)->first();

            if ($hrd) {
                $hrdLevel = $hrd->level;

                $data['pendaftaran'] = MagangModel::with('englishCertificate', 'lowongan')
                    ->whereHas('lowongan', function ($query) use ($hrdLevel) {
                        $query->where('level', $hrdLevel);
                    })
                    ->whereIn('status_rekomendasi', [1, 2, 3])
                    ->get();

                // Fetch lowongan data based on HRD level
                $lowonganData = LowonganModel::with('posisi', 'periode')
                    ->where('level', $hrdLevel)
                    ->get();
            } else {
                // Handle case where HRD data is not found
                $data['pendaftaran'] = collect(); // empty collection
            }
        }

        // Filtering by posisi
        if ($request->filled('posisi')) {
            $lowonganData = $lowonganData->where('posisi_id', $request->posisi);
        }

        // Filtering by periode
        if ($request->filled('periode')) {
            $lowonganData = $lowonganData->where('periode_id', $request->periode);
        }

        // Group the magang data by lowongan_id
        $magang = MagangModel::with(['peserta.user', 'lowongan.posisi', 'lowongan.periode'])
            ->get()
            ->groupBy('lowongan_id');

        // Map the lowongan data to include jumlah_peserta and status
        $magangData = $lowonganData->map(function ($lowongan) use ($magang) {
            $group = $magang->get($lowongan->id, collect());

            $periode = $lowongan->periode;
            $today = now();
            $status = 'Selesai';

            if ($today < \Carbon\Carbon::parse($periode->tanggal_mulai)) {
                $status = 'Belum Dimulai';
            } elseif ($today <= \Carbon\Carbon::parse($periode->tanggal_selesai)->endOfDay()) {
                $status = 'Sedang Berlangsung';
            }

            return [
                'lowongan_id' => $lowongan->id,
                'lowongan_uid' => $lowongan->uid,
                'posisi' => $lowongan->posisi->posisi,
                'periode_judul' => $periode->judul_periode,
                'jumlah_peserta' => $group->count(),
                'status' => $status,
            ];
        });

        $data['lowongan'] = $lowonganData;
        $data['posisi'] = PosisiModel::get();
        $data['periode'] = PeriodeModel::get();

        return view('pages.pendaftaran.list_pendaftar', $data, ['magangData' => $magangData]);
    }

    public function getlistpendaftar($uid)
{
    $user = auth()->user();

    try {
        $lowongan = LowonganModel::where('uid', $uid)->firstOrFail(); // Cari lowongan berdasarkan UID
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return abort(404); // Tampilkan halaman 404 jika lowongan tidak ditemukan
    }

    if ($user->role_id === 0) {
        // Jika user adalah mentor, ambil data magang berdasarkan lowongan_id
        $magang = MagangModel::with(['englishCertificate' => function ($query) {
            $query->withTrashed();
        }])->where('lowongan_id', $lowongan->id)->get();
    } elseif ($user->role_id === 3) {
        // Ambil semua peserta magang berdasarkan lowongan_id
        $magang = MagangModel::with(['englishCertificate' => function ($query) {
            $query->withTrashed();
        }])
        ->leftJoin('seleksi', 'magang.id', '=', 'seleksi.magang_id')
        ->where('lowongan_id', $lowongan->id)
        ->where('status_rekomendasi', 1)
        ->orderBy('seleksi.nilai_seleksi', 'desc')
        ->select('magang.*', 'seleksi.nilai_seleksi') // Tambahkan kolom nilai_seleksi
        ->get();

        // Hitung status penerimaan
        $kuota = $lowongan->kuota;
        $magang = $magang->map(function ($item, $key) use ($kuota) {
            // Jika status rekomendasi 1 dan nilai_seleksi ada, tentukan status_penerimaan
            if ($item->status_rekomendasi == 1 && $item->nilai_seleksi !== null) {
                $item->status_rekomendasi = $key < $kuota ? 2 : 3; // 1 = diterima, 2 = ditolak
            } else {
                $item->status_rekomendasi = 1; // Jika belum ada nilai seleksi
            }
            return $item;
        });
    } else {
        return abort(403); // Tampilkan halaman 403 jika role user tidak valid
    }

    $magang = $magang->map(function ($magang) {
        // Decode link_portfolio if it's a string
        if (is_string($magang->link_portfolio)) {
            $magang->link_portfolio = json_decode($magang->link_portfolio, true);
        } else {
            $magang->link_portfolio = [];
        }

        return $magang;
    });
    if ($user->role_id === 3) {
        return view('pages.pendaftaran.list_pendaftar_detail', compact('magang', 'lowongan', 'kuota'));
    } else {
        return view('pages.pendaftaran.list_pendaftar_detail', compact('magang', 'lowongan'));
    }
}






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $lowongan_id)
    {
        $validator = Validator::make($request->all(), []);
        // $validator = Validator::make($request->all(), [
        //     'lowongan_id' => [
        //         'required',
        //         Rule::exists('lowongan', 'id')->where(function ($query) use ($lowongan_id) {
        //             $query->where('id', $lowongan_id);
        //         }),
        //     ],
        // ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        MagangModel::create([
            'uid' => Str::uuid(),
            'peserta_id' => Auth::user()->peserta->id,
            'lowongan_id' => $lowongan_id
        ]);

        return redirect('/home')->with('success', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pendaftaran = MagangModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status_penerimaan' => 'required|in:1,2',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $pendaftaran->update($request->all());

        return redirect()->route('/pendaftaran')->with('success', 'Berhasil memperbarui data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // public function changeStatus($id, $status)
    // {
    //     $pendaftaran = MagangModel::findOrFail($id);
    //     $pendaftaran->status_penerimaan = $status;
    //     $pendaftaran->save();

    //     return redirect('/list-pendaftar')->with('success', 'Status berhasil diperbarui');
    // }

    public function changeStatus($id, $status)
    {
        // Temukan pendaftaran berdasarkan ID
        $pendaftaran = MagangModel::findOrFail($id);
        $pendaftaran->status_penerimaan = $status;
        $pendaftaran->save();

        // Jika status pendaftaran diterima (1), tolak semua pendaftaran lainnya dari peserta yang sama
        if ($status == 1) {
            MagangModel::where('peserta_id', $pendaftaran->peserta_id)
                ->where('id', '!=', $id)
                ->update(['status_penerimaan' => 2]); // 2 untuk ditolak
        }

        $nama = $pendaftaran->peserta->nama;
        $email = $pendaftaran->peserta->user->email;

        $lowonganUid = $pendaftaran->lowongan->uid;

        if ($status == 1) {
            // Diterima
            Mail::to($email)->send(new PenerimaanEmail($nama));
        } elseif ($status == 2) {
            // Ditolak
            Mail::to($email)->send(new PenolakanEmail($nama));
        }

        // Jika diterima, tentukan mentor
        if ($status == 1) {
            $this->assignMentor($pendaftaran);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }

    private function assignMentor($pendaftaran)
    {
        // Dapatkan mentor yang sesuai dengan posisi dan level lowongan
        $mentors = MentorModel::where('posisi_id', $pendaftaran->lowongan->posisi_id)
            ->where('level', $pendaftaran->lowongan->level)
            ->get();

        // Jika tidak ada mentor yang sesuai, keluar dari fungsi
        if ($mentors->isEmpty()) {
            return;
        }

        // Hitung jumlah peserta yang diterima pada posisi dan level yang sama
        $acceptedCount = MagangModel::where('lowongan_id', $pendaftaran->lowongan_id)
            ->where('status_penerimaan', 1)
            ->count();

        // Tentukan mentor berdasarkan jumlah peserta yang diterima dan jumlah mentor yang ada
        $mentorIndex = $acceptedCount % $mentors->count();
        $assignedMentor = $mentors[$mentorIndex];

        // Tetapkan mentor ke pendaftaran
        $pendaftaran->mentor_id = $assignedMentor->id;
        $pendaftaran->save();
    }

    public function changeRecommendationStatus($id, $status, Request $request)
    {
        $pendaftaran = MagangModel::find($id);

        // Simpan catatan jika disertakan
        if ($request->has('catatan')) {
            $pendaftaran->catatan = $request->catatan;
        }

        // Ubah status rekomendasi
        $pendaftaran->status_rekomendasi = $status;
        $pendaftaran->save();

        // Peroleh lowongan_uid dari relasi MagangModel jika ada
        $lowongan_uid = $pendaftaran->lowongan->uid;

        // Redirect dengan menyertakan lowongan_uid sebagai parameter
        return redirect()->back();
    }

    public function simpanPenilaian(Request $request, $id)
    {
        // Temukan data magang berdasarkan ID
        $magang = MagangModel::find($id);

        // Simpan nilai kriteria dan nilai seleksi
        $seleksi = SeleksiModel::updateOrCreate(
            ['magang_id' => $id],
            [
                'relevansi_pekerjaan' => $request->relevansi_pekerjaan,
                'keterampilan' => $request->keterampilan,
                'culture_fit' => $request->culture_fit,
                // Tambahkan nilai kriteria lainnya jika ada
                'nilai_seleksi' => $this->hitungNilaiSeleksi($request->all())
            ]
        );

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }


    private function hitungNilaiSeleksi($data)
    {
        // Contoh data kriteria untuk normalisasi
        // Asumsi nilai maksimum untuk normalisasi
        $nilai_maksimum_kriteria1 = 100; // Misalkan nilai maksimum kriteria 1
        $nilai_maksimum_kriteria2 = 100; // Misalkan nilai maksimum kriteria 2
        $nilai_maksimum_kriteria3 = 100; // Misalkan nilai maksimum kriteria 2

        // Normalisasi nilai
        $nilai_normalisasi_kriteria1 = $data['relevansi_pekerjaan'] / $nilai_maksimum_kriteria1;
        $nilai_normalisasi_kriteria2 = $data['keterampilan'] / $nilai_maksimum_kriteria2;
        $nilai_normalisasi_kriteria3 = $data['culture_fit'] / $nilai_maksimum_kriteria3;

        // Bobot kriteria
        $bobot_kriteria1 = 0.3;
        $bobot_kriteria2 = 0.4;
        $bobot_kriteria3 = 0.3;

        // Hitung nilai akhir menggunakan SAW
        $nilai_akhir = ($nilai_normalisasi_kriteria1 * $bobot_kriteria1) +
            ($nilai_normalisasi_kriteria2 * $bobot_kriteria2) + ($nilai_normalisasi_kriteria3 * $bobot_kriteria3);

        return $nilai_akhir * 100; // Skala nilai akhir dalam rentang 0-100 (opsional)
    }

    public function changeAcceptanceStatus($id, $status)
    {
        $magang = MagangModel::findOrFail($id);
        $magang->status_penerimaan = $status;
        $magang->save();

        return redirect()->back()->with('success', 'Status penerimaan berhasil diubah.');
    }



    // public function hitungSAW($penilaian)
    // {
    //     // Contoh bobot kriteria
    //     $bobot_kriteria1 = 0.5;
    //     $bobot_kriteria2 = 0.5;

    //     // Normalisasi nilai
    //     $max_kriteria1 = $penilaian->max('nilai_kriteria1');
    //     $max_kriteria2 = $penilaian->max('nilai_kriteria2');

    //     foreach ($penilaian as $nilai) {
    //         $nilai->nilai_seleksi = (($nilai->nilai_kriteria1 / $max_kriteria1) * $bobot_kriteria1) + (($nilai->nilai_kriteria2 / $max_kriteria2) * $bobot_kriteria2);
    //     }

    //     return $penilaian;
    // }

    public function filter(Request $request)
    {
        $query = MagangModel::query();

        if ($request->filled('posisi')) {
            $query->where('posisi_id', $request->posisi);
        }

        if ($request->filled('periode')) {
            $query->where('periode_id', $request->periode);
        }

        $magangData = $query->get();

        // Load list of posisi and periode for filtering options
        $listPosisi = PosisiModel::all();
        $listPeriode = PeriodeModel::all();

        return view('pages.pendaftaran.list_pendaftar', compact('magangData', 'listPosisi', 'listPeriode'));
    }


public function exportPDF()
{
    $magangData = MagangModel::with(['peserta', 'lowongan.posisi'])->orderBy('created_at', 'desc')->get();

    $pdf = FacadePdf::loadView('pages.pendaftaran.export_pendaftar', compact('magangData'));
    return $pdf->stream('pendaftar.pdf');
}


}
