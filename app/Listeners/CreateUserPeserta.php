<?php

namespace App\Listeners;

use App\Models\PesertaModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;

class CreateUserPeserta
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    // public function handle(Registered $event)
    // {
    //     // Cek apakah pengguna memiliki role 2 (peserta)
    //     if ($event->user->role_id == 2) {
    //         PesertaModel::create([
    //             'uid' => \Illuminate\Support\Str::uuid(), // Berikan nilai 'uid' dengan UUID yang unik
    //             'user_id' => $event->user->id,
    //             // Tambahkan kolom lain jika perlu
    //             'nama' => $event->user->name,
    //             'jenis_kelamin' => null,
    //             'alamat' => null,
    //             'no_hp' => null,
    //             'pendidikan_terakhir' => null,
    //             'institusi_pendidikan_terakhir' => null,
    //             'tanggal_mulai_studi' => null,
    //             'tanggal_berakhir_studi' => null,
    //             'kartu_identitas_studi' => null,
    //             'image' => null,
    //         ]);
    //     }
    // }
    public function handle(Registered $event)
    {
        // Cek apakah pengguna memiliki role 2 (peserta)
        if ($event->user->role_id == 2) {
            // Cek apakah user_id sudah ada di tabel peserta
            $existingPeserta = PesertaModel::where('user_id', $event->user->id)->first();

            if (!$existingPeserta) {
                PesertaModel::create([
                    'uid' => \Illuminate\Support\Str::uuid(), // Berikan nilai 'uid' dengan UUID yang unik
                    'user_id' => $event->user->id,
                    // Tambahkan kolom lain jika perlu
                    'nama' => $event->user->name,
                    'jenis_kelamin' => null,
                    'alamat' => null,
                    'no_hp' => null,
                    'pendidikan_terakhir' => null,
                    'institusi_pendidikan_terakhir' => null,
                    'prodi' => null,
                    'ipk' => null,
                    'tanggal_mulai_studi' => null,
                    'tanggal_berakhir_studi' => null,
                    'kartu_identitas_studi' => null,
                    'image' => null,
                ]);
            }
        }
    }
}
