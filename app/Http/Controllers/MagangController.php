<?php

namespace App\Http\Controllers;

use App\Models\LowonganModel;
use App\Models\MagangModel;
use App\Models\MentorModel;
use Illuminate\Http\Request;

class MagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil peserta_id dari pengguna yang sedang login
        $pesertaId = auth()->user()->peserta->id;

        // Ambil data magang berdasarkan peserta_id
        $magang = MagangModel::where('peserta_id', $pesertaId)->first();

        // Ambil UID magang atau null jika tidak ada data
        $magang_uid = $magang->uid ?? null;
        return view('dashboard.pages.dashboardkegiatan', compact('magang', 'magang_uid'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($uid)
    {
        $user = auth()->user();

        try {
            $lowongan = LowonganModel::where('uid', $uid)->firstOrFail(); // Cari lowongan berdasarkan UID
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return abort(404); // Tampilkan halaman 404 jika lowongan tidak ditemukan
        }

        if ($user->role_id === 2) {
            // Jika user adalah peserta, ambil data magang berdasarkan peserta_id dan lowongan_id
            $pesertaId = $user->peserta->id;
            $magang = MagangModel::where('peserta_id', $pesertaId)->where('lowongan_id', $lowongan->id)->get();
        } elseif ($user->role_id === 1) {
            // Jika user adalah mentor, ambil data magang berdasarkan lowongan_id
            $magang = MagangModel::where('lowongan_id', $lowongan->id)->get();
        } elseif ($user->role_id === 0) {
            // Jika user adalah mentor, ambil data magang berdasarkan lowongan_id
            $magang = MagangModel::where('lowongan_id', $lowongan->id)->get();
        } else {
            return abort(403); // Tampilkan halaman 403 jika role user tidak valid
        }

        return view('dashboard.pages.dashboardkegiatan', compact('magang', 'lowongan'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
