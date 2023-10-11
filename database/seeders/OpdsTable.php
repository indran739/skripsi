<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opd;

class OpdsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $opds = [
            [   
                'id' => '1',
                'name' => 'Inspektorat Kabupaten Gunung Mas',
                'slug' => 'inspektorat-kabupaten-gunung-mas',
            ],

            [
                'id' => '2',
                'name' => 'Dinas Kesehatan',
                'slug' => 'dinas-kesehatan',
            ],

            [
                'id' => '3',
                'name' => 'Pengadu',
                'slug' => 'pengadu',
            ]
        ];
        foreach($opds as $key => $value){
            Opd::create($value);
        }
    }
}
