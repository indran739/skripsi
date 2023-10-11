<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserData extends Seeder
{
    /**
     * Run the database seeds.P
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [   'id_opd_fk' => '2',
                'name' => 'Admin Inpektorat',
                'email' => 'admininspektorat@gmail.com',
                'nik' => '62123',
                'password' => bcrypt('123456'),
                'alamat' => 'jalan mana ya',
                'tempat_lahir' => 'palangkaraya',
                'tanggal_lahir' => '10-11-2001',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Kristen Protestan',
                'no_hp' => '085348657613',
                'pekerjaan' => 'PNS',
                'gol_darah' => 'O',
                'status_pernikahan' => 'Belum Menikah',
                'jabatan' => 'staff',
                'verification' => 'Y',
                'foto_ktp' => '-',
                'foto_wajah' => 'Y',
                'role' =>'admininspektorat'
            ],

            [
                'id_opd_fk' => '1',
                'name' => 'Admin Dinas Kesehatan',
                'email' => 'admindinkes@gmail.com',
                'nik' => '62124',
                'password' => bcrypt('123456'),
                'alamat' =>'jalan mana ya',
                'tempat_lahir' => 'palangkaraya',
                'tanggal_lahir' => '10-11-2001',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Kristen Protestan',
                'no_hp' => '085348657613',
                'pekerjaan' => 'PNS',
                'gol_darah' => 'O',
                'status_pernikahan' => 'Belum Menikah',
                'jabatan' => 'staff',
                'verification' => 'Y',
                'foto_ktp' => '-',
                'foto_wajah' => 'Y',
                'role' =>'adminopd'
            ],
            [
                'id_opd_fk' => '3',
                'name' => 'Indra Nugraha',
                'email' => 'indran@gmail.com',
                'nik' => '62125',
                'password' => bcrypt('123456'),
                'alamat' =>'jalan mana ya',
                'tempat_lahir' => 'palangkaraya',
                'tanggal_lahir' => '10-11-2001',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Kristen Protestan',
                'no_hp' => '085348657613',
                'pekerjaan' => 'Mahasiswa',
                'gol_darah' => 'O',
                'status_pernikahan' => 'Belum Menikah',
                'jabatan' => '-',
                'verification' => 'Y',
                'foto_ktp' => '-',
                'foto_wajah' => 'Y',
                'role' =>'pengadu'
            ],
        ];
        foreach($user as $key => $value){
            User::create($value);
        }
    }
}
