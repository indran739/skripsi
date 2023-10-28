<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role;
        $verif = Auth::user()->verification;

        if($role == "admininspektorat" && $verif === "Y") { 
            return redirect()->to('admininspektorat');
            }elseif ($role == "pengadu" && $verif === "Y") { //akun terverifikasi dan dapat masuk
                return redirect()->to('berandapengadu');
            }elseif ($role == "pengadu" && $verif === "P") { //halaman pending menunggu verifikasi
                return redirect()->to('halamanpending');
            }elseif ($role == "pengadu" && $verif === "N") { //Akun ditolak
                return redirect()->to('halamanpending');
            }elseif ($role == "pengadu" && $verif === "S") { //Akun disuspend
                return redirect()->to('halamanpending');
            }
            elseif ($role == "adminopd" && $verif === "Y"){
                return redirect()->to('adminopd');
            }
            else
                return redirect()->to('logout');
    }
    
    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();
        return Redirect('login');
    }

    public function daftar() {
        return view('daftar');
    }

}
