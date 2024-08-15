<?php

namespace App\Http\Controllers;

use App\Models\MagangModel;
use App\Models\Master\PeriodeModel;
use Illuminate\Http\Request;
use App\Models\ProjectModel;
use App\Models\PesertaModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {

    //     // Mendapatkan informasi pengguna yang sedang login
    //     $user = Auth::user();
    //     $projects = [];
    //     $selectedPesertaId = $request->input('peserta');
    //     $pesertas = [];

    //     // Jika pengguna yang login adalah mentor
    //     if ($user->role_id === 1) {
    //         $mentor_id = $user->mentor->id;
    //         // Mendapatkan peserta yang terkait dengan mentor yang sedang login
    //         $pesertas = PesertaModel::where('mentor_id', $mentor_id)->get();

    //         // Jika ada peserta yang dipilih
    //         // if ($selectedPesertaId) {
    //         //     // Temukan peserta yang dipilih
    //         //     $selectedPeserta = PesertaModel::find($selectedPesertaId);

    //         //     // Jika peserta yang dipilih tidak terkait dengan mentor yang sedang login
    //         //     if ($selectedPeserta && $selectedPeserta->mentor_id != $mentor_id) {
    //         //         $selectedPesertaId = null;
    //         //     } else {
    //         //         // Load Project untuk peserta yang dipilih
    //         //         $projects = ProjectModel::where('peserta_id', $selectedPesertaId)->get();
    //         //     }
    //         // }
    //         $projects = ProjectModel::with('peserta')
    //             ->whereIn('peserta_id', $pesertas->pluck('id'))
    //             ->where('peserta_id', $selectedPesertaId)
    //             ->whereNotNull('tgl_pengumpulan')
    //             ->orderBy('deadline', 'asc') // Urutkan berdasarkan deadline terdekat
    //             ->get();

    //         $otherProjects = ProjectModel::with('peserta')
    //             ->whereIn('peserta_id', $pesertas->pluck('id'))
    //             ->where('peserta_id', $selectedPesertaId)
    //             ->whereNull('tgl_pengumpulan')
    //             ->orderBy('deadline', 'asc') // Urutkan berdasarkan deadline terdekat
    //             ->get();

    //         $projects = $projects->merge($otherProjects);
    //     }
    //     // Jika pengguna yang login adalah admin
    //     elseif ($user->role_id === 0) {
    //         $pesertas = PesertaModel::all();
    //         $projects = ProjectModel::with('peserta')->where('peserta_id', $selectedPesertaId)->get();
    //     }
    //     // Jika pengguna yang login adalah peserta
    //     elseif ($user->role_id === 2) {
    //         // Mendapatkan peserta yang sedang login
    //         $pesertas = PesertaModel::where('user_id', $user->id)->get();
    //         // Mendapatkan proyek yang terkait dengan peserta yang sedang login
    //         $projects = ProjectModel::with('peserta')->whereIn('peserta_id', $pesertas->pluck('id'))->get();
    //     }

    //     return view('pages.project.project', compact('projects', 'pesertas', 'selectedPesertaId'));
    // }
    public function index(Request $request, $lowongan_uid)
{
    $user = Auth::user();
    $selectedPesertaId = $request->input('peserta');
    $today = Carbon::now();

    $projects = collect();
    $pesertas = collect();
    $magang_id = null;

    if ($user->role_id === 0) {
        // Admin: Tampilkan semua magang yang terkait dengan lowongan tersebut
        $magangs = MagangModel::whereHas('lowongan', function ($query) use ($lowongan_uid) {
            $query->where('uid', $lowongan_uid);
        })->get();

        if ($magangs->isNotEmpty()) {
            $pesertas = PesertaModel::whereIn('id', $magangs->pluck('peserta_id'))->get();

            $projectsQuery = ProjectModel::whereIn('magang_id', $magangs->pluck('id'));

            if ($selectedPesertaId) {
                $projectsQuery->whereHas('magang', function ($query) use ($selectedPesertaId) {
                    $query->where('peserta_id', $selectedPesertaId);
                });
            }

            $projects = $projectsQuery->orderBy('deadline', 'asc')->get();
        }
    } elseif ($user->role_id === 1) {
        // Mentor: Tampilkan magang yang terkait dengan mentor ini dan terkait dengan lowongan tersebut
        $mentor_id = $user->mentor->id;

        $magangs = MagangModel::whereHas('lowongan', function ($query) use ($lowongan_uid) {
            $query->where('uid', $lowongan_uid);
        })->where('mentor_id', $mentor_id)->get();

        if ($magangs->isNotEmpty()) {
            $pesertas = PesertaModel::whereIn('id', $magangs->pluck('peserta_id'))->get();

            $projectsQuery = ProjectModel::whereIn('magang_id', $magangs->pluck('id'));

            if ($selectedPesertaId) {
                $projectsQuery->whereHas('magang', function ($query) use ($selectedPesertaId) {
                    $query->where('peserta_id', $selectedPesertaId);
                });
            }

            $projects = $projectsQuery->orderBy('deadline', 'asc')->get();
        }
    } elseif ($user->role_id === 2) {
        // Peserta: Tampilkan magang yang terkait dengan peserta ini dan terkait dengan lowongan tersebut
        $peserta_id = $user->peserta->id;

        $magang = MagangModel::whereHas('lowongan', function ($query) use ($lowongan_uid) {
            $query->where('uid', $lowongan_uid);
        })->where('peserta_id', $peserta_id)->first();

        if ($magang) {
            $magang_id = $magang->id;
            $pesertas = PesertaModel::where('id', $magang->peserta_id)->get();
            $projects = ProjectModel::where('magang_id', $magang_id)->get();
        }
    }

    $groupedProjectsByPeserta = $projects->groupBy(function ($project) {
        return $project->magang->peserta->nama;
    });

    $periodeIds = $magangs->pluck('lowongan.periode_id')->unique();

    $periodes = PeriodeModel::whereIn('id', $periodeIds)->get();

    $is_within_period = false;

    foreach ($periodes as $periode) {
        $start_date = Carbon::parse($periode->tanggal_mulai);
        $end_date = Carbon::parse($periode->tanggal_selesai)->endOfDay();

        if ($today->between($start_date, $end_date) || $today->equalTo($end_date)) {
            $is_within_period = true;
            break;
        }
    }

    return view('pages.project.project', compact('projects', 'groupedProjectsByPeserta', 'pesertas', 'selectedPesertaId', 'user', 'lowongan_uid', 'magang_id', 'is_within_period'));
}


    public function getprojectpeserta(Request $request, $magang_uid)
    {
        $user = Auth::user();

        // Cari magang berdasarkan UID
        $magang = MagangModel::where('uid', $magang_uid)->first();

        // Jika tidak menemukan magang, kembali dengan pesan error
        if (!$magang) {
            return redirect()->back()->with('error', 'Magang tidak ditemukan');
        }

        // Mendapatkan project yang terkait dengan peserta yang sedang login melalui tabel magang
        $projects = ProjectModel::where('magang_id', $magang->id)->get();

        return view('pages.project.project', compact('projects', 'magang_uid'));
    }




    /**
     * Show the form for creating a new resource.
     */
    // public function create($lowongan_uid)
    // {
    //     $pesertas = PesertaModel::with('magang')->whereHas('magang', function ($query) use ($lowongan_uid) {
    //         $query->where('lowongan_id', $lowongan_uid);
    //     })->get();

    //     return view('projects.create', compact('lowongan_uid', 'pesertas'));
    // }

    public function store(Request $request, $lowongan_uid)
    {
        $validator = Validator::make($request->all(), [
            'magang_id' => 'required|exists:magang,id',
            'nama_project' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline' => 'required|date',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        ProjectModel::create([
            'uid' => Str::uuid(),
            'magang_id' => $request->magang_id,
            'nama_project' => $request->nama_project,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('data-project.index', ['uid' => $lowongan_uid])->with('success', 'Berhasil tambah data project');
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
            'magang_id' => 'required',
            'nama_project' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required',
            'status',
            'feedback',
        ]);

        // response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        // Ambil data project yang akan diupdate
        $project = ProjectModel::where('uid', $id)->first();

        // Atur data yang akan diupdate
        $dataToUpdate = [
            'magang_id' => $request->magang_id,
            'nama_project' => $request->nama_project,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            // Periksa apakah tgl_pengumpulan sudah terisi sebelum memperbarui
            'tgl_pengumpulan' => $request->filled('tgl_pengumpulan') ? $request->tgl_pengumpulan : $project->tgl_pengumpulan,
            // Periksa apakah link_project sudah terisi sebelum memperbarui
            'link_project' => $request->filled('link_project') ? $request->link_project : $project->link_project,
            'status' => $request->filled('status') ? $request->status : $project->status,
            'feedback' => $request->filled('feedback') ? $request->feedback : $project->feedback,
        ];

        ProjectModel::where('uid', $id)->update($dataToUpdate);

        // Assuming you have a route named 'data-project.index' that expects a parameter named 'lowongan_id'
        return redirect()->route('data-project.index', ['uid' => $request->uid])->with('success', 'Berhasil update data project');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $lowongan_uid)
    {
        ProjectModel::where('uid', $id)->delete();
        return redirect()->route('data-project.index', ['uid' => $lowongan_uid])->with('success', 'Berhasil hapus project');
    }


    public function updateStatusAndFeedback(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'feedback' => 'required',
            'deadline' => 'required_if:status,2|date', // Deadline wajib jika status adalah 2
        ]);

        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        // Ambil deadline lama
        // $oldDeadline = ProjectModel::where('uid', $id)->value('deadline');

        $dataToUpdate = [
            'status' => $request->status,
            'feedback' => $request->feedback,
        ];

        // Jika status adalah 2, set deadline menjadi deadline baru
        if ($request->status == 2) {
            $dataToUpdate['deadline'] = $request->deadline;
            $dataToUpdate['tgl_pengumpulan'] = null;
            $dataToUpdate['link_project'] = null;
        }

        ProjectModel::where('uid', $id)->update($dataToUpdate);

        // Ambil uid lowongan dari proyek yang diperbarui
        return redirect()->route('data-project.index', ['uid' => $request->uid])->with('success', 'Berhasil update data project');
    }

    public function updateProjectPeserta(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tgl_pengumpulan',
            'link_project',
        ]);

        // Response error validation
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        // Update project
        $project = ProjectModel::where('uid', $id)->first();

        if (!$project) {
            return Redirect::back()->with('error', 'Project tidak ditemukan');
        }

        $project->update([
            'tgl_pengumpulan' => $request->tgl_pengumpulan,
            'link_project' => $request->link_project,
        ]);

        // Redirect to the project list page for the specific magang_uid
        return redirect()->route('project.index', ['magang_uid' => $project->magang->uid])->with('success', 'Berhasil update data');
    }
}
