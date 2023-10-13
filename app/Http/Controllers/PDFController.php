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

        $data = Pengaduan::where('status_selesai','Y')->where('created_at', '>=', $tanggalAwal)->get();

        $pdf = PDF::loadView('pdf', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('a3', 'landscape')->download('data.pdf'); // Nama file PDF yang akan diunduh
    }

    public function cetakLaporanSelesaiOpd(Request $request)
    {

        $rentang = $request->input('rentang'); // Mendapatkan nilai rentang waktu dari formulir

        // Menghitung tanggal awal berdasarkan rentang waktu yang dipilih
        $tanggalAwal = now()->subMonths($rentang);

        $data = Pengaduan::where('status_selesai','Y')->where('id_opd_fk',auth()->user()->id_opd_fk)->where('created_at', '>=', $tanggalAwal)->get();

        $pdf = PDF::loadView('adminopd.tempalate_laporanselesai', compact('data')); // 'pdf.template' adalah nama view PDF


        return $pdf->setPaper('legal', 'landscape')->download('data.pdf'); // Nama file PDF yang akan diunduh
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


        return $pdf->setPaper('a3', 'landscape')->download('data.pdf'); // Nama file PDF yang akan diunduh
    }
}
