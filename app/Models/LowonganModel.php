<?php

namespace App\Models;

use App\Models\Master\PeriodeModel;
use App\Models\Master\PosisiModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LowonganModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "lowongan";
    protected $fillable = [
        'uid',
        'posisi_id',
        'periode_id',
        'metode',
        'level',
        'deskripsi',
        'kualifikasi',
        'keahlian_yang_dibutuhkan',
        'requires_english',
        'kuota'
    ];

    protected $appends = ['posisi', 'periode'];
    // public function getPosisiAttribute()
    // {
    //     if (array_key_exists('posisi_id', $this->attributes)) {
    //         $kat = DB::table('posisi')->select('posisi')->where('id', $this->attributes['posisi_id'])->first();
    //         if ($kat) {
    //             return $kat->posisi;
    //         }
    //     }

    //     return null;
    // }
    // public function getPeriodeAttribute()
    // {
    //     if (array_key_exists('periode_id', $this->attributes)) {
    //         $periode = DB::table('periode')
    //             ->select('judul_periode', 'tanggal_mulai', 'tanggal_selesai')
    //             ->where('id', $this->attributes['periode_id'])
    //             ->first();

    //         if ($periode) {
    //             return [
    //                 'judul_periode' => $periode->judul_periode,
    //                 'tanggal_mulai' => $periode->tanggal_mulai,
    //                 'tanggal_selesai' => $periode->tanggal_selesai,
    //             ];
    //         }
    //     }

    //     return null;
    // }


    public function posisi()
    {
        return $this->belongsTo(PosisiModel::class, 'posisi_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id');
    }

    // public function magang()
    // {
    //     return $this->hasManyThrough(MagangModel::class, PesertaModel::class, 'lowongan_id', 'peserta_id');
    // }
    public function magang()
    {
        return $this->hasMany(MagangModel::class, 'lowongan_id');
    }
}
