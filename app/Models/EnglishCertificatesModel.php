<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnglishCertificatesModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "english_certificates";
    protected $fillable = [
        'uid',
        'jenis_sertifikat',
        'nilai_minimum',
    ];

}
