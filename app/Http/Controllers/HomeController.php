<?php

namespace App\Http\Controllers;

use App\Models\HrdModel;
use App\Models\LogbookModel;
use App\Models\LowonganModel;
use App\Models\MagangModel;
use App\Models\Master\PeriodeModel;
use App\Models\Master\PosisiModel;
use App\Models\MentorModel;
use App\Models\PenilaianModel;
use App\Models\ProjectModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        // return view('home');
        if (Auth::user()->role_id == 0) {
            $totalPeserta = MagangModel::where('status_penerimaan', 1)->count();
            $totalMentor = MentorModel::count();
            $totalPosisi = PosisiModel::count();
            $totalHrd = HrdModel::count();
            $pelamarTerbaru = MagangModel::where('status_rekomendasi', NULL)->with('peserta', 'lowongan')->latest()->take(5)->get();
            $perluAcc = MagangModel::whereIn('status_rekomendasi', [2, 3])
                ->whereNull('status_penerimaan')
                ->with('peserta', 'lowongan')
                ->latest()
                ->take(5)
                ->get();


            $daftarPosisi = PosisiModel::pluck('posisi', 'id');
            $daftarPeriode = PeriodeModel::pluck('judul_periode', 'id');

            // Rekap project berdasarkan status
            $totalProgress = ProjectModel::whereNull('status')->orWhere('status', 2)->count();
            $totalSelesai = ProjectModel::where('status', 1)->whereNotNull('tgl_pengumpulan')->count();
            $totalMentorBelumDitentukan = MagangModel::where('status_penerimaan', 1)
                ->whereNull('mentor_id')
                ->count();
            $mentorBelumDitentukan = MagangModel::where('status_penerimaan', 1)
                ->whereNull('mentor_id')
                ->with('peserta', 'lowongan')
                ->latest()
                ->take(5)
                ->get();

            return view('pages.dashboard.dashboardadmin', compact(
                'totalPeserta',
                'totalMentor',
                'totalPosisi',
                'totalHrd',
                'pelamarTerbaru',
                // 'pesertaPerPeriode',
                'daftarPeriode',
                'totalProgress',
                'totalSelesai',
                'daftarPosisi',
                'perluAcc',
                'totalMentorBelumDitentukan',
                'mentorBelumDitentukan'
            ));
        } elseif (Auth::user()->role_id == 1) {

            $mentorId = $user->mentor->id;

            // Hitung jumlah kegiatan magang (lowongan) yang memiliki mentor_id yang sesuai
            // $jumlahKegiatanMagang = MagangModel::where('mentor_id', $mentorId)->count();
            $jumlahKegiatanMagang = MagangModel::where('mentor_id', $mentorId)
                ->groupBy('lowongan_id') // Group berdasarkan lowongan_id
                ->select('lowongan_id')   // Pilih lowongan_id
                ->distinct()              // Ambil nilai yang unik
                ->count();                // Hitung jumlah

            // Fetch participants under this mentor
            $pesertaMagang = MagangModel::where('mentor_id', $mentorId)->with('peserta', 'logbook', 'project')->get();

            // Fetch projects under this mentor
            $projects = ProjectModel::join('magang', 'project.magang_id', '=', 'magang.id')
                ->where('magang.mentor_id', $mentorId)
                ->select('project.*')
                ->get();

            // Calculate counts
            $totalPeserta = $pesertaMagang->count();
            $totalProyekSelesai = $projects->where('status', 1)->count();
            $totalProyekBelumDikumpulkan = $projects->whereNull('status')->whereNull('tgl_pengumpulan')
                ->where('deadline', '>', now())->count();
            $totalProyekPerbaikan = $projects->where('status', 2)->whereNull('tgl_pengumpulan')->count();


            $proyekMenungguReview = ProjectModel::whereHas('magang', function ($query) use ($mentorId) {
                $query->where('mentor_id', $mentorId);
            })
                ->where(function ($query) {
                    $query->whereNull('status')
                        ->orWhere('status', 2);
                })
                ->whereNotNull('tgl_pengumpulan')
                ->get();

            $totalProyekMenungguReview = $proyekMenungguReview->count();



            return view('pages.dashboard.dashboardmentor', compact(
                'totalPeserta',
                'totalProyekSelesai',
                'totalProyekBelumDikumpulkan',
                'totalProyekPerbaikan',
                'pesertaMagang',
                'jumlahKegiatanMagang',
                'projects',
                'totalProyekMenungguReview'
            ));
        } elseif (Auth::user()->role_id == 2) {
            $pesertaId = $user->peserta->id;

            $magang = MagangModel::where('peserta_id', $pesertaId)
                ->with('lowongan.periode')
                ->first();

            if ($magang && $magang->status_penerimaan == 1) {
                $periode = $magang->lowongan->periode;
                $startDate = Carbon::parse($periode->tanggal_mulai);
                $endDate = Carbon::today();

                // Buat array dari semua tanggal dalam periode, hindari Sabtu dan Minggu
                $dates = [];
                $currentDate = $startDate->copy();
                while ($currentDate->lte($endDate)) {
                    if (!$currentDate->isWeekend()) {
                        $dates[] = $currentDate->format('Y-m-d');
                    }
                    $currentDate->addDay();
                }

                // Mendapatkan logbook yang belum diisi dari tanggal_mulai sampai hari ini
                $logbooksFilled = LogbookModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId)
                        ->whereNull('deleted_at');
                })
                    ->whereIn('tanggal', $dates)
                    ->pluck('tanggal')
                    ->toArray();

                // Tanggal yang belum diisi logbooknya
                $logbookReminder = array_diff($dates, $logbooksFilled);

                // Format tanggal untuk ditampilkan
                $logbookReminder = array_map(function ($date) {
                    return Carbon::parse($date)->translatedFormat('j F Y');
                }, $logbookReminder);


                $projectsInProgress = ProjectModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId);
                })
                    ->whereNull('status')
                    ->whereNull('tgl_pengumpulan')
                    ->where('deadline', '>', now())
                    ->orderBy('deadline', 'asc')
                    ->take(3)
                    ->get();

                $completedProjects = ProjectModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId);
                })->where('status', 1)
                    ->take(3)
                    ->get();

                $perluPerbaikan = ProjectModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId);
                })
                    ->where('status', 2)
                    ->whereNull('tgl_pengumpulan')
                    ->take(3)
                    ->get();

                $menungguReview = ProjectModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId);
                })
                    ->where(function ($query) {
                        $query->whereNull('status')
                            ->orWhere('status', 2);
                    })
                    ->whereNotNull('tgl_pengumpulan')
                    ->take(3)
                    ->get();

                $projectsReminder = ProjectModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId);
                })
                    ->where(function ($query) {
                        $query->whereNull('tgl_pengumpulan');
                    })
                    ->where('deadline', '>', now())
                    ->orderBy('deadline', 'asc')
                    ->get();

                // Penilaian dari Mentor
                $latestPenilaian = PenilaianModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId);
                })->latest()->first();

                $projectCount = [
                    'in_progress' => $projectsInProgress->count(),
                    'completed' => $completedProjects->count(),
                    'revisi' => $perluPerbaikan->count(),
                    'menunggu_review' => $menungguReview->count(),
                ];

                $upcomingDeadlineProject = ProjectModel::whereHas('magang', function ($query) use ($pesertaId) {
                    $query->where('peserta_id', $pesertaId);
                })->whereDate('deadline', '>=', now())
                    ->orderBy('deadline', 'asc')
                    ->first();

                return view('pages.dashboard.dashboardpeserta', compact(
                    'projectsInProgress',
                    'completedProjects',
                    'perluPerbaikan',
                    'menungguReview',
                    'projectsReminder',
                    'projectCount',
                    'latestPenilaian',
                    'upcomingDeadlineProject',
                    'logbooksFilled',
                    'logbookReminder',
                    'dates',
                    'magang'
                ));
            } else {
                return view('pages.dashboard.dashboardpeserta', compact('magang'));
            }
        } else {
            $userId = Auth::user()->id;
            $hrd = HrdModel::where('user_id', $userId)->first();

            $hrdLevel = $hrd ? $hrd->level : null;

            $totalPelamarPending = MagangModel::where('status_rekomendasi', 1)
                ->whereNull('status_penerimaan')
                ->whereHas('lowongan', function ($query) use ($hrdLevel) {
                    if ($hrdLevel) {
                        $query->where('level', $hrdLevel);
                    }
                })
                ->count();


            $totalPelamarDirekomendasikan = MagangModel::where('status_rekomendasi', 1)
                ->where('status_penerimaan', 1)
                ->whereHas('lowongan', function ($query) use ($hrdLevel) {
                    if ($hrdLevel) {
                        $query->where('level', $hrdLevel);
                    }
                })
                ->count();


            $totalPelamarTidakDirekomendasikan = MagangModel::where('status_rekomendasi', 1)
            ->where('status_penerimaan', 2)
                ->whereHas('lowongan', function ($query) use ($hrdLevel) {
                    if ($hrdLevel) {
                        $query->where('level', $hrdLevel);
                    }
                })
                ->count();

            $pelamarTerbaru = MagangModel::where('status_rekomendasi', 1)
                ->whereNull('status_penerimaan')
                ->whereHas('lowongan', function ($query) use ($hrdLevel) {
                    if ($hrdLevel) {
                        $query->where('level', $hrdLevel);
                    }
                })
                ->with('peserta', 'lowongan')
                ->latest()
                ->take(5)
                ->get();

            $belumDiproses = $totalPelamarPending > 0;
            $semuaDiproses = !$belumDiproses && $totalPelamarPending == 0;

            return view('pages.dashboard.dashboardhrd', compact(
                'totalPelamarPending',
                'totalPelamarDirekomendasikan',
                'totalPelamarTidakDirekomendasikan',
                'pelamarTerbaru',
                'belumDiproses',
                'semuaDiproses',
            ));
        }
    }

    public function getChartData($periodeId)
    {
        // Data untuk grafik jumlah peserta per posisi untuk periode yang dipilih
        $pesertaPerPosisi = LowonganModel::select('posisi_id', DB::raw('count(magang.id) as count'))
            ->join('magang', 'lowongan.id', '=', 'magang.lowongan_id')
            ->where('magang.status_penerimaan', 1)
            ->where('lowongan.periode_id', $periodeId)
            ->groupBy('posisi_id')
            ->with('posisi')
            ->get()
            ->pluck('count', 'posisi.posisi')
            ->all();

        return response()->json($pesertaPerPosisi);
    }

    public function getPosisiChartData($posisiId)
    {
        // Data untuk grafik jumlah peserta per periode untuk posisi yang dipilih
        $pesertaPerPeriode = LowonganModel::select('periode_id', DB::raw('count(magang.id) as count'))
            ->join('magang', 'lowongan.id', '=', 'magang.lowongan_id')
            ->where('lowongan.posisi_id', $posisiId)
            ->where('magang.status_penerimaan', 1)
            ->groupBy('periode_id')
            ->with('periode')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->periode->judul_periode => $item->count];
            })
            ->all();

        return response()->json($pesertaPerPeriode);
    }
}
