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
    public function cetakPDF()
    {
        $data = Pengaduan::where('status_selesai','Y')->get(); // Ambil data dari database
        $pdf = PDF::loadView('pdf', compact('data')); // 'pdf.template' adalah nama view PDF
        
        return $pdf->setPaper('a4', 'landscape')->download('data.pdf'); // Nama file PDF yang akan diunduh
    }
}
