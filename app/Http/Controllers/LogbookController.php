<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LogbookModel;
use App\Models\PesertaModel;
use App\Models\MentorModel;
use App\Models\ProjectModel;
use App\Models\MagangModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request, $magang_id)
    // {
    //     $user = Auth::user();
    //     $logbooks = [];
    //     $selectedPesertaId = $request->input('peserta');
    //     $pesertas = [];

    //     if ($user->role_id === 1) {
    //         $logbooks = LogbookModel::whereHas('magang', function ($query) use ($magang_id) {
    //             $query->where('id', $magang_id);
    //         })->get();
    //     } elseif ($user->role_id === 2) {
    //         $logbooks = LogbookModel::where('magang_id', $magang_id)->get();
    //     }

    //     // Tentukan tanggal awal dan akhir rentang yang diizinkan
    //     $startDate = Carbon::createFromDate(2024, 5, 1);
    //     $endDate = Carbon::createFromDate(2024, 5, 16);

    //     // Periksa apakah tanggal saat ini berada dalam rentang yang diizinkan
    //     $today = Carbon::today();
    //     $isWithinRange = $today->between($startDate, $endDate, true);

    //     // Kelompokkan data logbook berdasarkan tanggal
    //     $groupedData = $logbooks->groupBy(function ($logbook) {
    //         return \Carbon\Carbon::createFromFormat('Y-m-d', $logbook->tanggal)->format('Y-m-d');
    //     });


    //     return view('pages.logbook.logbook', compact('logbooks', 'pesertas', 'groupedData', 'selectedPesertaId', 'isWithinRange', 'user', 'magang_id'));
    // }
    public function index(Request $request, $lowongan_uid)
    {
        $user = Auth::user();
        $logbooks = collect(); // Inisialisasi koleksi untuk logbook
        $selectedPesertaId = $request->input('peserta'); // ID peserta yang dipilih dari permintaan

        $pesertas = collect(); // Inisialisasi koleksi untuk peserta
        $magang_id = null;

        // Ambil magang terkait dengan lowongan kerja tertentu
        if ($user->role_id == 1) {
            // Jika pengguna adalah seorang mentor, ambil magang yang terkait dengan mentor tersebut
            $magangs = MagangModel::where('mentor_id', $user->mentor->id)
                ->whereHas('lowongan', function ($query) use ($lowongan_uid) {
                    $query->where('uid', $lowongan_uid);
                })->get();
        } else {
            // Untuk admin atau peran lainnya, ambil semua magang terkait dengan lowongan
            $magangs = MagangModel::whereHas('lowongan', function ($query) use ($lowongan_uid) {
                $query->where('uid', $lowongan_uid);
            })->get();
        }

        if ($magangs->isNotEmpty()) {
            // Ambil semua peserta bersama dengan data magang dan mentor
            $pesertas = PesertaModel::whereIn('id', $magangs->pluck('peserta_id'))
                ->with('magang.mentor')
                ->get();

            // Query logbook yang terkait dengan magang
            $logbooksQuery = LogbookModel::whereIn('magang_id', $magangs->pluck('id'));

            if ($selectedPesertaId) {
                $logbooksQuery->whereHas('magang', function ($query) use ($selectedPesertaId) {
                    $query->where('peserta_id', $selectedPesertaId);
                });
            }

            $logbooks = $logbooksQuery->with('magang.mentor')->get();
        }

        $startDate = null;
        $endDate = null;

        if ($magangs->isNotEmpty()) {
            // Ambil periode dari magang pertama (dianggap semua magang memiliki periode yang sama)
            $periode = $magangs->first()->lowongan->periode;
            $startDate = Carbon::parse($periode->tanggal_mulai);
            $endDate = Carbon::parse($periode->tanggal_selesai);
        }

        // Periksa apakah tanggal hari ini berada dalam rentang yang diizinkan
        $today = Carbon::today();
        $isWithinRange = $today->between($startDate, $endDate, true);

        // Buat array dari semua tanggal dalam periode, hindari Sabtu dan Minggu
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            if (!$currentDate->isWeekend()) {
                $dates[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        // Kelompokkan data logbook berdasarkan tanggal
        $groupedData = $logbooks->groupBy(function ($logbook) {
            return Carbon::parse($logbook->tanggal)->format('Y-m-d');
        });

        // Periksa apakah ada entri logbook untuk hari ini
        $todayLogbook = $logbooks->where('tanggal', $today->toDateString())->first();

        // Kembalikan view dengan data logbook yang diperlukan
        return view('pages.logbook.logbook', compact('logbooks', 'selectedPesertaId', 'isWithinRange', 'lowongan_uid', 'groupedData', 'today', 'startDate', 'endDate', 'dates', 'todayLogbook', 'pesertas'));
    }



    public function getlogbookpeserta(Request $request, $magang_uid)
    {
        $user = Auth::user();

        // Mendapatkan logbook yang terkait dengan peserta yang sedang login
        $logbooks = LogbookModel::whereHas('magang', function ($query) use ($user, $magang_uid) {
            $query->where('peserta_id', $user->peserta->id)
                ->where('uid', $magang_uid);
        })->get();

        // Mendapatkan tanggal_mulai dan tanggal_selesai dari periode melalui magang dan lowongan
        $magang = MagangModel::where('uid', $magang_uid)
            ->where('peserta_id', $user->peserta->id)
            ->with('lowongan.periode')
            ->first();

        $startDate = null;
        $endDate = null;

        if ($magang) {
            $periode = $magang->lowongan->periode;
            $startDate = Carbon::parse($periode->tanggal_mulai);
            $endDate = Carbon::parse($periode->tanggal_selesai);
        }

        // Periksa apakah tanggal saat ini berada dalam rentang yang diizinkan
        $today = Carbon::today();
        $isWithinRange = $today->between($startDate, $endDate, true);

        // Buat array dari semua tanggal dalam periode, hindari Sabtu dan Minggu
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            if (!$currentDate->isWeekend()) {
                $dates[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        // Kelompokkan data logbook berdasarkan tanggal
        $groupedData = $logbooks->groupBy(function ($logbook) {
            return \Carbon\Carbon::parse($logbook->tanggal)->format('Y-m-d');
        });

        // $todayLogbook = $logbooks->where('tanggal', $today->format('Y-m-d'))->isNotEmpty();
        $todayLogbook = $logbooks->where('tanggal', $today->toDateString())->first();

        return view('pages.logbook.logbook', compact('logbooks', 'isWithinRange', 'magang_uid', 'groupedData', 'today', 'startDate', 'endDate', 'dates', 'todayLogbook'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('logbook.create', compact('magang_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $magang_uid)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date_format:Y-m-d',
            'aktivitas' => 'required',
        ]);

        // Validasi gagal
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Cari magang_id yang sesuai dengan magang_uid
        $magang = MagangModel::where('uid', $magang_uid)->first();

        // Jika tidak menemukan magang, kembali dengan pesan error
        if (!$magang) {
            return Redirect::back()->with('error', 'Magang tidak ditemukan');
        }

        // Periksa apakah user terhubung dengan peserta
        if ($user->peserta) {
            LogbookModel::create([
                'uid' => Str::uuid(),
                'tanggal' => $request->tanggal,
                'aktivitas' => $request->aktivitas,
                'peserta_id' => $user->peserta->id,
                'magang_id' => $magang->id, // Menggunakan magang_id yang sesuai
            ]);
        } else {
            return Redirect::back()->with('error', 'User tidak terhubung dengan peserta');
        }

        return redirect()->route('logbook.index', ['magang_uid' => $magang_uid])->with('success', 'Berhasil isi Logbook');
    }

    public function updateStatusAndFeedback(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'feedback' => 'required',
        ]);

        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $dataToUpdate = [
            'status' => $request->status,
            'feedback' => $request->feedback,
        ];

        LogbookModel::where('uid', $id)->update($dataToUpdate);

        return redirect()->back()->with('success', 'Berhasil update status logbook');
    }


    /**
     * Display the specified resource.
     */
    public function show($magang_id, $id)
    {
        // Implement show logic here if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($magang_id, $id)
    {
        // Implement edit logic here if needed
    }
    public function update(Request $request, $magang_uid, $uid)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'aktivitas' => 'required|string',
        ]);

        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Temukan logbook dengan UID
        $logbook = LogbookModel::where('uid', $uid)->first();

        if (!$logbook) {
            return Redirect::back()->with('error', 'Logbook tidak ditemukan.');
        }

        // Update data logbook hanya untuk aktivitas dan ubah status menjadi 3
        $logbook->update([
            'aktivitas' => $request->input('aktivitas'),
            'status' => 3,
        ]);

        return Redirect::back()->with('success', 'Logbook berhasil diperbarui.');
    }


    public function cetakLogbook($magang_uid)
    {
        $user = Auth::user();

        // Mendapatkan logbook yang terkait dengan peserta yang sedang login
        $logbooks = LogbookModel::whereHas('magang', function ($query) use ($user, $magang_uid) {
            $query->where('peserta_id', $user->peserta->id)
                ->where('uid', $magang_uid);
        })->get();

        // Mendapatkan tanggal_mulai dan tanggal_selesai dari periode melalui magang dan lowongan
        $magang = MagangModel::where('uid', $magang_uid)
            ->where('peserta_id', $user->peserta->id)
            ->with('lowongan.periode')
            ->first();

        $startDate = null;
        $endDate = null;

        if ($magang) {
            $periode = $magang->lowongan->periode;
            $startDate = Carbon::parse($periode->tanggal_mulai);
            $endDate = Carbon::parse($periode->tanggal_selesai);
        }

        // Mengambil semua tanggal dalam periode
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            if (!$currentDate->isWeekend()) {
                $dates[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        // Membuat view untuk PDF
        $pdf = FacadePdf::loadView('pages.logbook.cetaklogbook', compact('logbooks', 'magang_uid', 'startDate', 'endDate', 'dates'));

        $pdfFileName = 'laporan-penilaian-' . now()->format('YmdHis') . '.pdf';
        // return $pdf->download('logbook.pdf');
        return $pdf->stream($pdfFileName);
    }
}
