<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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
    ];

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
    }

    public function tanggapan_admin()
    {
        return $this->hasMany(Tanggapan_Admins::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class,'id_opd_fk'); 
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'id_kecamatan_fk'); 
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class,'id_kelurahan_fk'); 
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class,'id_desa_fk'); 
    }

    public function likes()
    {
        return $this->hasMany(Likes::class,'id_user_fk');
    }

}
