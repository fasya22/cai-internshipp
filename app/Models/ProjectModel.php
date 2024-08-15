<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProjectModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "project";
    protected $fillable = [
        'uid',
        'magang_id',
        'nama_project',
        'deskripsi',
        'deadline',
        'tgl_pengumpulan',
        'link_project',
        'status',
        'feedback',
    ];

    public function magang()
    {
        return $this->belongsTo(MagangModel::class, 'magang_id');
    }

    public function peserta()
    {
        return $this->belongsTo(PesertaModel::class, 'magang_id');
    }

    public function lowongan()
    {
        return $this->belongsTo(LowonganModel::class, 'magang_id');
    }
}
