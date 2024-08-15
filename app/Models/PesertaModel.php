<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PesertaModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "peserta";
    protected $fillable = [
        'uid',
        'user_id',
        'nama',
        'alamat',
        'jenis_kelamin',
        'no_hp',
        'pendidikan_terakhir',
        'institusi_pendidikan_terakhir',
        'prodi',
        'ipk',
        'tanggal_mulai_studi',
        'tanggal_berakhir_studi',
        'kartu_identitas_studi',
        'image',
    ];

    // protected $appends = ['mentor'];
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

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function magang()
    {
        return $this->hasOne(MagangModel::class, 'peserta_id');
    }
    public function logbook()
    {
        return $this->hasManyThrough(LogbookModel::class, MagangModel::class, 'peserta_id', 'magang_id');
    }
    public function project()
    {
        return $this->hasManyThrough(ProjectModel::class, MagangModel::class, 'peserta_id', 'magang_id');
    }
}
