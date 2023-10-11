<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class Pengaduan 
{
    private static $laporans = [
            [
                "judul" => "Judul Pengaduan Pertama",
                "slug" => "judul-pengaduan-pertama",
                "nama_pengadu" => "Indra Nugraha",
                "isi_laporan" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi hic maxime in minima ipsam dicta, eos, quisquam doloremque, earum porro accusamus? Cumque, corporis harum quae consectetur eveniet vero blanditiis necessitatibus"
            ],
            [
                "judul" => "Judul Pengaduan Kedua",
                "slug" => "judul-pengaduan-kedua",
                "nama_pengadu" => "Meiria Jona Heriska",
                "isi_laporan" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi hic maxime in minima ipsam dicta, eos, quisquam doloremque, earum porro accusamus? Cumque, corporis harum quae consectetur eveniet vero blanditiis necessitatibus"
            ]
        ];

        public static function all()
        {
            return collect(self::$laporans);
        }

        public static function find($slug)
        {
            $laporan = static::all();
            // $new_laporan = [];

            // foreach($laporan as $l) {
            //     if($l["slug"] === $slug ) {
            //         $new_laporan = $l;
            //     }

            // }
            return $laporan->firstWhere('slug', $slug);
        }
        
}
