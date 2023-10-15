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

        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        $data = Pengaduan::where('status_selesai','Y')
        ->where('created_at', '>=', $tanggalAwal)
        ->get();

        $pdf = PDF::loadView('pdf', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('a3', 'landscape')->download('Laporan_Pengaduan_Selesai.pdf'); // Nama file PDF yang akan diunduh
    }

    public function cetakLaporanSelesaiOpd(Request $request)
    {

        $rentang = $request->input('rentang'); // Mendapatkan nilai rentang waktu dari formulir

        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        $data = Pengaduan::where('status_selesai','Y')
        ->where('id_opd_fk',auth()->user()->id_opd_fk)
        ->where('created_at', '>=', $tanggalAwal)
        ->get();

        $pdf = PDF::loadView('adminopd.tempalate_laporanselesai', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('legal', 'landscape')->download('Laporan_Pengaduan_Selesai.pdf'); // Nama file PDF yang akan diunduh
    }

    public function cetakLaporanBelumTanggap(Request $request)
    {

        $rentang = $request->input('rentang'); // Mendapatkan nilai rentang waktu dari formulir
        $status = $request->input('status');

        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        if($status == 'S'){
            $data = Pengaduan::where('status_selesai',NULL)
            ->where('created_at', '>=', $tanggalAwal)
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

    public function cetakLaporanKinerja()
    {


        $opds = OPD::all();
            $opdAverages = [];

            foreach ($opds as $opd) {
                $completedPengaduan = Pengaduan::where('status_selesai', 'Y')->where('id_opd_fk', $opd->id)->get();
                
                $totalDuration = 0;
                $completedCount = $completedPengaduan->count();

                foreach ($completedPengaduan as $pengaduan) {
                    $createdAt = Carbon::parse($pengaduan->tanggal_tindak);
                    $resolvedAt = Carbon::parse($pengaduan->updated_at);
                    $duration = $resolvedAt->diffInHours($createdAt);
                    $totalDuration += $duration;
                }
                
                $pengaduan = Pengaduan::whereNotNull('tanggal_validasi')
                ->where('id_opd_fk', $opd->id)
                ->get();

                $totalWaktuRespon = 0;
                $jumlahPengaduan = 0;

                foreach ($pengaduan as $aduan) {
                    $waktuPenerimaan = Carbon::parse($aduan->tanggal_tindak);
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
                
                $count_laporan_selesai = Pengaduan::where('disposisi_opd','Y')
                ->where('status_selesai','Y')
                ->where('validasi_laporan','Y')
                ->where('proses_tindak','Y')
                ->where('id_opd_fk', $opd->id)
                ->get()
                ->count();

                $count_laporan_ditindak = Pengaduan::where('disposisi_opd','Y')
                ->where('status_selesai',NULL)
                ->where('validasi_laporan','Y')
                ->where('proses_tindak','Y')
                ->where('id_opd_fk',$opd->id)
                ->get()->count();

                $count_laporan_belum = Pengaduan::where('status_selesai',NULL)
                ->where('id_opd_fk',$opd->id)
                ->where('proses_tindak','P')
                ->whereNotNull('validasi_laporan')
                ->whereNotNull('disposisi_opd')
                ->get()->count();

                // Hanya simpan data jika rata-rata waktu penyelesaian lebih dari 0
                if ($averageDuration > 0 && $rataRataWaktuRespon > 0) {
                    $opdAverages[] = [
                        'opd_name' => $opd->name,
                        'average_duration' => $averageDuration,
                        'rataRataWaktuRespon' => $rataRataWaktuRespon,
                        'count_laporan_selesai' => $count_laporan_selesai,
                        'count_laporan_ditindak' => $count_laporan_ditindak,
                        'count_laporan_belum' => $count_laporan_belum
                    ];
                }
            }

        $pdf = PDF::loadView('admininspektorat.template_laporankinerja', compact('opdAverages')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('a3', 'landscape')->download('Laporan_Pengaduan_Selesai.pdf'); // Nama file PDF yang akan diunduh
    }
}
