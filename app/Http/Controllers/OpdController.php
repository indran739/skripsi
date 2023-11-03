<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opd;
Use Auth;
use App\Models\User;
use App\Models\Pengaduan;
use Carbon\Carbon;
use App\Models\Tanggapan;
use App\Models\Category;


class OpdController extends Controller
{
    public function index() {

        $idOpd= Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();

        $selectedYear = Carbon::now()->year;

//<--------------------------------------------------Grafik Pie-------------------------------------------------------------------------->//

        // Mengambil data Pengaduan dari model Pengaduan
        $pengaduans = Pengaduan::where('id_opd_fk',$idOpd)->whereYear('tanggal_lapor', $selectedYear)->where('disposisi_opd','Y')->where('status_selesai','Y')->get();
        // Mengambil data kategori yang hanya ada di tabel pengaduan
        $categoryIds = $pengaduans->pluck('id_category_fk')->unique(); // Mendapatkan daftar ID kategori yang unik dari tabel pengaduan
        $categories = Category::whereIn('id', $categoryIds)->get(); // Mengambil data kategori berdasarkan ID yang ada di tabel pengaduan

        // Menghitung jumlah pengaduan per kategori
        $categoryCounts = [];
        $categoryNames = [];
        foreach ($categories as $category) {
            $count = $pengaduans->where('id_category_fk', $category->id)->count();
            $categoryCounts[] = $count;
            $categoryNames[] = $category->name; // Mengambil nama kategori dari model Category
        }
//<--------------------------------------------------End Grafik Pie-------------------------------------------------------------------------->//

//<--------------------------------------------------Grafik Line-------------------------------------------------------------------------->//

        // Mengambil data pengaduan yang memiliki status selesai
        $pengaduanSelesai = Pengaduan::where('status_selesai', 'Y')->whereYear('tanggal_lapor', Carbon::now()->year)->where('id_opd_fk',$idOpd)->get();

        // Mengelompokkan pengaduan berdasarkan bulan
        $pengaduanPerBulan = $pengaduanSelesai->groupBy(function ($pengaduanSelesai) {
            return $pengaduanSelesai->updated_at->format('F Y');
        });

        // Menghitung jumlah pengaduan selesai per bulan
        $jumlahPengaduanPerBulan = $pengaduanPerBulan->map(function ($group) {
            return $group->count();
        });

        // Mengumpulkan data bulan dan jumlah pengaduan per bulan
        $labels = $jumlahPengaduanPerBulan->keys();
        $data = $jumlahPengaduanPerBulan->values();
//<--------------------------------------------------End Grafik Line-------------------------------------------------------------------------->//

//<--------------------------------------------------Rata-rata Waktu----------------------------------------------------------------------------->//
            // // Menghitung tanggal satu bulan yang lalu dari hari ini
            // $tanggalSatuBulanYangLalu = Carbon::now()->subMonth();

            // // Menghitung jumlah pengaduan yang diselesaikan dalam satu bulan terakhir
            // $totalPengaduanDiselesaikan = Pengaduan::where('status_selesai', 'Y')->where('id_opd_fk',auth()->user()->id_opd_fk)
            //     ->where('updated_at', '>=', $tanggalSatuBulanYangLalu)
            //     ->count();

            // // Menghitung jumlah pengaduan dalam satu bulan terakhir
            // $jumlahPengaduan = Pengaduan::where('created_at', '>=', $tanggalSatuBulanYangLalu)
            //     ->count();

            // // Menghitung rata-rata pengaduan diselesaikan dalam satu bulan
            // if ($jumlahPengaduan > 0) {
            //     $rataRataPengaduanDiselesaikan = ($totalPengaduanDiselesaikan / $jumlahPengaduan) * 100;
            // } else {
            //     $rataRataPengaduanDiselesaikan = 0;
            // }
            //     $ratap = number_format($rataRataPengaduanDiselesaikan, 0);
//<--------------------------------------------------Chart Pengaduan OPD----------------------------------------------------------------------------->//           
            $opdCounts = [];

            $countLaporanSelesai = Pengaduan::where('disposisi_opd', 'Y')
            ->where('status_selesai', 'Y')
            ->where('validasi_laporan', 'Y')
            ->where('proses_tindak', 'Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->where('id_opd_fk',$idOpd)
            ->count();

            $countLaporanTindak = Pengaduan::where('disposisi_opd', 'Y')
            ->where('status_selesai', NULL)
            ->where('validasi_laporan', 'Y')
            ->where('proses_tindak', 'Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->where('id_opd_fk',$idOpd)
            ->count();

            $countLaporanTidakValid = Pengaduan::where('status_selesai', NULL)
            ->where('proses_tindak', 'P')
            ->where('validasi_laporan', 'N')
            ->where('disposisi_opd', 'Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->where('id_opd_fk',$idOpd)
            ->count();

            $countLaporanValid = Pengaduan::where('status_selesai', NULL)
            ->where('proses_tindak', 'P')
            ->where('validasi_laporan', 'Y')
            ->where('disposisi_opd', 'Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->where('id_opd_fk',$idOpd)
            ->count();

            $countLaporanTerdisposisi = Pengaduan::where('status_selesai', NULL)
            ->where('proses_tindak', 'P')
            ->where('validasi_laporan', 'P')
            ->where('disposisi_opd', 'Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->where('id_opd_fk',$idOpd)
            ->count();

                $opdCounts[] = [
                    'Selesai' => $countLaporanSelesai,
                    'Tindak Lanjut' => $countLaporanTindak,
                    'Tidak Valid' => $countLaporanTidakValid,
                    'Valid' => $countLaporanValid,
                    'Terdisposisi' => $countLaporanTerdisposisi,
                ];

        return view('adminopd.dashboard', [
            'active' => 'login',
            'opd' => $opd,
            'categoryNames' => $categoryNames,
            'selectedYear' => $selectedYear,
            'categoryCounts' => $categoryCounts,
            'labels' => $labels,
            'data' => $data,
            // 'ratap' => $ratap,
            'active' => 'beranda',
            'opdCounts' => $opdCounts
        ]);
    }

    public function chartPengaduanCategories(Request $request)
    {
        
        $idOpd= Auth::user()->id_opd_fk;
        // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
        $selectedYear = $request->input('year', Carbon::now()->year);
    
        // Kueri database berdasarkan tahun yang dipilih
        $pengaduans = Pengaduan::where('id_opd_fk',$idOpd)->whereYear('tanggal_lapor', $selectedYear)
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
        $idOpd= Auth::user()->id_opd_fk;
        // Ambil tahun dari permintaan (jika tidak ada, gunakan tahun sekarang)
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Kueri database berdasarkan tahun yang dipilih
        $opdCounts = [];

        $countLaporanSelesai = Pengaduan::where('disposisi_opd', 'Y')
        ->where('status_selesai', 'Y')
        ->where('validasi_laporan', 'Y')
        ->where('proses_tindak', 'Y')
        ->whereYear('tanggal_lapor', $selectedYear)
        ->where('id_opd_fk',$idOpd)
        ->count();

        $countLaporanTindak = Pengaduan::where('disposisi_opd', 'Y')
        ->where('status_selesai', NULL)
        ->where('validasi_laporan', 'Y')
        ->where('proses_tindak', 'Y')
        ->whereYear('tanggal_lapor', $selectedYear)
        ->where('id_opd_fk',$idOpd)
        ->count();

        $countLaporanTidakValid = Pengaduan::where('status_selesai', NULL)
        ->where('proses_tindak', 'P')
        ->where('validasi_laporan', 'N')
        ->where('disposisi_opd', 'Y')
        ->whereYear('tanggal_lapor', $selectedYear)
        ->where('id_opd_fk',$idOpd)
        ->count();

        $countLaporanValid = Pengaduan::where('status_selesai', NULL)
        ->where('proses_tindak', 'P')
        ->where('validasi_laporan', 'Y')
        ->where('disposisi_opd', 'Y')
        ->whereYear('tanggal_lapor', $selectedYear)
        ->where('id_opd_fk',$idOpd)
        ->count();

        $countLaporanTerdisposisi = Pengaduan::where('status_selesai', NULL)
        ->where('proses_tindak', 'P')
        ->where('validasi_laporan', 'P')
        ->where('disposisi_opd', 'Y')
        ->whereYear('tanggal_lapor', $selectedYear)
        ->where('id_opd_fk',$idOpd)
        ->count();

                $opdCounts[] = [
                    'Selesai' => $countLaporanSelesai,
                    'Tindak Lanjut' => $countLaporanTindak,
                    'Valid' => $countLaporanValid,
                    'Tidak Valid' => $countLaporanTidakValid,
                    'Terdisposisi' => $countLaporanTerdisposisi,
                ];

        return response()->json($opdCounts);
    }

    public function view_laporan_terdisposisi() {

        $idOpd= Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();
        
        $laporans_disposisi = Pengaduan::where('disposisi_opd', 'Y')
        ->where(function ($query) {
            $query->where('validasi_laporan', 'P')
                ->orWhere('validasi_laporan', 'Y');
        })->where('proses_tindak', 'P')->where('id_opd_fk', $idOpd)->whereNull('status_selesai')->orderBy('created_at', 'desc')->paginate(5);

        $laporans_invalid = Pengaduan::where('validasi_laporan', 'N')->where('id_opd_fk',$idOpd)->whereNull('status_selesai')->orderBy('created_at', 'desc')->paginate(5);
        $laporans_tindak = Pengaduan::where('proses_tindak', 'Y')->where('id_opd_fk',$idOpd)->whereNull('status_selesai')->orderBy('created_at', 'desc')->paginate(5);

        // $pengaduans = Pengaduan::where('disposisi_opd','Y')->where('id_opd_fk',$idOpd)->where('status_selesai', NULL)->get();
        // $tindak = Pengaduan::where('disposisi_opd','Y')->where('id_opd_fk',$idOpd)->where('proses_tindak','Y')->where('validasi_laporan','Y')->get();

        return view('adminopd.laporandisposisi', [
            'opd' => $opd,
            'laporans_disposisi' => $laporans_disposisi,
            'laporans_invalid' => $laporans_invalid,
            'laporans_tindak' => $laporans_tindak,
            // 'pengaduans' => $pengaduans,
            // 'tindak' => $tindak,
            'active' => 'manajemenlaporan'
        ]);
    }

    public function view_laporan_selesai() {

        $idOpd = Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();

        $pengaduans = Pengaduan::where('disposisi_opd','Y')->where('id_opd_fk',$idOpd)->where('status_selesai', 'Y')->orderBy('created_at', 'desc')->paginate(7);
        
        // foreach ($pengaduans as $item) 
        // {
        //     $tanggalSelesai = Carbon::parse($item->tanggal_selesai);
        //     $tanggalUpdate = Carbon::parse($item->updated_at);
            
        //     if ($tanggalUpdate->isSameDay($tanggalSelesai) && $tanggalUpdate->isSameMonth($tanggalSelesai)) {
        //         // Tanggal dinyatakan selesai sama dengan tanggal estimasi selesai
        //         $item->kecepatan = "Tepat Waktu";
               
        //     } elseif ($tanggalUpdate->greaterThan($tanggalSelesai)) {

        //         // Tanggal dinyatakan selesai lambat dari tanggal estimasi selesai
        //         $item->kecepatan = "Lambat";
                
        //     } else {
        //             // Tanggal dinyatakan selesai cepat dari tanggal estimasi selesai
        //         $item->kecepatan = "Cepat";
                
        //     }
        //     $item->save();
        // }
        // Mendapatkan kategori yang sudah berstatus selesai dari tabel pengaduan sebagai collection
        $kategorisSelesai = Category::whereHas('pengaduan', function ($query) {
            $query->where('status_selesai', 'Y')->where('id_opd_fk', auth()->user()->id_opd_fk);
        })->get();

        return view('adminopd.laporanselesai', [
            'opd' => $opd,
            'laporans' => $pengaduans,
            'active' => 'selesai',
            'categories' => $kategorisSelesai,
            'opds' => Opd::where('name', '!=', 'pengadu')->where('name', '!=', 'Inspektorat Kabupaten Gunung Mas')->get(['id', 'name']),
        ]);
    }
    
    
    public function searchOpd(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        
        $idOpd = Auth::user()->id_opd_fk;

        $results = Pengaduan::where('status_selesai', 'Y')
            ->where('isi_laporan', 'like', '%' . $searchTerm . '%')
            ->where('id_opd_fk',$idOpd)
            ->with('category', 'opd')
            ->orderBy('tanggal_lapor', 'desc')
            ->get();
        return response()->json(['results' => $results]);
    }


    public function filterLaporanSelesai(Request $request) 
    {
        $idCategory = $request->input('id_category_fk');
        $idOpd= Auth::user()->id_opd_fk;

        // Lakukan filter data berdasarkan $idOpd dan $idCategory
        $filteredLaporans = Pengaduan::with(['category','opd']) // Memuat relasi category dan opd
            ->where('status_selesai', 'Y')->where('id_opd_fk', $idOpd)
            ->when($idCategory, function ($query) use ($idCategory) {
                return $query->where('id_category_fk', $idCategory);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        return response()->json(['laporans' => $filteredLaporans]); // Pastikan mengirimkan 'laporans' ke frontend
    }


    public function view_user_pengadu() {

        $idOpd= Auth::user()->id_opd_fk;
        $opd =  Opd::select('name')->where('id',$idOpd)->first();

        return view('adminopd.userpengadu', [
            'opd' => $opd
        ]);
    }

    public function showDataDetail($id)
    {
        $laporan = Pengaduan::find($id);
        $tanggapans = Tanggapan::where('id_pengaduan_fk', $id)->get();

        return view('adminopd.detailpengaduanopd', [
            'laporan' => $laporan,
            'tanggapans' => $tanggapans,
            'active' => 'manajemenlaporan'
        ]);
    }

    public function view_tindak_lanjut($id)
    {
        $data = Pengaduan::find($id);

        return view('adminopd.tindaklanjut', [
            'data' => $data,
            'active' => 'manajemenlaporan'
        ]);
    }

    public function proses_tindak(Request $request, $id)
    {
        $proses_tindak = Pengaduan::find($id);

        $proses_tindak->proses_tindak = 'Y';

        $proses_tindak->tanggal_tindak = $request->tanggal_tindak;
        $proses_tindak->tanggal_selesai = $request->tanggal_selesai;

        $proses_tindak->save();

        if($request->tanggapan == NULL){
            return redirect('/laporanterdisposisiopd')->with('tindak', 'Data berhasil diperbarui');
        }
        else{
            $tanggapan = new Tanggapan();
            $tanggapan->id_user_fk = auth()->user()->id;
            $tanggapan->id_pengaduan_fk = $id;
            $tanggapan->tanggapan = $request->tanggapan;
            $tanggapan->save();
            return redirect('/laporanterdisposisiopd')->with('tindak', 'Data berhasil diperbarui');
        }

    }

    public function validasi(Request $request, $id)
    {
        $validasi = Pengaduan::find($id);
        
        if($request->validasi_laporan == 'Y' && $validasi->disposisi_opd == 'Y'){

            $validasi->validasi_laporan = $request->validasi_laporan; 

            $validasi->save();

            $validasi->tanggal_validasi = $validasi->updated_at;
            
            $validasi->save();

            if($request->tanggapan == NULL){
                return redirect('/laporanterdisposisiopd')->with('success', 'Data berhasil diperbarui');
            }
            else{
                $tanggapan = new Tanggapan();
                $tanggapan->id_user_fk = auth()->user()->id;
                $tanggapan->id_pengaduan_fk = $id;
                $tanggapan->tanggapan = $request->tanggapan;
                $tanggapan->save();
                return redirect('/laporanterdisposisiopd')->with('success', 'Data berhasil diperbarui');
            }


        }else if($request->validasi_laporan == 'N' &&  $validasi->disposisi_opd == 'Y'){

            $validasi->validasi_laporan = $request->validasi_laporan; 

            $validasi->save();

            $validasi->tanggal_validasi = $validasi->updated_at;
            
            $validasi->save();
            
            if($request->tanggapan == NULL){
                return redirect('/laporanterdisposisiopd')->with('berhasil', 'Data berhasil diperbarui');
            }
            else{
                $tanggapan = new Tanggapan();
                $tanggapan->id_user_fk = auth()->user()->id;
                $tanggapan->id_pengaduan_fk = $id;
                $tanggapan->tanggapan = $request->tanggapan;
                $tanggapan->save();
                return redirect('/laporanterdisposisiopd')->with('berhasil', 'Data berhasil diperbarui');
            }

        }else {
            $validasi->validasi_laporan = $request->validasi_laporan; 

            $validasi->save();
            return redirect('/laporanterdisposisiopd');
        }
    }


    public function status_selesai(Request $request, $id_pengaduan)
    {
        $pengaduan = Pengaduan::find($id_pengaduan);
        
        if($request->status_selesai == 'Y' && $pengaduan->proses_tindak == "Y" && $pengaduan->validasi_laporan == "Y"){

            $pengaduan->status_selesai = $request->status_selesai; 

            $pengaduan->save();

            $pengaduan->tgl_dinyatakan_selesai = $pengaduan->updated_at;

            $pengaduan->save();   


            if($request->tanggapan == NULL){
                return redirect('/laporanselesaiopd')->with('selesai', 'Data berhasil diperbarui');
            }
            else{
                $tanggapan = new Tanggapan();
                $tanggapan->id_user_fk = auth()->user()->id;
                $tanggapan->id_pengaduan_fk = $id_pengaduan;
                $tanggapan->tanggapan = $request->tanggapan;
                $tanggapan->save();
                return redirect('/laporanselesaiopd')->with('selesai', 'Data berhasil diperbarui');
            }
            
            // }else if($request->status_selesai == 'P' && $pengaduan->proses_tindak == "Y" && $pengaduan->validasi_laporan == "Y" ){

            //     $pengaduan->status_selesai = $request->status_selesai; 

            //     $pengaduan->save();
            //     return redirect('/laporanterdisposisiopd')->with('tidakselesai', 'Data berhasil diperbarui');
            
        }else {
            $pengaduan->status_selesai = $request->status_selesai; 

            $pengaduan->save();
            return redirect('/laporanterdisposisiopd');
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
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function edittanggapanopd(Request $request, $id_tanggapan)
    {
        $edittanggapan = Tanggapan::find($id_tanggapan);

        $edittanggapan->tanggapan = $request->tanggapan;
        $edittanggapan->save();

        return redirect()->back()->with('updatetanggapans', 'Data berhasil disimpan');
    }

    public function hapustanggapanopd($id_tanggapan)
{
    // Temukan item berdasarkan ID
    $tanggapan = Tanggapan::findOrFail($id_tanggapan);

    // Hapus item
    $tanggapan->delete();

    // Redirect dengan pesan sukses
    return redirect()->back()->with('deletetanggapans', 'Data berhasil dihapus');
}
}