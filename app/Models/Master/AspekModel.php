<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AspekModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "aspek_penilaian";
    protected $fillable = [
        'uid',
        'aspek',
        'bobot',
    ];
}
