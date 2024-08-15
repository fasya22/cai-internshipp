<?php

namespace App\Models;

use App\Models\Master\PeriodeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LogbookModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "logbook";

    protected $fillable = [
        'uid',
        'magang_id',
        'tanggal',
        'aktivitas',
        'status',
        'feedback'
    ];

    protected $appends = ['magang'];

    public function magang()
    {
        return $this->belongsTo(MagangModel::class, 'magang_id');
    }

    public function getMagangAttribute()
    {
        if (array_key_exists('magang_id', $this->attributes)) {
            return MagangModel::with(['peserta', 'mentor'])->find($this->attributes['magang_id']);
        }

        return null;
    }

    public function peserta()
    {
        return $this->belongsTo(PesertaModel::class, 'magang_id');
    }
    public function lowongan()
    {
        return $this->belongsTo(LowonganModel::class, 'magang_id');
    }
    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id');
    }
}
