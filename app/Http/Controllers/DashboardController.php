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
use App\Models\Likes;
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

        // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
        $selectedYearOpd = Carbon::now()->year;
        $opdCounts = [];

        foreach ($opds as $opd) {
            $countLaporanSelesai = Pengaduan::whereHas('opd', function ($query) use ($opd) {
                $query->where('id', $opd->id);
            })
            ->where('disposisi_opd', 'Y')
            ->where('status_selesai', 'Y')
            ->where('validasi_laporan', 'Y')
            ->where('proses_tindak', 'Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->count();

            $countLaporanTindak = Pengaduan::whereHas('opd', function ($query) use ($opd) {
                $query->where('id', $opd->id);
            })
            ->where('disposisi_opd', 'Y')
            ->where('status_selesai', NULL)
            ->where('validasi_laporan', 'Y')
            ->where('proses_tindak', 'Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->count();

            $countLaporanBelum = Pengaduan::whereHas('opd', function ($query) use ($opd) {
                $query->where('id', $opd->id);
            })
            ->where('status_selesai', NULL)
            ->where('proses_tindak', 'P')
            ->whereNotNull('validasi_laporan')
            ->where('disposisi_opd', '!=', 'P')
            ->where('disposisi_opd', '!=', 'N')
            ->whereYear('tanggal_lapor', $selectedYear)
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


        $opdAverages = [];

        foreach ($opds as $opd) {
            // $completedPengaduan = Pengaduan::where('status_selesai', 'Y')->where('id_opd_fk', $opd->id)->get();
            $completedPengaduan = Pengaduan::where('status_selesai', 'Y')
            ->where('id_opd_fk', $opd->id)
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get();

            $totalDuration = 0;
            $completedCount = $completedPengaduan->count();

            foreach ($completedPengaduan as $pengaduan) {
                $createdAt = Carbon::parse($pengaduan->tanggal_tindak);
                $resolvedAt = Carbon::parse($pengaduan->tgl_dinyatakan_selesai);
                $duration = $resolvedAt->diffInHours($createdAt);
                $totalDuration += $duration;
            }
            
            $pengaduan = Pengaduan::whereNotNull('tanggal_validasi')
            ->where('status_selesai', 'Y')
            ->where('id_opd_fk', $opd->id)
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get();

            $totalWaktuRespon = 0;
            $jumlahPengaduan = 0;

            foreach ($pengaduan as $aduan) {
                $waktuPenerimaan = Carbon::parse($aduan->tanggal_disposisi);
                $waktuValidasi = Carbon::parse($aduan->tanggal_validasi);

                // Menghitung selisih waktu dalam jam dari penerimaan hingga validasi
                $selisihValidasi = $waktuPenerimaan->diffInHours($waktuValidasi);

                // Menambahkan selisih waktu ke total waktu respon
                $totalWaktuRespon += $selisihValidasi;// Rata-rata waktu respon disposisi dan validasi
                $jumlahPengaduan++;
            }

            // Menghitung rata-rata waktu respon
            $rataRataWaktuRespon = $jumlahPengaduan > 0 ? $totalWaktuRespon / $jumlahPengaduan : 0;
            $rataRataWaktuRespon = number_format( $rataRataWaktuRespon, 1);

            // Menghitung rata-rata waktu penyelesaian
            $averageDuration = ($completedCount > 0) ? ($totalDuration / $completedCount) : 0;
            $averageDuration = number_format($averageDuration, 1);
            
            $totalDuration = number_format($totalDuration, 1);
            $totalWaktuRespon = number_format($totalWaktuRespon, 1);

            $count_laporan_diselesai = Pengaduan::where('disposisi_opd','Y')
            ->where('status_selesai','Y')
            ->where('validasi_laporan','Y')
            ->where('proses_tindak','Y')
            ->where('id_opd_fk', $opd->id)
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get()
            ->count();

            
            // Hanya simpan data jika rata-rata waktu penyelesaian lebih dari 0
            if ($averageDuration > 0 && $rataRataWaktuRespon > 0 && $totalDuration > 0 && $totalWaktuRespon > 0 && $count_laporan_diselesai > 0) {
                $opdAverages[] = [
                    'opd_name' => $opd->name,
                    'average_duration' => $averageDuration,
                    'completed_duration' => $totalDuration,
                    'respons_duration' => $totalWaktuRespon,
                    'rataRataWaktuRespon' => $rataRataWaktuRespon,
                    'count_laporan_selesai' => $count_laporan_diselesai,
                ];
            }
        }

        $laporans = Pengaduan::orderBy('tanggal_lapor', 'desc')->where('status_selesai','Y')->whereYear('tanggal_lapor', Carbon::now())->paginate(10);
        // Mengembalikan data ke tampilan (view)
        return view('admininspektorat.dashboardgrafik', [
            'categoryNames' => $categoryNames,
            'categoryCounts' => $categoryCounts,
            'data' => $data,
            'laporans' => $laporans,
            'selectedYear' => $selectedYear,
            'active' => 'beranda',
            'opdCounts' => $opdCounts,
            'opdAverages' => $opdAverages,
        ]);

    }

    
public function view_likes()
{
    $laporans = Pengaduan::orderBy('tanggal_lapor', 'desc')->where('status_selesai','Y')->whereYear('tanggal_lapor', Carbon::now())->paginate(10);

    return view('pengadu.likes', [
        'laporans' => $laporans,
    ]);

}

public function like(Request $request)
{
    // Lakukan validasi dan verifikasi user
    $like = Likes::create([
        'id_user_fk' => auth()->user()->id,
        'id_pengaduan_fk' => $request->id_pengaduan_fk,
    ]);

   // Kembali ke halaman sebelumnya
   return redirect()->back()->with('success', 'Liked successfully');
}

public function unlike(Request $request)
{
    // Lakukan validasi dan verifikasi user
    Likes::where('id_user_fk', auth()->user()->id)
        ->where('id_pengaduan_fk', $request->id_pengaduan_fk)
        ->delete();

        return redirect()->back()->with('success', 'Unliked successfully');
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
   $selectedYearOpd = $request->input('year', Carbon::now()->year);

   // Kueri database berdasarkan tahun yang dipilih
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
       ->whereYear('tanggal_lapor', $selectedYearOpd)
       ->count();

       $countLaporanTindak = Pengaduan::whereHas('opd', function ($query) use ($opd) {
           $query->where('id', $opd->id);
       })
       ->where('disposisi_opd', 'Y')
       ->where('status_selesai', NULL)
       ->where('validasi_laporan', 'Y')
       ->where('proses_tindak', 'Y')
       ->whereYear('tanggal_lapor', $selectedYearOpd)
       ->count();

       $countLaporanBelum = Pengaduan::whereHas('opd', function ($query) use ($opd) {
           $query->where('id', $opd->id);
       })
       ->where('status_selesai', NULL)
       ->where('proses_tindak', 'P')
       ->whereNotNull('validasi_laporan')
       ->where('disposisi_opd', '!=', 'P')
       ->where('disposisi_opd', '!=', 'N')
       ->whereYear('tanggal_lapor', $selectedYearOpd)
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

   return response()->json($opdCounts);


}


public function getOpdAverages(Request $request)
    {
        $selectedYear = $request->input('year');

        $opds = OPD::all();

        $opdAverages = []; // Logika pengambilan data berdasarkan tahun

        foreach ($opds as $opd) {
            // $completedPengaduan = Pengaduan::where('status_selesai', 'Y')->where('id_opd_fk', $opd->id)->get();
            $completedPengaduan = Pengaduan::where('status_selesai', 'Y')
            ->where('id_opd_fk', $opd->id)
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get();

            $totalDuration = 0;
            $completedCount = $completedPengaduan->count();

            foreach ($completedPengaduan as $pengaduan) {
                $createdAt = Carbon::parse($pengaduan->tanggal_tindak);
                $resolvedAt = Carbon::parse($pengaduan->tgl_dinyatakan_selesai);
                $duration = $resolvedAt->diffInHours($createdAt);
                $totalDuration += $duration;
            }
            
            $pengaduan = Pengaduan::whereNotNull('tanggal_validasi')
            ->where('status_selesai', 'Y')
            ->where('id_opd_fk', $opd->id)
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get();

            $totalWaktuRespon = 0;
            $jumlahPengaduan = 0;

            foreach ($pengaduan as $aduan) {
                $waktuPenerimaan = Carbon::parse($aduan->tanggal_disposisi);
                $waktuValidasi = Carbon::parse($aduan->tanggal_validasi);

                // Menghitung selisih waktu dalam jam dari penerimaan hingga validasi
                $selisihValidasi = $waktuPenerimaan->diffInHours($waktuValidasi);

                // Menambahkan selisih waktu ke total waktu respon
                $totalWaktuRespon += $selisihValidasi;// Rata-rata waktu respon disposisi dan validasi
                $jumlahPengaduan++;
            }

            // Menghitung rata-rata waktu respon
            $rataRataWaktuRespon = $jumlahPengaduan > 0 ? $totalWaktuRespon / $jumlahPengaduan : 0;
            $rataRataWaktuRespon = number_format( $rataRataWaktuRespon, 1);

            // Menghitung rata-rata waktu penyelesaian
            $averageDuration = ($completedCount > 0) ? ($totalDuration / $completedCount) : 0;
            $averageDuration = number_format($averageDuration, 1);
            
            $totalDuration = number_format($totalDuration, 1);
            $totalWaktuRespon = number_format($totalWaktuRespon, 1);

            $count_laporan_diselesai = Pengaduan::where('disposisi_opd','Y')
            ->where('status_selesai','Y')
            ->where('validasi_laporan','Y')
            ->where('proses_tindak','Y')
            ->where('id_opd_fk', $opd->id)
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get()
            ->count();

            
            // Hanya simpan data jika rata-rata waktu penyelesaian lebih dari 0
            if ($averageDuration > 0 && $rataRataWaktuRespon > 0 && $totalDuration > 0 && $totalWaktuRespon > 0 && $count_laporan_diselesai > 0) {
                $opdAverages[] = [
                    'opd_name' => $opd->name,
                    'average_duration' => $averageDuration,
                    'completed_duration' => $totalDuration,
                    'respons_duration' => $totalWaktuRespon,
                    'rataRataWaktuRespon' => $rataRataWaktuRespon,
                    'count_laporan_selesai' => $count_laporan_diselesai,
                ];
            }
        }

        return response()->json($opdAverages);
    }


}
