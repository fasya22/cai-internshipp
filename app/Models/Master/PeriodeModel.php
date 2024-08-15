<?php

namespace App\Models\Master;

use App\Models\LowonganModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodeModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "periode";
    protected $fillable = [
        'uid',
        'judul_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'batas_pendaftaran',
    ];

    public function lowongans()
    {
        return $this->hasMany(LowonganModel::class, 'periode_id');
    }
}
