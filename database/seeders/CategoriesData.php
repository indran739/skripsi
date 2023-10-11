<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategoriesData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [   
                'id' => '1',
                'name' => 'Kesehatan Masyarakat',
                'slug' => 'kesehatan-masyarakat',
            ],

            [
                'id' => '2',
                'name' => 'Fasilitas Umum',
                'slug' => 'fasilitas-umum',
            ],

            [
                'id' => '3',
                'name' => 'Kebersihan Lingkungan',
                'slug' => 'kebersihan-lingkungan',
            ]
        ];
            foreach($categories as $key => $value){
            Category::create($value);
        }
    }
}
