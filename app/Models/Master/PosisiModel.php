<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosisiModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "posisi";
    protected $fillable = [
        'uid',
        'posisi',
    ];
}
