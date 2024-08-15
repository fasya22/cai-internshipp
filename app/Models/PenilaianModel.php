<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Master\AspekModel;

class PenilaianModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "penilaian";
    protected $fillable = [
        'uid',
        'magang_id',
        'nilai',
        'total_nilai',
    ];

    // Cast atribut 'nilai' ke dalam bentuk array
    protected $casts = [
        'nilai' => 'array',
    ];

    // Relasi dengan model MagangModel
    public function magang()
    {
        return $this->belongsTo(MagangModel::class, 'magang_id');
    }

    // Relasi dengan model PesertaModel
    public function peserta()
    {
        return $this->belongsTo(PesertaModel::class, 'magang_id');
    }

    // Relasi dengan model LowonganModel
    public function lowongan()
    {
        return $this->belongsTo(LowonganModel::class, 'magang_id');
    }

    // Atribut accessor untuk menghitung total_nilai berdasarkan nilai aspek
    public function getTotalNilaiAttribute()
    {
        $nilaiArray = json_decode($this->attributes['nilai'], true); // Ubah JSON menjadi array asosiatif

        if (!empty($nilaiArray) && is_array($nilaiArray)) {
            $aspeks = AspekModel::all();
            $totalNilai = 0;

            foreach ($aspeks as $aspek) {
                if (isset($nilaiArray[$aspek->id])) {
                    $nilai = $nilaiArray[$aspek->id];
                    $bobot = $aspek->bobot / 100; // Mengubah bobot menjadi persentase
                    $totalNilai += $nilai * $bobot; // Perkalian nilai dengan bobot persen
                }
            }

            return $totalNilai;
        }

        return 0; // Kembalikan 0 jika $nilaiArray kosong atau tidak valid
    }



    // Metode untuk mengupdate 'total_nilai' berdasarkan nilai aspek yang baru
// public function updateTotalNilai()
// {
//     $nilaiArray = $this->attributes['nilai']; // Asumsi bahwa 'nilai' sudah berupa array

//     if (!empty($nilaiArray) && is_array($nilaiArray)) {
//         $totalNilai = 0;
//         $aspeks = AspekModel::all();

//         foreach ($aspeks as $aspek) {
//             if (isset($nilaiArray[$aspek->id])) {
//                 $nilai = $nilaiArray[$aspek->id];
//                 $bobot = $aspek->bobot;
//                 $totalNilai += $nilai * ($bobot / 100); // Hitung nilai berbobot
//             }
//         }

//         $this->total_nilai = $totalNilai; // Simpan total nilai berbobot
//         $this->save(); // Simpan perubahan ke database
//     }
// }

}
