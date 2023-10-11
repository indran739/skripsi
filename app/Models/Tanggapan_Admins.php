<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tanggapan_Admins extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'tanggapan_admins';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user_fk', 'id'); 
    }
    
}

