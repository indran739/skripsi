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
    
}
