<?php

namespace App\Http\Controllers;

use App\Models\EnglishCertificatesModel;
use Illuminate\Http\Request;
use App\Models\LowonganModel;
use App\Models\MagangModel;
use App\Models\Master\PosisiModel;
use App\Models\Master\PeriodeModel;
use App\Models\MentorModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DataMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getlistpeserta($uid)
{
    $user = Auth::user();
    $lowongan = LowonganModel::where('uid', $uid)->firstOrFail();

    if ($user->role_id == 0) {
        // Admin: Retrieve magang based on the lowongan
        $magangs = MagangModel::where('status_penerimaan', 1)
            ->where('lowongan_id', $lowongan->id)
            ->with(['lowongan', 'englishCertificate' => function ($query) {
                $query->withTrashed();
            }])
            ->get();
    } elseif ($user->role_id == 1) {
        // Mentor: Retrieve magang where mentor_id matches the logged in mentor
        $mentorId = $user->mentor->id;
        $magangs = MagangModel::where('status_penerimaan', 1)
            ->where('lowongan_id', $lowongan->id)
            ->where('mentor_id', $mentorId)
            ->with(['lowongan', 'englishCertificate' => function ($query) {
                $query->withTrashed();
            }])
            ->get();
    }

    // Decode link_portfolio for each magang
    $magangs = $magangs->map(function ($magang) {
        // Decode link_portfolio if it's a string
        if (is_string($magang->link_portfolio)) {
            $magang->link_portfolio = json_decode($magang->link_portfolio, true);
        } else {
            $magang->link_portfolio = [];
        }

        return $magang;
    });

    $data['magang'] = $magangs;
    $data['mentors'] = MentorModel::all();
    $data['englishCertificates'] = EnglishCertificatesModel::all();

    return view('pages.pendaftaran.peserta_magang_detail', $data);
}


public function index(Request $request)
{
    // Ambil user yang sedang login
    $user = Auth::user();

    // Query dasar untuk mendapatkan semua data magang yang status penerimaannya 1
    $magangQuery = MagangModel::with(['peserta.user', 'lowongan.posisi', 'lowongan.periode'])
        ->where('status_penerimaan', 1);

    // Jika user adalah mentor, filter berdasarkan mentor_id
    if ($user->role_id == 1) {
        $mentorId = $user->mentor->id;
        $magangQuery->where('mentor_id', $mentorId);
    }

    // Filter berdasarkan posisi jika posisi dipilih
    if ($request->filled('posisi')) {
        $magangQuery->whereHas('lowongan.posisi', function($query) use ($request) {
            $query->where('id', $request->posisi);
        });
    }

    // Filter berdasarkan periode jika periode dipilih
    if ($request->filled('periode')) {
        $magangQuery->whereHas('lowongan.periode', function($query) use ($request) {
            $query->where('id', $request->periode);
        });
    }

    // Filter berdasarkan mentor jika mentor dipilih
    if ($request->filled('mentor')) {
        $magangQuery->where('mentor_id', $request->mentor);
    }

    // Filter berdasarkan tahun jika tahun dipilih
    if ($request->filled('year')) {
        $year = $request->year;
        $magangQuery->whereHas('lowongan.periode', function($query) use ($year) {
            $query->whereYear('tanggal_mulai', $year);
        });
    }

    // Dapatkan hasil akhir dari query
    $magang = $magangQuery->get();

    // Decode link_portfolio for each magang
    $magang = $magang->map(function ($magang) {
        // Decode link_portfolio if it's a string
        if (is_string($magang->link_portfolio)) {
            $magang->link_portfolio = json_decode($magang->link_portfolio, true);
        } else {
            $magang->link_portfolio = [];
        }

        return $magang;
    });

    // Ekstrak tahun dari data periode
    $years = PeriodeModel::all()->map(function ($item) {
        return \Carbon\Carbon::parse($item->tanggal_mulai)->year;
    })->unique()->sort()->values();

    // Data yang akan dikirimkan ke view
    $data = [
        'pendaftaran' => $magang,
        'posisi' => PosisiModel::all(),
        'periode' => PeriodeModel::all(),
        'mentor' => MentorModel::all(),
        'selectedPosisi' => $request->posisi,
        'selectedPeriode' => $request->periode,
        'selectedMentor' => $request->mentor,
        'selectedYear' => $request->year, // Tambahkan ini untuk mengirim tahun yang dipilih ke view
        'years' => $years, // Tambahkan ini untuk mengirim data tahun ke view
        'magangData' => $magang, // Sesuaikan dengan struktur yang diinginkan pada view
    ];

    return view('pages.pendaftaran.peserta_magang', $data);
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
    // public function store(Request $request, $lowongan_id)
    // {
    //     // Ambil semua data sertifikat bahasa Inggris dari database
    //     $englishCertificates = EnglishCertificatesModel::all();

    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         'surat_lamaran_magang' => 'required|file|mimes:pdf|max:2048',
    //         'cv' => 'required|file|mimes:pdf|max:2048',
    //         'english_certificate_id' => 'required|integer|exists:english_certificates,id',
    //         'nilai_bahasa_inggris' => 'required|integer',
    //         'sertifikat_bahasa_inggris' => 'file|mimes:pdf|max:2048|nullable',
    //         'keahlian_yang_dimiliki' => 'required|array',
    //         'link_portfolio' => 'required|string',
    //     ]);

    //     // Jika validasi gagal
    //     if ($validator->fails()) {
    //         return Redirect::back()->withErrors($validator)->withInput();
    //     }

    //     // Ambil jenis sertifikat bahasa Inggris yang dipilih
    //     $selectedCertificate = $englishCertificates->firstWhere('id', $request->input('english_certificate_id'));

    //     // Jika sertifikat tidak ditemukan, kembali dengan pesan kesalahan
    //     if (!$selectedCertificate) {
    //         return Redirect::back()->withErrors(['english_certificate_id' => 'Jenis sertifikat bahasa Inggris tidak valid'])->withInput();
    //     }

    //     // Cek apakah nilai bahasa Inggris memenuhi treshold
    //     if ($request->input('nilai_bahasa_inggris') < $selectedCertificate->minimum_score) {
    //         return Redirect::back()->withErrors(['nilai_bahasa_inggris' => 'Nilai bahasa Inggris tidak memenuhi treshold minimal'])->withInput();
    //     }

    //     // Proses pengunggahan file
    //     $suratLamaranMagangName = null;
    //     if ($request->hasFile('surat_lamaran_magang')) {
    //         $name = $request->file('surat_lamaran_magang')->getClientOriginalName();
    //         $suratLamaranMagangName = time() . '-' . $name;
    //         $request->file('surat_lamaran_magang')->move(public_path('pdf'), $suratLamaranMagangName);
    //     }

    //     $cvName = null;
    //     if ($request->hasFile('cv')) {
    //         $name = $request->file('cv')->getClientOriginalName();
    //         $cvName = time() . '-' . $name;
    //         $request->file('cv')->move(public_path('pdf'), $cvName);
    //     }

    //     $sertifikatBahasaInggrisName = null;
    //     if ($request->hasFile('sertifikat_bahasa_inggris')) {
    //         $name = $request->file('sertifikat_bahasa_inggris')->getClientOriginalName();
    //         $sertifikatBahasaInggrisName = time() . '-' . $name;
    //         $request->file('sertifikat_bahasa_inggris')->move(public_path('pdf'), $sertifikatBahasaInggrisName);
    //     }

    //     $keahlianDimiliki = json_encode($request->input('keahlian_yang_dimiliki'));

    //     // Insert data ke tabel magang
    //     MagangModel::create([
    //         'uid' => Str::uuid(),
    //         'peserta_id' => Auth::user()->peserta->id,
    //         'lowongan_id' => $lowongan_id,
    //         'surat_lamaran_magang' => $suratLamaranMagangName,
    //         'cv' => $cvName,
    //         'english_certificate_id' => $request->input('english_certificate_id'),
    //         'nilai_bahasa_inggris' => $request->input('nilai_bahasa_inggris'),
    //         'sertifikat_bahasa_inggris' => $sertifikatBahasaInggrisName,
    //         'keahlian_yang_dimiliki' => $keahlianDimiliki,
    //         'link_portfolio' => $request->input('link_portfolio'),
    //     ]);

    //     return redirect('/history-magang')->with('success', 'Berhasil tambah data');
    // }

    public function store(Request $request, $lowongan_uid)
    {
        // Cari lowongan berdasarkan uid
        $lowongan = LowonganModel::where('uid', $lowongan_uid)->first();

        // Jika lowongan tidak ditemukan, kembalikan pesan kesalahan
        if (!$lowongan) {
            return redirect()->back()->withErrors(['lowongan_uid' => 'Lowongan tidak ditemukan'])->withInput();
        }

        // Ambil semua data sertifikat bahasa Inggris dari database
        $englishCertificates = EnglishCertificatesModel::all();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'surat_lamaran_magang' => 'required|file|mimes:pdf|max:2048',
            'cv' => 'required|file|mimes:pdf|max:2048',
            'english_certificate_id' => 'nullable',
            'nilai_bahasa_inggris' => 'nullable|numeric',
            'sertifikat_bahasa_inggris' => 'file|mimes:pdf|max:2048|nullable',
            'keahlian_yang_dimiliki' => 'array',
            'soft_komunikasi' => 'boolean',
            'soft_tim' => 'boolean',
            'soft_adaptable' => 'boolean',
            'link_portfolio.*' => 'required|url',

            // Tambahan validasi untuk form update profil
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required|digits_between:10,15',
            'pendidikan_terakhir' => 'required',
            'institusi_pendidikan_terakhir' => 'required',
            'prodi' => 'required',
            'ipk' => 'required|numeric|between:0,4.00',
            'tanggal_mulai_studi' => 'required|date',
            'tanggal_berakhir_studi' => 'required|date',
            'kartu_identitas_studi' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $selectedCertificate = null;

        if ($request->filled('english_certificate_id')) {
            $selectedCertificate = $englishCertificates->firstWhere('id', $request->input('english_certificate_id'));
        }

        // Cek apakah nilai bahasa Inggris memenuhi treshold jika ada sertifikat yang dipilih
        if ($selectedCertificate && $request->input('nilai_bahasa_inggris') < $selectedCertificate->minimum_score) {
            return redirect()->back()->withErrors(['nilai_bahasa_inggris' => 'Nilai bahasa Inggris tidak memenuhi treshold minimal'])->withInput();
        }


        // Proses pengunggahan file
        $suratLamaranMagangName = null;
        if ($request->hasFile('surat_lamaran_magang')) {
            $suratLamaranMagangName = time() . '-' . $request->file('surat_lamaran_magang')->getClientOriginalName();
            $request->file('surat_lamaran_magang')->storeAs('public/surat_lamaran_magang', $suratLamaranMagangName);
        }

        $cvName = null;
        if ($request->hasFile('cv')) {
            $cvName = time() . '-' . $request->file('cv')->getClientOriginalName();
            $request->file('cv')->storeAs('public/cv', $cvName);
        }

        $sertifikatBahasaInggrisName = null;
        if ($request->hasFile('sertifikat_bahasa_inggris')) {
            $sertifikatBahasaInggrisName = time() . '-' . $request->file('sertifikat_bahasa_inggris')->getClientOriginalName();
            $request->file('sertifikat_bahasa_inggris')->storeAs('public/sertifikat_bahasa_inggris', $sertifikatBahasaInggrisName);
        }


        $keahlianDimiliki = json_encode($request->input('keahlian_yang_dimiliki'));
        $linkPortfolio = json_encode($request->input('link_portfolio'));

        // Insert data ke tabel magang
        MagangModel::create([
            'uid' => Str::uuid(),
            'peserta_id' => Auth::user()->peserta->id,
            'lowongan_id' => $lowongan->id,  // Menggunakan ID dari lowongan yang ditemukan
            'surat_lamaran_magang' => $suratLamaranMagangName,
            'cv' => $cvName,
            'english_certificate_id' => $request->input('english_certificate_id'),
            'nilai_bahasa_inggris' => $request->input('nilai_bahasa_inggris'),
            'sertifikat_bahasa_inggris' => $sertifikatBahasaInggrisName,
            'keahlian_yang_dimiliki' => $keahlianDimiliki,
            'soft_komunikasi' => $request->has('soft_komunikasi'),
            'soft_tim' => $request->has('soft_tim'),
            'soft_adaptable' => $request->has('soft_adaptable'),
            'link_portfolio' => $linkPortfolio,
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Update data peserta dari form
        $peserta = $user->peserta;
        $peserta->update([
            'alamat' => $request->input('alamat'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'no_hp' => $request->input('no_hp'),
            'pendidikan_terakhir' => $request->input('pendidikan_terakhir'),
            'institusi_pendidikan_terakhir' => $request->input('institusi_pendidikan_terakhir'),
            'prodi' => $request->input('prodi'),
            'ipk' => $request->input('ipk'),
            'tanggal_mulai_studi' => $request->input('tanggal_mulai_studi'),
            'tanggal_berakhir_studi' => $request->input('tanggal_berakhir_studi'),
        ]);

        if ($request->hasFile('kartu_identitas_studi')) {
            $kartuIdentitas = $request->file('kartu_identitas_studi');
            $kartuIdentitasName = time() . '-' . $kartuIdentitas->getClientOriginalName();
            $kartuIdentitas->storeAs('public/kartu_identitas_studi', $kartuIdentitasName);

            // Simpan hanya nama file di dalam database
            $peserta->kartu_identitas_studi = $kartuIdentitasName;
            $peserta->save();
        }


        return redirect('/history-magang')->with('success', 'Berhasil tambah data dan perbarui profil');
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mentor_id' => 'required|exists:mentor,id', // Ensure mentor_id exists in mentors table
        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        MagangModel::where('id', $id)->update([
            'mentor_id' => $request->mentor_id,
        ]);

        $magang = MagangModel::findOrFail($id);

        return redirect()->route('getlistpeserta', ['lowongan_uid' => $magang->lowongan->uid])
            ->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function applyJob(Request $request, $lowongan_uid)
    {
        // Simpan URL halaman saat ini ke dalam session
        // session(['previous_url' => url()->current()]);

        $user = Auth::user();
        if ($user->role_id != 2) {
            return view('front.pages.apply-permission');
        }

        // Periksa apakah pengguna telah login
        // if (Auth::check()) {
        // Jika ya, arahkan ke halaman form aplikasi
        $lowongan = LowonganModel::where('uid', $lowongan_uid)->first();

        // Jika lowongan tidak ditemukan, kembali dengan pesan kesalahan
        if (!$lowongan) {
            return redirect()->back()->withErrors(['lowongan_uid' => 'Lowongan tidak ditemukan']);
        }

        $data['posisi'] = PosisiModel::find($lowongan->posisi_id);
        $data['periode'] = PeriodeModel::find($lowongan->periode_id);
        $data['peserta'] = Auth::user()->peserta;
        $data['lowongan'] = $lowongan;
        $data['english_certificates'] = EnglishCertificatesModel::all();

        return view('front.pages.apply-job', $data);
        // } else {
        //     // Jika belum login, arahkan ke halaman login
        //     return redirect()->route('login');
        // }
    }


    // public function changeStatus(Request $request)
    // {
    //     $magangId = $request->input('id');
    //     $status = $request->input('status');

    //     $magang = MagangModel::find($magangId);
    //     if ($magang) {
    //         $magang->status_penerimaan = $status;
    //         $magang->save();

    //         return redirect()->route('magang.getpendaftar')->with('success', 'Status updated successfully.');
    //     }

    //     return redirect()->route('magang.getpendaftar')->with('error', 'Magang not found.');
    // }

    public function historyMagang()
    {
        // Mendapatkan ID peserta yang sedang login
        $pesertaId = Auth::user()->peserta->id;

        // Mendapatkan riwayat magang magang dari peserta yang login beserta relasi yang dibutuhkan
        $magang = MagangModel::where('peserta_id', $pesertaId)
            ->with(['lowongan.posisi', 'lowongan.periode'])
            ->get();

        // Mengirim data ke view
        return view('pages.history.history_magangpeserta', ['magang' => $magang]);
    }

    public function historyMagangMentor(Request $request)
    {
        $user = Auth::user();

        // Load list of posisi and periode for filtering options
        $listPosisi = PosisiModel::all();
        $listPeriode = PeriodeModel::all();

        $lowonganQuery = LowonganModel::with(['posisi', 'periode']);

        // Filter berdasarkan posisi jika posisi dipilih
        if ($request->filled('posisi')) {
            $lowonganQuery->where('posisi_id', $request->posisi);
        }

        // Filter berdasarkan periode jika periode dipilih
        if ($request->filled('periode')) {
            $lowonganQuery->where('periode_id', $request->periode);
        }

        $lowonganData = $lowonganQuery->get();

        // Ambil data magang berdasarkan lowongan yang difilter
        $lowonganIds = $lowonganData->pluck('id')->toArray();

        if ($user->role_id === 0) {
            // Get all magang data for admin
            $magang = MagangModel::with(['peserta.user', 'lowongan.posisi', 'lowongan.periode'])
                ->whereIn('lowongan_id', $lowonganIds)
                ->whereHas('peserta', function ($query) {
                    $query->where('status_penerimaan', 1);
                })
                ->get()
                ->groupBy('lowongan_id');
        } else {
            // Get the mentor associated with the user
            $mentor = $user->mentor;

            if ($mentor) {
                $mentorId = $mentor->id;

                // Get the magang data for the mentor
                $magang = MagangModel::whereIn('lowongan_id', $lowonganIds)
                    ->whereHas('peserta', function ($query) use ($mentorId) {
                        $query->where('mentor_id', $mentorId);
                    })
                    ->with(['peserta.user', 'lowongan.posisi', 'lowongan.periode'])
                    ->get()
                    ->groupBy('lowongan_id');
            } else {
                return redirect()->back()->with('error', 'User tidak terhubung dengan mentor');
            }
        }

        // Prepare data for each group of magang
        $magangData = $magang->map(function ($group) {
            $firstMagang = $group->first();
            $lowongan = $firstMagang->lowongan;
            $periode = $lowongan->periode;
            $posisi = $lowongan->posisi;
            $today = now();
            $status = 'Selesai';

            if ($today < \Carbon\Carbon::parse($periode['tanggal_mulai'])) {
                $status = 'Belum Dimulai';
            } elseif ($today <= \Carbon\Carbon::parse($periode['tanggal_selesai'])->endOfDay()) {
                $status = 'Sedang Berlangsung';
            }

            return [
                'lowongan_id' => $lowongan['lowongan_id'],
                'lowongan_uid' => $lowongan['uid'],
                'posisi' => $posisi['posisi'],
                'periode_judul' => $periode['judul_periode'],
                'jumlah_peserta' => $group->count(),
                'status' => $status,
            ];
        });

        // Send data to view
        return view('pages.history.history_magang', [
            'magangData' => $magangData,
            'listPosisi' => $listPosisi,
            'listPeriode' => $listPeriode
        ]);
    }


    public function filter(Request $request)
{
    $query = MagangModel::query();

    if ($request->filled('posisi')) {
        $query->whereHas('lowongan', function ($q) use ($request) {
            $q->where('posisi_id', $request->posisi);
        });
    }

    if ($request->filled('periode')) {
        $query->whereHas('lowongan', function ($q) use ($request) {
            $q->where('periode_id', $request->periode);
        });
    }

    if ($request->filled('mentor')) {
        $query->where('mentor_id', $request->mentor);
    }

    $magangData = $query->with(['peserta.user', 'lowongan.posisi', 'lowongan.periode', 'mentor'])->where('status_penerimaan', 1)->orderBy('created_at', 'desc')->get();

    // Load list of posisi, periode, and mentors for filtering options
    $listPosisi = PosisiModel::all();
    $listPeriode = PeriodeModel::all();
    $listMentor = MentorModel::all();

    return view('pages.pendaftaran.peserta_magang', compact('magangData', 'listPosisi', 'listPeriode', 'listMentor'));
}


    public function filterHistory(Request $request)
    {
        $query = MagangModel::with(['posisi', 'periode']);

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

        return view('pages.history.history_magang', compact('magangData', 'listPosisi', 'listPeriode'));
    }
}
