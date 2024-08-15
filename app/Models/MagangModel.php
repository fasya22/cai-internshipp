<?php

namespace App\Models;

use App\Models\Master\PeriodeModel;
use App\Models\Master\PosisiModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MagangModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "magang";
    protected $fillable = [
        'uid',
        'peserta_id',
        'lowongan_id',
        'mentor_id',
        'surat_lamaran_magang',
        'cv',
        'english_certificate_id',
        'nilai_bahasa_inggris',
        'sertifikat_bahasa_inggris',
        'keahlian_yang_dimiliki',
        'soft_komunikasi',
        'soft_tim',
        'soft_adaptable',
        'link_portfolio',
        'status_rekomendasi',
        'status_penerimaan',
        'nilai_seleksi'
    ];

    protected $casts = [
        'link_portfolio' => 'array', // Jika field ini adalah JSON, maka tambahkan ini
        // ... field lainnya
    ];

    // protected $appends = ['peserta', 'lowongan', 'mentor', 'logbook', 'project', 'periode'];
    // public function getPesertaAttribute()
    // {
    //     if (array_key_exists('peserta_id', $this->attributes)) {
    //         $peserta = DB::table('peserta')->select('nama')->where('id', $this->attributes['peserta_id'])->first();
    //         if ($peserta) {
    //             return $peserta->nama;
    //         }
    //     }

    //     return null;
    // }

    // public function getPesertaAttribute()
    // {
    //     if (array_key_exists('peserta_id', $this->attributes)) {
    //         $peserta = DB::table('peserta')
    //             ->select(
    //                 'nama',
    //                 'alamat',
    //                 'jenis_kelamin',
    //                 'image'
    //             )
    //             ->where('id', $this->attributes['peserta_id'])
    //             ->first();

    //         if ($peserta) {
    //             return [
    //                 'nama' => $peserta->nama,
    //                 'alamat' => $peserta->alamat,
    //                 'jenis_kelamin' => $peserta->jenis_kelamin,
    //                 'image' => $peserta->image,
    //             ];
    //         }
    //     }

    //     return null;
    // }

    public function englishCertificate()
    {
        return $this->belongsTo(EnglishCertificatesModel::class, 'english_certificate_id');
    }

    // public function periode()
    // {
    //     // Tambahkan relasi untuk mengakses periode melalui lowongan
    //     return $this->belongsTo(PeriodeModel::class, 'lowongan_id');
    // }
    public function periode()
    {
        return $this->hasOneThrough(PeriodeModel::class, LowonganModel::class, 'id', 'id', 'lowongan_id', 'periode_id');
    }
    public function posisi()
    {
        return $this->belongsTo(PosisiModel::class, 'lowongan_id');
    }

    public function getMentorAttribute()
    {
        if (array_key_exists('mentor_id', $this->attributes)) {
            $kat = DB::table('mentor')->select('nama')->where('id', $this->attributes['mentor_id'])->first();
            if ($kat) {
                return $kat->nama;
            }
        }

        return null;
    }

    public function mentor()
    {
        return $this->belongsTo(MentorModel::class, 'mentor_id');
    }


    public function peserta()
    {
        return $this->belongsTo(PesertaModel::class, 'peserta_id');
    }

    public function pesertas(): BelongsToMany
    {
        return $this->belongsToMany(PesertaModel::class, 'magang_peserta', 'magang_id', 'peserta_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(LowonganModel::class, 'lowongan_id');
    }


    // public function periode()
    // {
    //     return $this->belongsTo(PeriodeModel::class, 'periode_id');
    // }

    public function logbook()
    {
        return $this->hasMany(LogbookModel::class, 'magang_id');
    }
    public function project()
    {
        return $this->hasMany(ProjectModel::class, 'magang_id');
    }

    public function seleksi()
    {
        return $this->hasOne(SeleksiModel::class, 'magang_id');
    }

    // public function getLowonganAttribute()
    // {
    //     if (array_key_exists('lowongan_id', $this->attributes)) {
    //         $lowongan = DB::table('lowongan')
    //             ->select(
    //                 'lowongan.id as lowongan_id',
    //                 'lowongan.uid',
    //                 'lowongan.posisi_id',
    //                 'lowongan.periode_id',
    //                 'lowongan.metode',
    //                 'lowongan.deskripsi',
    //                 'lowongan.kualifikasi',
    //                 'posisi.posisi as posisi',
    //                 'periode.judul_periode as judul_periode',
    //                 'periode.tanggal_mulai as tanggal_mulai',
    //                 'periode.tanggal_selesai as tanggal_selesai'
    //             )
    //             ->join('posisi', 'lowongan.posisi_id', '=', 'posisi.id')
    //             ->join('periode', 'lowongan.periode_id', '=', 'periode.id')
    //             ->where('lowongan.id', $this->attributes['lowongan_id'])
    //             ->first();

    //         if ($lowongan) {
    //             return [
    //                 'lowongan_id' => $lowongan->lowongan_id,
    //                 'uid' => $lowongan->uid, // Ensure this key exists
    //                 'posisi' => $lowongan->posisi,
    //                 'periode' => [
    //                     'judul_periode' => $lowongan->judul_periode,
    //                     'tanggal_mulai' => $lowongan->tanggal_mulai,
    //                     'tanggal_selesai' => $lowongan->tanggal_selesai,
    //                 ],
    //                 'metode' => $lowongan->metode,
    //                 'deskripsi' => $lowongan->deskripsi,
    //                 'kualifikasi' => $lowongan->kualifikasi,
    //             ];
    //         }
    //     }

    //     return null;
    // }
}
