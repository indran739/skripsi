<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category_fk');   
    }   

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'id_opd_fk');   
    }       

    public function user()
    {
    return $this->belongsTo(User::class, 'id_user_fk'); 
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class);
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
        return $this->hasMany(Likes::class,'id_pengaduan_fk');
    }
    
}
