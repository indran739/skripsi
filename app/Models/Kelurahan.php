<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 

    public function desa()
    {
        return $this->hasMany(Desa::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'id_kecamatan_fk');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
    

}
