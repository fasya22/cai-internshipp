<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uid',
        'role_id',
        'email_verified_at'
    ];

    protected $appends = ['mentor', 'peserta', 'hrd'];
    public function getMentorAttribute()
    {
        if (array_key_exists('id', $this->attributes)) {
            $mentor = MentorModel::where('user_id', $this->attributes['id'])->first();

            if ($mentor) {
                return $mentor;
            }
        }

        return null;
    }
    public function getHrdAttribute()
    {
        if (array_key_exists('id', $this->attributes)) {
            $hrd = HrdModel::where('user_id', $this->attributes['id'])->first();

            if ($hrd) {
                return $hrd;
            }
        }

        return null;
    }
    public function getPesertaAttribute()
    {
        if (array_key_exists('id', $this->attributes)) {
            $kat = PesertaModel::where('user_id', $this->attributes['id'])->first();

            if ($kat) {
                return $kat;
            }
        }

        return null;
    }

    public function peserta()
    {
        return $this->hasOne(PesertaModel::class, 'user_id');
    }

    public function mentor()
    {
        return $this->hasOne(MentorModel::class, 'user_id');
    }
    public function hrd()
    {
        return $this->hasOne(HrdModel::class, 'user_id');
    }

    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new CustomResetPassword($token));
    // }

    // public function mentor()
    // {
    //     return $this->hasOne(MentorModel::class, 'user_id');
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
