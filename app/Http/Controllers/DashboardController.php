<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
Use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Pengaduan;
use App\Models\Category;
use App\Models\Tanggapan;
use App\Models\Tanggapan_Admins;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
         $selectedYear = Carbon::now()->year;

        // Mengambil data Pengaduan dari model Pengaduan
        $pengaduans = Pengaduan::whereYear('tanggal_lapor', $selectedYear)
                                ->where('status_selesai', 'Y')
                                ->get();

        // Mengambil data kategori yang hanya ada di tabel pengaduan
        $categoryIds = $pengaduans->where('disposisi_opd', 'Y')
                                   ->where('status_selesai', 'Y')
                                   ->pluck('id_category_fk')
                                   ->unique();
        $categories = Category::whereIn('id', $categoryIds)->get();

        // Menghitung jumlah pengaduan per kategori
        $categoryCounts = [];
        $categoryNames = [];
        foreach ($categories as $category) {
            $count = $pengaduans->where('id_category_fk', $category->id)->count();
            $categoryCounts[] = $count;
            $categoryNames[] = $category->name;
        }

        // Mengambil OPD yang memiliki pengaduan berstatus selesai ('Y')
        $opdsWithSelesaiPengaduan = Opd::has('pengaduan')
                                       ->whereHas('pengaduan', function ($query) {
                                            $query->where('status_selesai', 'Y');
                                       })
                                       ->get();

        // Menginisialisasi array untuk menyimpan data grafik
        $data = [];

        // Iterasi melalui setiap OPD yang memiliki pengaduan selesai dan menghitung jumlahnya
        foreach ($opdsWithSelesaiPengaduan as $opd) {
            // Menghitung jumlah pengaduan selesai untuk OPD ini
            $totalSelesai = $opd->pengaduan()->where('status_selesai', 'Y')->count();
            // Menambahkan data OPD dan jumlah pengaduan selesai ke dalam array data
            $data[] = ['opd' => $opd->name, 'total_selesai' => $totalSelesai];
        }


        $opds = OPD::all();
        $opdCounts = [];

        foreach ($opds as $opd) {
            $countLaporanSelesai = Pengaduan::whereHas('opd', function ($query) use ($opd) {
                $query->where('id', $opd->id);
            })
            ->where('disposisi_opd', 'Y')
            ->where('status_selesai', 'Y')
            ->where('validasi_laporan', 'Y')
            ->where('proses_tindak', 'Y')
            ->whereYear('tanggal_lapor', Carbon::now()->year)
            ->count();

            $countLaporanTindak = Pengaduan::whereHas('opd', function ($query) use ($opd) {
                $query->where('id', $opd->id);
            })
            ->where('disposisi_opd', 'Y')
            ->where('status_selesai', NULL)
            ->where('validasi_laporan', 'Y')
            ->where('proses_tindak', 'Y')
            ->whereYear('tanggal_lapor', Carbon::now()->year)
            ->count();

            $countLaporanBelum = Pengaduan::whereHas('opd', function ($query) use ($opd) {
                $query->where('id', $opd->id);
            })
            ->where('status_selesai', NULL)
            ->where('proses_tindak', 'P')
            ->whereNotNull('validasi_laporan')
            ->where('disposisi_opd', '!=', 'P')
            ->where('disposisi_opd', '!=', 'N')
            ->whereYear('tanggal_lapor', Carbon::now()->year)
            ->count();

            // Hanya menyimpan data OPD yang memiliki pengaduan
            if ($countLaporanSelesai > 0 || $countLaporanTindak > 0 || $countLaporanBelum > 0) {
                $opdCounts[$opd->name] = [
                    'Selesai' => $countLaporanSelesai,
                    'Tindak Lanjut' => $countLaporanTindak,
                    'Belum Ditindak' => $countLaporanBelum,
                ];
            }
        }   


        // Mengembalikan data ke tampilan (view)
        return view('admininspektorat.dashboardgrafik', [
            'categoryNames' => $categoryNames,
            'categoryCounts' => $categoryCounts,
            'data' => $data,
            'selectedYear' => $selectedYear,
            'active' => 'beranda',
            'opdCounts' => $opdCounts
        ]);

    }

    public function chartData(Request $request)
{
    // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
    $selectedYear = $request->input('year', Carbon::now()->year);

    // Kueri database berdasarkan tahun yang dipilih
    $pengaduans = Pengaduan::whereYear('tanggal_lapor', $selectedYear)
                            ->where('status_selesai', 'Y')
                            ->get();

    // Mengambil data kategori yang hanya ada di tabel pengaduan
    $categoryIds = $pengaduans->where('disposisi_opd', 'Y')
                               ->where('status_selesai', 'Y')
                               ->pluck('id_category_fk')
                               ->unique();
    $categories = Category::whereIn('id', $categoryIds)->get();

    // Menghitung jumlah pengaduan per kategori
    $categoryCounts = [];
    $categoryNames = [];
    foreach ($categories as $category) {
        $count = $pengaduans->where('id_category_fk', $category->id)->count();
        $categoryCounts[] = $count;
        $categoryNames[] = $category->name;
    }



  

    // Mengembalikan data dalam format JSON untuk pembaruan kedua grafik
    return response()->json([
        'categoryNames' => $categoryNames,
        'categoryCounts' => $categoryCounts,
    ]);
}

public function chartDataOpd(Request $request)
{
    // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
    $selectedYear = $request->input('year', Carbon::now()->year);

    // Kueri database berdasarkan tahun yang dipilih
    $opdPengaduans = Opd::withCount([
        'pengaduan as selesai' => function ($query) use ($selectedYear) {
            $query->whereYear('tanggal_lapor', $selectedYear)
                  ->where('status_selesai', 'Y')
                  ->where('disposisi_opd', 'Y')
                  ->where('validasi_laporan', 'Y')
                  ->where('proses_tindak', 'Y');
        },
        'pengaduan as tindakLanjut' => function ($query) use ($selectedYear) {
            $query->whereYear('tanggal_lapor', $selectedYear)
                  ->whereNull('status_selesai')
                  ->where('disposisi_opd', 'Y')
                  ->where('validasi_laporan', 'Y')
                  ->where('proses_tindak', 'Y');
        },
        'pengaduan as belumDitindak' => function ($query) use ($selectedYear) {
            $query->whereYear('tanggal_lapor', $selectedYear)
                  ->whereNull('status_selesai')
                  ->where('proses_tindak', 'P')
                  ->whereNotNull('validasi_laporan')
                  ->whereNotIn('disposisi_opd', ['P', 'N']);
        }
    ])->get();

    // Mengembalikan data dalam format JSON untuk grafik OPD Pengaduan
    return response()->json($opdPengaduans);
}


}
