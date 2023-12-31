<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
Use Auth;
use Carbon\Carbon;
use PDF;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Pengaduan;
use App\Models\Category;
use App\Models\Tanggapan;
use App\Models\Tanggapan_Admins;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class Admin extends Controller
{
    public function index()
    {
        $idOpd = Auth::user()->id_opd_fk;
        $opd = Opd::select('name')->where('id', $idOpd)->get();
        
        $count_users = User::where('role','pengadu')->where('verification','Y')->get()->count();

        
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

    
//<---------------------------------------------------------------Grafik Bar Pengaduan----------------------------------------------------------------------------->/            
            $opds = OPD::all();

            // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
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

            // dd($opdCounts);

//<---------------------------------------------------------------End Grafik Bar Pengaduan----------------------------------------------------------------------------->/
//<---------------------------------------------------------------Rata rata waktu----------------------------------------------------------------------------->//

            $opdAverages = [];
            
            // function convertToDaysHoursMinutes($hours) {
            //     $days = floor($hours / 24);
            //     $remainingHours = $hours % 24;
            //     $minutes = round(($remainingHours - floor($remainingHours)) * 60);
            
            //     return "{$days} hari, " . floor($remainingHours) . " jam, {$minutes} menit";
            // }

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

                // // Menghitung rata-rata waktu respon
                // $rataRataWaktuRespon = ($jumlahPengaduan > 0) ? $totalWaktuRespon / $jumlahPengaduan : 0;
                // $rataRataWaktuRespon = convertToDaysHoursMinutes($rataRataWaktuRespon);

                // // Menghitung rata-rata waktu penyelesaian
                // $averageDuration = ($completedCount > 0) ? ($totalDuration / $completedCount) : 0;
                // $averageDuration = convertToDaysHoursMinutes($averageDuration);

                // $totalDuration = convertToDaysHoursMinutes($totalDuration);
                // $totalWaktuRespon = convertToDaysHoursMinutes($totalWaktuRespon);

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
                ->whereYear('tanggal_lapor', Carbon::now()->year)
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

            $laporans = Pengaduan::withCount('likes')
            ->whereYear('tanggal_lapor', now()->year)
            ->orderByDesc('likes_count')
            ->orderByDesc('tanggal_lapor')
            ->limit(3)
            ->get();
            
//<---------------------------------------------------------------End Rata rata waktu----------------------------------------------------------------------------->//
        return view('admininspektorat.dashboard', [
            'count_pengadu' => $count_users,
            'selectedYear' => $selectedYear,
            'active' => 'beranda',
            'opdAverages' => $opdAverages,
            'opdCounts' => $opdCounts,
            'laporans' => $laporans
        ]);
    }
    
    public function chartPengaduanCategories(Request $request)
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

    public function chartPengaduanOPD(Request $request)
    {
        // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
        $selectedYear = $request->input('year', Carbon::now()->year);

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
            if ($countLaporanSelesai > 0 || $countLaporanTindak > 0) {
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

    
    public function view_laporan_masuk() {

        $idOpd = Auth::user()->id_opd_fk;

        $opd =  Opd::select('name')->where('id',$idOpd)->first();
        $laporans_pending = Pengaduan::where('disposisi_opd', 'P')->whereNull('status_selesai')->orderBy('tanggal_lapor', 'desc')->paginate(5);
        $laporans_tolak = Pengaduan::where('disposisi_opd', 'N')->whereNull('status_selesai')->orderBy('tanggal_lapor', 'desc')->paginate(5);
        $laporans_disposisi = Pengaduan::where('disposisi_opd', 'Y')->whereNull('status_selesai')->orderBy('tanggal_lapor', 'desc')->get();
        // $laporans_disposisi = Pengaduan::where('disposisi_opd', 'Y')->whereNull('status_selesai')->orderBy('tanggal_lapor', 'desc')->paginate(5);

        $kategorisDisposisi = Category::whereHas('pengaduan', function ($query) {
            $query->where('disposisi_opd', 'Y')->whereNull('status_selesai');
        })->get();

        $opdDisposisi = Opd::where('name', '!=', 'pengadu')->where('name', '!=', 'Inspektorat Kabupaten Gunung Mas')
        ->whereHas('pengaduan', function ($query) {
            $query->where('disposisi_opd', 'Y')->whereNull('status_selesai');
        })->get(['id', 'name']);

        return view('admininspektorat.laporanmasuk', [
            'opd' => $opd,
            'laporans_pending' => $laporans_pending,
            'laporans_tolak' => $laporans_tolak,
            'laporans_disposisi' => $laporans_disposisi,
            'active' => 'manajemenlaporan',
            'categories' => $kategorisDisposisi,
            'opds' => $opdDisposisi
        ]);
    }

    public function searchLaporanDisposisi(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $category = $request->input('category'); // Ambil nilai kategori dari request
        $opd = $request->input('opd');
    
        $query = Pengaduan::where('isi_laporan', 'like', '%' . $searchTerm . '%');
    
        // Filter berdasarkan kategori jika kategori dipilih
        if ($category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        }
    
        // Filter berdasarkan kategori jika kategori dipilih
        if ($opd) {
            $query->whereHas('opd', function ($query) use ($opd) {
                $query->where('id', $opd);
            });
        }
    
        $results = $query->with('category', 'opd')
                        ->where('disposisi_opd', 'Y')
                        ->whereNull('status_selesai')
                        ->orderBy('tanggal_lapor', 'desc')
                        ->get();
    
        return response()->json(['results' => $results]);
    }

    public function view_laporan_selesai() {

        $idOpd= Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();
        $laporans = Pengaduan::where('status_selesai', 'Y')->orderBy('tanggal_lapor', 'desc')->get();

        return view('admininspektorat.laporanselesai', [
            'opd' => $opd,
            'laporans' => $laporans,
            'active' => 'laporanselesai',
            'categories' => Category::all(),
            'opds' => Opd::where('name', '!=', 'pengadu')->where('name', '!=', 'Inspektorat Kabupaten Gunung Mas')->get(['id', 'name']),
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
    
        $results = Pengaduan::where('status_selesai', 'Y')
            ->where('isi_laporan', 'like', '%' . $searchTerm . '%')
            ->with('category', 'opd')
            ->orderBy('tanggal_lapor', 'desc')
            ->get();
        return response()->json(['results' => $results]);
    }

    public function filterLaporanSelesai(Request $request) 
    {
        $idOpd = $request->input('id_opd_fk');
        $idCategory = $request->input('id_category_fk');

        // Lakukan filter data berdasarkan $idOpd dan $idCategory
        $filteredLaporans = Pengaduan::with(['category', 'opd']) // Memuat relasi category dan opd
            ->where('status_selesai', 'Y')
            ->when($idOpd, function ($query) use ($idOpd) {
                return $query->where('id_opd_fk', $idOpd);
            })
            ->when($idCategory, function ($query) use ($idCategory) {
                return $query->where('id_category_fk', $idCategory);
            })
            ->orderBy('tanggal_lapor', 'desc')
            ->paginate(7);

        return response()->json(['laporans' => $filteredLaporans]); // Pastikan mengirimkan 'laporans' ke frontend
    }


    public function view_user_pengadu() {

        $idOpd= Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();
        $users_pending = User::where('role','pengadu')->where('verification','P')->paginate(7);
        $users_tolak = User::where('role','pengadu')->where('verification','N')->paginate(7);
        $users_verif = User::where('role','pengadu')->where('verification','Y')->paginate(7);
        $users_suspend = User::where('role','pengadu')->where('verification','S')->paginate(7);

        return view('admininspektorat.userpengadu', [
            'opd' => $opd,
            'users' => $users_pending,
            'users_tolak' => $users_tolak,
            'users_verif' => $users_verif,
            'users_suspend' => $users_suspend,
            'active' => 'usermanajemen'
        ]);
    }

    public function searchUserPengadu(Request $request)
    {
        $searchPengadu = $request->input('searchPengadu');
    
        $results = User::where('verification', 'Y')
            ->where(function($query) use ($searchPengadu) {
                $query->where('name', 'like', '%' . $searchPengadu . '%')
                      ->orWhere('nik', 'like', '%' . $searchPengadu . '%');
            })
            ->where('role', 'pengadu')
            ->get();
    
        return response()->json(['results' => $results]);
    }
    

    public function view_user_admin() {

        $idOpd= Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();
        $users = User::where('role','adminopd')->where('verification','Y')->paginate(7);
        

        return view('admininspektorat.useradmin', [
            'opd' => $opd,
            'opds' => Opd::where('name', '!=', 'pengadu')->where('name', '!=', 'Inspektorat Kabupaten Gunung Mas')->get(['id', 'name']),
            'users' => $users,
            'active' => 'useradmin'
        ]);
    }

    public function view_kategori() {

        $idOpd= Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();
        $categories = Category::paginate(10);

        return view('admininspektorat.kategori', [
            'opd' => $opd,
            'categories' => $categories,
            'active' => 'kategori'
        ]);
    }


    public function showDataDisposisi($id)
    {
        $data = Pengaduan::find($id);

        return view('admininspektorat.disposisi', [
            'data' => $data
        ]);
    }

    public function showDataDetail($id)
    {
        $laporan = Pengaduan::find($id);
        $tanggapans = Tanggapan::where('id_pengaduan_fk', $id)->get();

        return view('admininspektorat.detailpengaduan', [
            'laporan' => $laporan,
            'tanggapans' => $tanggapans,
            'active' => 'manajemenlaporan'
        ]);
    }

    public function showProfile($id)
    {
        $data = User::find($id);

        return view('admininspektorat.detailprofileadmin', [
            'data' => $data
        ]);
    }

    public function disposisi(Request $request, $id)
    {
        $disposisi = Pengaduan::find($id);
        
        if($request->disposisi_opd == 'Y'){

            $disposisi->disposisi_opd = $request->disposisi_opd; 

            $disposisi->save();

            $disposisi->tanggal_disposisi = $disposisi->updated_at;
            
            $disposisi->save();

            if($request->tanggapan == NULL){
                return redirect('/laporanmasuk')->with('success', 'Laporan Berhasil terdisposisi');
            }
            else{
                $tanggapan = new Tanggapan();
                $tanggapan->id_user_fk = auth()->user()->id;
                $tanggapan->id_pengaduan_fk = $id;
                $tanggapan->tanggapan = $request->tanggapan;
                $tanggapan->save();
                return redirect('/laporanmasuk')->with('success', 'Laporan Berhasil terdisposisi');
            }

        }else if($request->disposisi_opd == 'N'){
            
            $disposisi->disposisi_opd = $request->disposisi_opd;

            $disposisi->save();

            $disposisi->tanggal_disposisi = $disposisi->updated_at;

            $disposisi->save();

            if($request->tanggapan == NULL){
                return redirect('/laporanmasuk')->with('success', 'Laporan berhasil ditolak');
            }

            else{
                $tanggapan = new Tanggapan();
                $tanggapan->id_user_fk = auth()->user()->id;
                $tanggapan->id_pengaduan_fk = $id;
                $tanggapan->tanggapan = $request->tanggapan;
                $tanggapan->save();
    
                return redirect('/laporanmasuk')->with('success', 'Laporan berhasil ditolak');
            }
             
        }else {
            $disposisi->disposisi_opd = $request->disposisi_opd;

            $disposisi->save();
            return redirect('/laporanmasuk');
        }
    }

    public function store_kategori(Request $request)
    {
       
        $validatedData = $request->validate([
            'name' => 'required|max:50',
        ]);

        Category::create($validatedData);
        return redirect('/kategori')->with('success', 'Berhasil menambah kategori');
    }
    
    public function edit_kategori(Request $request, $id_categories)
    {
        $kategori = Category::find($id_categories);
        $kategori->name = $request->name;
        $kategori->save();
        return redirect('/kategori')->with('success', 'Berhasil mengedit kategori');
    }

    public function hapus_kategori($id_categories)
    {
    // Temukan item berdasarkan ID
    $kategori = Category::findOrFail($id_categories);

    // Hapus item
    $kategori->delete();

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Berhasil menghapus kategori');
    }

    public function verifikasi_akun(Request $request, $id_user)
    {
        $user = User::find($id_user);
        
        if($request->verification == 'Y'){

            $user->verification = $request->verification; 

            $user->save();
            return redirect('/userpengadu')->with('success', 'User berhasil terverifikasi');

        }else if($request->verification == 'N'){

            $user->verification = $request->verification; 

            $user->save();
            
            $tanggapanAdmin = new Tanggapan_Admins();
            $tanggapanAdmin->id_user_fk = $id_user;
            $tanggapanAdmin->tanggapan = $request->tanggapan_admin;
            $tanggapanAdmin->save();

            return redirect('/userpengadu')->with('success', 'Berhasil menolak akun user');
            
        }else {

            $user->verification = $request->verification; 

            $user->save();
            return redirect('/userpengadu');
        }
    }

    public function store_tanggapan(Request $request)
    {
       
        $validatedData = $request->validate([
            
            'id_pengaduan_fk' => 'required',
            'tanggapan' => 'required|max:255',
        ]);
        
        $validatedData['id_user_fk'] = auth()->user()->id;

        Tanggapan::create($validatedData);
        return redirect()->back()->with('success', 'Berhasil menambah tanggapan');
    }
    
    public function edittanggapan(Request $request, $id_tanggapan)
    {
        $edittanggapan = Tanggapan::find($id_tanggapan);

        $edittanggapan->tanggapan = $request->tanggapan;
        $edittanggapan->save();

        return redirect()->back()->with('success', 'Berhasil mengedit tanggapan');
    }

    public function hapustanggapan($id_tanggapan)
{
    // Temukan item berdasarkan ID
    $tanggapan = Tanggapan::findOrFail($id_tanggapan);

    // Hapus item
    $tanggapan->delete();

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Berhasil menghapus tanggapan');
}

public function tambah_admin(Request $request)
{
    // Validasi input pengguna
    $request->validate([
        'nik' => 'required|max:20|unique:users',
        'name' => 'required|max:255',
        'id_opd_fk' => 'required',
        'alamat' => 'required|max:255',
        'email' => 'required|email:dns|unique:users',
        'no_hp' => 'required|max:13',
        'password' => 'required|string|min:8',
    ]);

    try {
        // Membuat objek user dan mengisi bidang-bidangnya
        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'id_opd_fk' => $request->id_opd_fk,
            'alamat' => $request->alamat,
            'id_kecamatan_fk' => '1',
            'id_kelurahan_fk' => '1',
            'id_desa_fk' => '2',
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => 'adminopd',
            'pekerjaan' => 'PNS',
            'jenis_kelamin' => 'Laki-laki',
            'verification' => 'Y',
            'password' => Hash::make($request->password),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil menambah akun');
    } catch (\Exception $e) {
        // Tangani kesalahan jika penyimpanan data gagal
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    }
}

public function suspend_akun(Request $request, $id_user)
{
    $user = User::find($id_user);
    $user->verification = $request->verification;
    $user->save();
    return redirect('/userpengadu')->with('success', 'Berhasil menangguhkan akun');
}

public function delete_user($id_user)
{
    // Temukan item berdasarkan ID
    $user = User::find($id_user);

    $user->delete();

    return redirect()->back()->with('success', 'Berhasil menghapus akun');
}

public function update_user_admin(Request $request, $id)
{
    $user = User::find($id);
    

    if ($request->has('password')) {
        $user->password = bcrypt($request->password);
    }
    
    $user->name = $request->name;
    $user->id_opd_fk = $request->id_opd_fk;
    $user->alamat = $request->alamat;
    $user->no_hp = $request->no_hp;
    $user->email = $request->email;
    
    $user->save();

    return redirect()->back()->with('success', 'Berhasil mengedit user');
}

public function edit_password_pengadu(Request $request, $id)
{
    $user = User::find($id);

    if ($request->has('password')) {
        $user->password = bcrypt($request->password);
    }
    
    $user->save();

    return redirect()->back()->with('success', 'Berhasil mengedit password');
}


}