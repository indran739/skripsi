<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user_fk');
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class,'id_pengaduan_fk');
    }

}
