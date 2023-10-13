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


        return $pdf->setPaper('legal', 'landscape')->download('data.pdf'); // Nama file PDF yang akan diunduh
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
}
