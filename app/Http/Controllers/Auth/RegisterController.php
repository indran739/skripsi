<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Desa;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data = [])
    {
        $defaultData = [
            'id_opd_fk' => '3',
            'role' => 'pengadu',
            'jabatan' => 'tidak ada',
            'verification' => 'P'
        ];

        $data = array_merge($defaultData, $data);

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nik' => ['required', 'max:16', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'id_opd_fk' => ['required'],
            'id_kecamatan_fk' => ['required'],
            'id_desa_fk' => ['required'],
            'alamat' => ['required','string'],
            'tempat_lahir' => ['required','string'],
            'tanggal_lahir' => ['required','string'],
            'jenis_kelamin' => ['required','string'],
            'agama' =>  ['required','string'],
            'pekerjaan' => ['required','string'],
            'gol_darah' => ['required','string'],
            'no_hp' =>['required','string'],
            'verification' =>['required','string'],
            'status_pernikahan' =>['required','string'],
            'role' => ['required'],
            'foto_wajah' => ['image'],
            'foto_ktp' => ['image'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $defaultData = [
            'id_opd_fk' => '3',
            'role' => 'pengadu',
            'verification' => 'P'
        ];
        
        $data = array_merge($defaultData, $data);
        // Mendapatkan id_kelurahan_fk berdasarkan id_desa_fk
        $desa = Desa::find($data['id_desa_fk']);
        $idKelurahanFk = $desa->kelurahan->id; // Menggunakan relasi untuk mendapatkan id_kelurahan_fk
        

        if ($data['foto_wajah']) {
            $path = $data['foto_wajah']->store('profile-fotos');
            $data['foto_wajah'] = $path;
        }
        if ($data['foto_ktp']) {
            $path = $data['foto_ktp']->store('fotos_ktp');
            $data['foto_ktp'] = $path;
        }

        $formattedTanggalLahir = Carbon::createFromFormat('d/m/Y', $data['tanggal_lahir'])->format('Y-m-d');

        $user = User::create([
            'name' => $data['name'],
            'nik' => $data['nik'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_kecamatan_fk' => $data['id_kecamatan_fk'],
            'id_kelurahan_fk' => $idKelurahanFk,
            'id_desa_fk' => $data['id_desa_fk'],
            'id_opd_fk' => $data['id_opd_fk'],
            'alamat' => $data['alamat'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $formattedTanggalLahir,
            'jenis_kelamin' => $data['jenis_kelamin'],
            'agama' => $data['agama'],
            'pekerjaan' => $data['pekerjaan'],
            'gol_darah' => $data['gol_darah'],
            'no_hp' => $data['no_hp'],
            'verification' => $data['verification'],
            'status_pernikahan' => $data['status_pernikahan'],
            'role' => $data['role'],
            'foto_wajah' => $data['foto_wajah'],
            'foto_ktp' => $data['foto_ktp'],
        ]);
        return $user;
    }
}
