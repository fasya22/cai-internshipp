<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MentorModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "mentor";
    protected $fillable = [
        'uid',
        'user_id',
        'nama',
        'jenis_kelamin',
        'posisi_id',
        'level',
        'image',
    ];
    protected $appends = ['posisi'];
    public function getPosisiAttribute()
    {
        if (array_key_exists('posisi_id', $this->attributes)) {
            $kat = DB::table('posisi')->select('posisi')->where('id', $this->attributes['posisi_id'])->first();
            if ($kat) {
                return $kat->posisi;
            }
        }

        return null;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function peserta()
    {
        return $this->hasMany(PesertaModel::class, 'mentor_id');
    }

    // public function magang()
    // {
    //     return $this->hasOne(MagangModel::class, 'peserta_id');
    // }

    public function magang()
    {
        return $this->hasMany(MagangModel::class, 'mentor_id');
    }

    public function logbook()
    {
        return $this->hasManyThrough(LogbookModel::class, MagangModel::class, 'mentor_id', 'magang_id');
    }
    public function project()
    {
        return $this->hasManyThrough(ProjectModel::class, MagangModel::class, 'mentor_id', 'magang_id');
    }
}
