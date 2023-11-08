<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Pengadu;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PDFController;
use App\Models\Kecamatan;
use App\Models\Desa;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home', [
//         "title" => "Beranda"]);
// });

// Route::get('/daftar', function () {
//     return view('daftar', [
//         "title" => "Daftar"
//     ]);
// });

// Route::get('/listpengaduan', function () {
//     return view('pengaduan', [
//         "title" => "List Pengaduan"
//     ]);
// });

// Route::get('/tentangkami', function () {
//     return view('about', [
//         "title" => "Tentang Kami"
//     ]);
// });

// Route::get('login',[LoginController::class, 'index'])->name('login');

Route::get('/', function () {
    return view('auth.login');})->middleware('guest');

    
Route::get('/pdf', function () {
    return view('pdf');})->middleware('guest');

    
Route::get('/data', function () {
        return view('data');})->middleware('guest');

Route::get('/daftar', function () {
    return view('auth.register',[
        "kecamatans" => Kecamatan::all(),
        "desas" => Desa::all()
    ]);})->middleware('guest');

Route::get('/test', function () {
        return view('layouts.main_opd');})->middleware('guest');

Route::get('/tentangkami', function () {
        return view('about', [
            'active' => 'about'
        ]);})->middleware('guest');

Route::middleware(['guest'])->group(function () {
    Route::post('daftarakun', [Pengadu::class, 'daftar_akun'])->name('regist');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

    Route::middleware(['admininspektorat'])->group(function () {
        Route::get('admininspektorat', [Admin::class, 'index']);
        Route::get('admininspektorat/chart-data', [Admin::class, 'chartPengaduanCategories']);
        Route::get('admininspektorat/chart-opd', [Admin::class, 'chartPengaduanOpd']);
        Route::get('admininspektorat/get-opd-averages', [Admin::class, 'getOpdAverages']);

        Route::get('laporanmasuk', [Admin::class, 'view_laporan_masuk']);
        Route::get('laporanterdisposisi', [Admin::class, 'view_laporan_terdisposisi']);
        Route::get('laporanselesai', [Admin::class, 'view_laporan_selesai']);
        Route::get('userpengadu', [Admin::class, 'view_user_pengadu']);
        Route::get('useradmin', [Admin::class, 'view_user_admin']);
        Route::get('detailpengaduanadmin/{id_pengaduan}', [Admin::class, 'showDataDetail']);
        Route::put('disposisi/{id_pengaduan}', [Admin::class, 'disposisi']);
        Route::get('kategori', [Admin::class, 'view_kategori']);
        Route::get('tambahkategori', [Admin::class, 'view_tambahkategori']);
        Route::post('storekategori', [Admin::class, 'store_kategori']);
        Route::put('verifikasiakun/{id_user}', [Admin::class, 'verifikasi_akun']);
        Route::post('storetanggapan', [Admin::class, 'store_tanggapan']);
        Route::get('detailprofile/{id_user}', [Admin::class, 'showProfile']);
        Route::put('edittanggapan/{id_tanggapan}', [Admin::class, 'edittanggapan']);
        Route::post('hapustanggapan/{id_tanggapan}', [Admin::class, 'hapustanggapan']);
        Route::put('editkategori/{id_categories}', [Admin::class, 'edit_kategori']);
        Route::post('hapuskategori/{id_categories}', [Admin::class, 'hapus_kategori']);
        Route::post('tambahadmin', [Admin::class, 'tambah_admin']);
        Route::get('laporanselesai/filter', [Admin::class, 'filterLaporanSelesai'])->name('laporanselesai.filter');
        Route::post('/cetak-pdf', [PDFController::class, 'cetakPDF']);
        Route::post('/cetak-laporan-belumtanggap', [PDFController::class, 'cetakLaporanBelumTanggap']);
        Route::post('/cetak-laporan-kinerja', [PDFController::class, 'cetakLaporanKinerja']);
        Route::get('/search', [Admin::class, 'search']);
        Route::put('suspendedakun/{id_user}', [Admin::class, 'suspend_akun']);
        Route::post('hapususer/{id_user}', [Admin::class, 'delete_user']);
        Route::post('delete_admin/{id_user}', [Admin::class, 'delete_user']);
        Route::put('edituseradmin/{id_user}', [Admin::class, 'update_user_admin']);
        Route::get('/searchpengadu', [Admin::class, 'searchUserPengadu']);

        // Route::get('/admininspektorat/chart', [DashboardController::class, 'index']);
        // Route::get('/admininspektorat/chart-data', [DashboardController::class, 'chartData']);
        // Route::get('/admininspektorat/chart-data-opd', [DashboardController::class, 'chartDataOpd']);
        // Route::get('/admininspektorat/get-opd-averages', [DashboardController::class, 'getOpdAverages']);
        // Route::get('/admininspektorat/search', [DashboardController::class, 'view_search']);
        // Route::get('/search', [DashboardController::class, 'search']);

    });

    Route::middleware(['adminopd'])->group(function () {
        Route::get('adminopd', [OpdController::class, 'index']);
        Route::get('adminopd/chart-data', [OpdController::class, 'chartPengaduanCategories']);
        Route::get('adminopd/chart-opd', [OpdController::class, 'chartPengaduanOpd']);
        Route::get('adminopd/chart-opd-line', [OpdController::class, 'chartPengaduanLine']);
        Route::get('/laporanterdisposisiopd', [OpdController::class, 'view_laporan_terdisposisi']);
        Route::get('laporanselesaiopd', [OpdController::class, 'view_laporan_selesai']);
        Route::get('userpengaduopd', [OpdController::class, 'view_user_pengadu']);
        Route::get('detailpengaduanopd/{id_pengaduan}', [OpdController::class, 'showDataDetail']);
        Route::put('validasi/{id_pengaduan}', [OpdController::class, 'validasi']);
        Route::get('tindaklanjutpage/{id_pengaduan}', [OpdController::class, 'view_tindak_lanjut']);
        Route::put('prosestindak/{id_pengaduan}', [OpdController::class, 'proses_tindak']);
        Route::put('statusselesai/{id_pengaduan}', [OpdController::class, 'status_selesai']);
        Route::post('storetanggapanopd', [OpdController::class, 'store_tanggapan']);
        Route::put('edittanggapanopd/{id_tanggapan}', [OpdController::class, 'edittanggapanopd']);
        Route::post('hapustanggapanopd/{id_tanggapan}', [OpdController::class, 'hapustanggapanopd']);
        Route::get('laporanselesaiopd/filter', [OpdController::class, 'filterLaporanSelesai'])->name('laporanselesaiopd.filter');
        Route::post('/cetak-laporan-belumtanggapopd', [PDFController::class, 'cetakLaporanBelumTanggapOpd']);
        Route::post('/cetak-laporan-selesai-opd', [PDFController::class, 'cetakLaporanSelesaiOpd']);
        Route::get('/searchopd', [OpdController::class, 'searchOpd']);
        Route::put('/editkategorilaporan/{id_pengaduan}', [OpdController::class, 'updatekategorilaporanselesai']);
    });

    Route::middleware(['pengadu'])->group(function () {
        Route::get('halamanpending', [Pengadu::class, 'halaman_pending']);
        // Route::put('editdatapengadu/{id_user}', [Pengadu::class, 'editdatapengadu']);
        Route::put('editdataregister/{id_user}', [Pengadu::class, 'editdataregister']);
        // Route::get('editdatapengadu', [Pengadu::class, 'editdatapengadu']);
    });
    
    Route::middleware(['pengadu','verification'])->group(function () {
        Route::get('berandapengadu', [Pengadu::class, 'index']);
        Route::get('formpengaduan', [Pengadu::class, 'view_form']);
        Route::get('laporanterkirim', [Pengadu::class, 'view_laporan_terkirim']);
        Route::get('laporanselesaipengadu', [Pengadu::class, 'view_laporan_selesai']);
        Route::get('detailpengaduan/{id}', [Pengadu::class, 'view_detail_pengaduan']);
        Route::get('profilepengadu', [Pengadu::class, 'view_profile']);
        Route::put('editprofile/{id_user}', [Pengadu::class, 'editprofile']);
        Route::post('store', [Pengadu::class, 'store_pengaduan']);
        Route::post('search', [Pengadu::class, 'search']);
        Route::get('editpengaduan/{id_pengaduan}', [Pengadu::class, 'view_edit_pengaduan'])->middleware('check-ownership');
        Route::put('editlaporan/{id_pengaduan}', [Pengadu::class, 'update_pengaduan']);
        Route::get('editpengaduaninvalid/{id_pengaduan}', [Pengadu::class, 'view_edit_pengaduan_invalid'])->middleware('check-ownership');
        Route::put('editlaporaninvalid/{id_pengaduan}', [Pengadu::class, 'update_pengaduan_invalid']);
        Route::get('/search-pengadu', [Pengadu::class, 'search']);
        Route::get('/search-laporan-selesai', [Pengadu::class, 'searchLaporanSelesai']);
    });

});



// Route::put('disposisi/{id_pengaduan}', [Admin::class, 'disposisi']);

// Route::controller(LoginController::class)->group(function(){
//     Route::get('login','index')->name('login');
//     Route::post('login/proses','proses');
//     Route::get('logout','logout');
// });

// Route::group(['middleware' => ['auth']],function(){

//     Route::group(['middleware' => ['cekUser::3']],function(){
//         Route::resource('pengadu',Pengadu::class);
//     });

//     Route::group(['middleware' => ['cekUser::1']],function(){
//         Route::resource('admin', Admin::class);
//     });
// });

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
