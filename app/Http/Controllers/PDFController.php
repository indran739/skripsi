<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Opd;
Use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Pengaduan;
use App\Models\Category;
use App\Models\Tanggapan;
use App\Models\Tanggapan_Admins;

class PDFController extends Controller
{
    public function cetakPDF(Request $request)
    {

        $rentang = $request->input('rentang'); // Mendapatkan nilai rentang waktu dari formulir
        
        $selectedYear = $rentang;
        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        if($rentang == '2022')
        {
            $data = Pengaduan::where('status_selesai','Y')
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get(); 
        }
        else{
            $data = Pengaduan::where('status_selesai','Y')
            ->where('created_at', '>=', $tanggalAwal)
            ->get();
        }
        

        $pdf = PDF::loadView('pdf', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('a3', 'landscape')->download('Laporan_Pengaduan_Selesai.pdf'); // Nama file PDF yang akan diunduh
    }

    public function cetakLaporanSelesaiOpd(Request $request)
    {

        $rentang = $request->input('rentang'); // Mendapatkan nilai rentang waktu dari formulir

        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        $selectedYear = $rentang;

        if($rentang == '2022')
        {
            $data = Pengaduan::where('status_selesai','Y')
            ->where('id_opd_fk',auth()->user()->id_opd_fk)
            ->whereYear('tanggal_lapor', $selectedYear)
            ->get(); 
        }
        else{
            $data = Pengaduan::where('status_selesai','Y')
            ->where('id_opd_fk',auth()->user()->id_opd_fk)
            ->where('created_at', '>=', $tanggalAwal)
            ->get();
        }

        $pdf = PDF::loadView('adminopd.tempalate_laporanselesai', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('legal', 'landscape')->download('Laporan_Pengaduan_Selesai.pdf'); // Nama file PDF yang akan diunduh
    }

    public function cetakLaporanBelumTanggap(Request $request)
    {

        $rentang = $request->input('rentang'); // Mendapatkan nilai rentang waktu dari formulir
        $status = $request->input('status');

        $selectedYear = $rentang;
        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        if($status == 'S'){
            $data = Pengaduan::where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->get();

        }elseif($status == 'S' && $rentang == '2022')
        {
            $data = Pengaduan::where('status_selesai',NULL)
            ->whereYear('created_at', $rentang)
            ->get();

        }elseif($status == 'P')
        {
            $data = Pengaduan::where('disposisi_opd','P')
            ->where('created_at', '>=', $tanggalAwal)
            ->get();

        }elseif($status == 'D')
        {
            $data = Pengaduan::where('disposisi_opd','Y')
            ->where('validasi_laporan','P')
            ->where('proses_tindak','P')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->get();

        }elseif($status == 'T')
        {
            $data = Pengaduan::where('disposisi_opd','N')
            ->where('validasi_laporan','P')
            ->where('proses_tindak','P')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->get();

        }elseif($status == 'V')
        {
            $data = Pengaduan::where('validasi_laporan','Y')
            ->where('disposisi_opd','Y')
            ->where('proses_tindak','P')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->get();

        }elseif($status == 'I')
        {
           $data = Pengaduan::where('validasi_laporan','N')
            ->where('disposisi_opd','Y')
            ->where('proses_tindak','P')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->get();

        }elseif($status == 'W')
        {
            $data = Pengaduan::where('proses_tindak','Y')
            ->where('disposisi_opd','Y')
            ->where('validasi_laporan','Y')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->get();
        }

        $pdf = PDF::loadView('admininspektorat.template_laporanbelumditanggap', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('a3', 'landscape')->download('Laporan_Pengaduan_Masuk.pdf'); // Nama file PDF yang akan diunduh
    }

    public function cetakLaporanBelumTanggapOpd(Request $request)
    {

        $rentang = $request->input('rentang'); // Mendapatkan nilai rentang waktu dari formulir
        $status = $request->input('status');

        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        if($status == 'S'){
            $data = Pengaduan::where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->where('disposisi_opd','Y')
            ->where('id_opd_fk', auth()->user()->id_opd_fk)
            ->get();

        }elseif($status == 'D')
        {
            $data = Pengaduan::where('disposisi_opd','Y')
            ->where('validasi_laporan','P')
            ->where('proses_tindak','P')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->where('id_opd_fk', auth()->user()->id_opd_fk)
            ->get();

        }elseif($status == 'V')
        {
            $data = Pengaduan::where('validasi_laporan','Y')
            ->where('disposisi_opd','Y')
            ->where('proses_tindak','P')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->where('id_opd_fk', auth()->user()->id_opd_fk)
            ->get();

        }elseif($status == 'I')
        {
           $data = Pengaduan::where('validasi_laporan','N')
            ->where('disposisi_opd','Y')
            ->where('proses_tindak','P')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->where('id_opd_fk', auth()->user()->id_opd_fk)
            ->get();

        }elseif($status == 'W')
        {
            $data = Pengaduan::where('proses_tindak','Y')
            ->where('disposisi_opd','Y')
            ->where('validasi_laporan','Y')
            ->where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
            ->where('id_opd_fk', auth()->user()->id_opd_fk)
            ->get();
        }

        $pdf = PDF::loadView('adminopd.template_laporanbelumditanggapopd', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('a3', 'landscape')->download('Laporan_Pengaduan_Masuk.pdf'); // Nama file PDF yang akan diunduh
    }

    public function cetakLaporanKinerja(Request $request)
    {
        $selectedYear = $request->input('year');
        $opds = OPD::all();
            $opdAverages = [];

            foreach ($opds as $opd) {
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
                $rataRataWaktuRespon = number_format( $rataRataWaktuRespon, 2);

                // Menghitung rata-rata waktu penyelesaian
                $averageDuration = ($completedCount > 0) ? ($totalDuration / $completedCount) : 0;
                $averageDuration = number_format($averageDuration, 2);
                
                $totalDuration = number_format($totalDuration, 1);
                $totalWaktuRespon = number_format($totalWaktuRespon, 1);

                $count_laporan_selesai = Pengaduan::where('disposisi_opd','Y')
                ->where('status_selesai','Y')
                ->where('validasi_laporan','Y')
                ->where('proses_tindak','Y')
                ->where('id_opd_fk', $opd->id)
                ->whereYear('tanggal_lapor', $selectedYear)
                ->get()
                ->count();

                // Hanya simpan data jika rata-rata waktu penyelesaian lebih dari 0
                if ($averageDuration > 0 && $rataRataWaktuRespon > 0) {
                    $opdAverages[] = [
                        'opd_name' => $opd->name,
                        'completed_duration' => $totalDuration,
                        'respons_duration' => $totalWaktuRespon,
                        'average_duration' => $averageDuration,
                        'rataRataWaktuRespon' => $rataRataWaktuRespon,
                        'count_laporan_selesai' => $count_laporan_selesai,
                        'selectedYear' => $selectedYear
                    ];
                }
            }

        $pdf = PDF::loadView('admininspektorat.template_laporankinerja', compact('opdAverages')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('a3', 'landscape')->download('Laporan_Kinerja_OPD.pdf'); // Nama file PDF yang akan diunduh
    }
}
