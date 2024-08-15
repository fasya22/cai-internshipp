<?php

namespace App\Listeners;

// use App\Events\AcceptanceStatusChanged;
// use App\Models\LowonganModel;
// use App\Models\PesertaModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePositionOnAcceptanceStatusChange
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // public function handle(AcceptanceStatusChanged $event)
    // {
    //     $pendaftaran = $event->pendaftaran;

    //     if ($pendaftaran->status_penerimaan == 1) {
    //         $peserta = PesertaModel::find($pendaftaran->peserta_id);

    //         // Ambil instance LowonganModel terkait dengan pendaftaran
    //         $lowongan = LowonganModel::find($pendaftaran->lowongan_id);

    //         if ($peserta && $lowongan) {
    //             $peserta->update(['posisi_id' => $lowongan->posisi_id]);
    //         }
    //     }
    // }
}
