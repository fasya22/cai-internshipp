<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrdModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "hrd";
    protected $fillable = [
        'uid',
        'user_id',
        'nama',
        'jenis_kelamin',
        'level',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
