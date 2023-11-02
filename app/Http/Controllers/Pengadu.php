<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Category;
use App\Models\Opd;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Tanggapan;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Desa;
use App\Models\Tanggapan_Admins;
use Illuminate\Support\Facades\Storage; // Import namespace Storage
use Auth;
use Carbon\Carbon;


class Pengadu extends Controller
{
    public function halaman_pending() {
        $iduser = Auth::user()->id;
        $tanggapan = Tanggapan_Admins::where('id_user_fk',$iduser)->get();
        $user_login = Auth::user()->where('id', $iduser)->get();

        return view('halamanpending', [
            'opds' => Opd::all(),
            'tanggapans' => $tanggapan,
            'userlogin' => $user_login,
            "kecamatans" => Kecamatan::all(),
            "desas" => Desa::all()
        ]);
    }

    public function index() {
        $laporans = Pengaduan::orderBy('tanggal_lapor', 'desc')->where('status_selesai','Y')->whereYear('tanggal_lapor', Carbon::now())->paginate(10);
    
        return view('pengadu.beranda', [
            'laporans' => $laporans,
            'active' => 'beranda',
            'categories' => Category::all(),
            'opds' => Opd::where('name', '!=', 'pengadu')->where('name', '!=', 'Inspektorat Kabupaten Gunung Mas')->get(['id', 'name']),
        ]);
    }


public function search(Request $request)
{
    $searchTerm = $request->input('searchTerm');
    $category = $request->input('category'); // Ambil nilai kategori dari request
    $opd = $request->input('opd');

    $query = Pengaduan::where('status_selesai', 'Y')
        ->where('isi_laporan', 'like', '%' . $searchTerm . '%');

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

    $results = $query->with('category', 'opd', 'user')
                    ->orderBy('tanggal_lapor', 'desc')
                    ->get();

    return response()->json(['results' => $results]);
}

public function searchLaporanSelesai(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
    
        $results = Pengaduan::where('status_selesai', 'Y')
            ->where('isi_laporan', 'like', '%' . $searchTerm . '%')
            ->with('category', 'opd')
            ->orderBy('tanggal_lapor', 'desc')
            ->where('id_user_fk', auth()->user()->id)
            ->get();
        return response()->json(['results' => $results]);
    }

    public function view_form() {
        return view('pengadu.form_lapor', [
            'opds' => Opd::where('name', '!=', 'pengadu')->where('name', '!=', 'Inspektorat Kabupaten Gunung Mas')->get(['id', 'name']),
            'categories' => Category::all(),
            'kecamatans' => Kecamatan::all(),
            'desas' => Desa::all(),
            'active' => 'formlaporan',
        ]);
    }
    
    public function view_laporan_terkirim() {
        $iduser = Auth::user()->id;

        $laporans_pending = Pengaduan::where('id_user_fk', $iduser)
        ->where('disposisi_opd', 'P')
        ->whereNull('status_selesai')
        ->orderBy('tanggal_lapor', 'desc')
        ->paginate(5);

        $laporans_tolak = Pengaduan::where('id_user_fk', $iduser)
        ->where('disposisi_opd', 'N')
        ->whereNull('status_selesai')
        ->orderBy('tanggal_lapor', 'desc')
        ->paginate(5);

        $laporans_disposisi = Pengaduan::where('id_user_fk', $iduser)
        ->where('disposisi_opd', 'Y')
        ->where('validasi_laporan', 'P')
        ->whereNull('status_selesai')
        ->orderBy('tanggal_lapor', 'desc')
        ->paginate(5);

        $laporans_invalid = Pengaduan::where('id_user_fk', $iduser)
        ->where('validasi_laporan', 'N')
        ->whereNull('status_selesai')
        ->orderBy('tanggal_lapor', 'desc')
        ->paginate(5);

        $laporans_valid = Pengaduan::where('id_user_fk', $iduser)
        ->where('validasi_laporan', 'Y')
        ->where('proses_tindak', 'P')
        ->whereNull('status_selesai')
        ->orderBy('tanggal_lapor', 'desc')
        ->paginate(5);

        $laporans_tindak = Pengaduan::where('id_user_fk', $iduser)
        ->where('proses_tindak', 'Y')
        ->whereNull('status_selesai')
        ->orderBy('tanggal_lapor', 'desc')
        ->paginate(5);
        
        return view('pengadu.laporan_terkirim', [
            'laporans_pending' => $laporans_pending,
            'laporans_tolak' => $laporans_tolak,
            'laporans_disposisi' => $laporans_disposisi,
            'laporans_invalid' => $laporans_invalid,
            'laporans_valid' => $laporans_valid,
            'laporans_tindak' => $laporans_tindak,
            'active' => 'manajemenlaporan'
        ]);
    }

    public function view_laporan_selesai() {
        $iduser = Auth::user()->id;
        $laporans = Pengaduan::where('id_user_fk', $iduser)->where('status_selesai','Y')->orderBy('tanggal_lapor', 'desc')->paginate(7);
    
        return view('pengadu.laporan_selesai', [
            'laporans' => $laporans,
            'active' => 'selesai'
        ]);
    }

    public function view_profile() {
        $iduser = Auth::user()->id;
        $profile = User::where('id',$iduser);

        return view('pengadu.profilpengadu', [
            'profile' => $profile,
            'active' => 'profile'
        ]);
    }

    public function view_tentang() {
        return view('about', [
            'active' => 'about'
        ]);
    }

    public function view_detail_pengaduan($id) {

        $laporans = Pengaduan::findOrFail($id);

        $tanggapans = Tanggapan::where('id_pengaduan_fk', $id)->get();

        return view('pengadu.detailpengaduan', [
            'active' => 'beranda',
            'laporan' => $laporans,
            'tanggapans' => $tanggapans
        ]);
    }

    public function editdataregister(Request $request, $id_user){

        $user = User::find($id_user);
    
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->id_kecamatan_fk = $request->id_kecamatan_fk;
        $user->id_desa_fk = $request->id_desa_fk;

        //cari id_kelurahan di objek desa
        $desa = Desa::find($request->id_desa_fk);
        $id_kelurahan = $desa->kelurahan->id;
        $user->id_kelurahan_fk = $id_kelurahan;

        $user->tempat_lahir = $request->tempat_lahir;
    
        // Ambil tanggal dari input HTML
        $tanggal_lahir = $request->input('tanggal_lahir');
        
        // Konversi format tanggal dari 'd/m/Y' menjadi 'Y-m-d'
        $tanggal_lahir_mysql = date("Y-m-d", strtotime($tanggal_lahir));
    
        $user->tanggal_lahir = $tanggal_lahir_mysql;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->agama = $request->agama;
        $user->no_hp = $request->no_hp;
        $user->pekerjaan = $request->pekerjaan;
        $user->status_pernikahan = $request->status_pernikahan;
        $user->gol_darah = $request->gol_darah;
        $user->verification = 'P';
        
    
    if ($request->hasFile('foto_wajah')) {
        $fotoWajah = $request->file('foto_wajah');
        $fotoWajahPath = $fotoWajah->store('profile-fotos');
        $user->foto_wajah = $fotoWajahPath;
    }
    
    if ($request->hasFile('foto_ktp')) {
        $fotoKtp = $request->file('foto_ktp');
        $fotoKtpPath = $fotoKtp->store('fotos_ktp'); 
        $user->foto_ktp = $fotoKtpPath;
    }
    
        $user->save();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    
    }


public function editprofile(Request $request, $id_user){
    $user = User::find($id_user);

    $user->name = $request->name;
    $user->alamat = $request->alamat;
    $user->no_hp = $request->no_hp;

if ($request->hasFile('foto_wajah')) {
    $fotoWajah = $request->file('foto_wajah');
    $fotoWajahPath = $fotoWajah->store('profile-fotos');
    $user->foto_wajah = $fotoWajahPath;
}

// if ($request->hasFile('foto_ktp')) {
//     $fotoKtp = $request->file('foto_ktp');
//     $fotoKtpPath = $fotoKtp->store('fotos-ktp');
//     $user->foto_ktp = $fotoKtpPath;
// }


    $user->save();
    return redirect()->back()->with('success', 'Data berhasil disimpan');

}


    public function daftar_akun(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'id_opd_fk' => 'required',
        'email' => 'required|email:dns|unique:users',
        'password' => 'required|min:5|string',
        'nik' => 'required|max:20|unique:users',
        'alamat' => 'required|max:255',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'agama' =>  'required',
        'pekerjaan' => 'required',
        'gol_darah' => 'required',
        'no_tlp' => 'required|max:13',
        'verification' => 'required',
        'jabatan' => 'required',
        'foto_ktp' => 'required',
        'foto_wajah' => 'required',
        'role' => 'required'
    ]);

    $validatedData['password'] = Hash::make($validatedData['password']);
    $validatedData['id_opd_fk'] = $validatedData['id_opd_fk'] ?? '3';
    $validatedData['role'] = $validatedData['role'] ?? 'pengadu';
    $validatedData['verification'] = $validatedData['verification'] ?? 'Y';
    $validatedData['jabatan'] = $validatedData['jabatan'] ?? 'tidak ada';
    $validatedData['foto_ktp'] = $validatedData['foto_ktp'] ?? NULL;
    $validatedData['foto_wajah'] = $validatedData['foto_wajah'] ?? NULL;

    User::create($validatedData);
    return redirect('/daftar')->with('berhasil', 'Data berhasil disimpan');
}

public function store_pengaduan(Request $request)
{
   // Validasi
        $request->validate([
            'id_category_fk' => 'required',
            'id_kecamatan_fk' => 'required',
            'id_desa_fk' => 'required',
            'isi_laporan' => 'required',
            'lokasi_kejadian' => 'required',
            'tanggal_kejadian' => 'required',
            'id_opd_fk' => 'required',
            'lampiran' => 'nullable|file|mimes:pdf|max:5048',
            'first_image' => 'nullable|mimes:jpeg,png|max:5048',
            'sec_image' => 'nullable|mimes:jpeg,png|max:5048',
            'anonim' => 'nullable|in:Y',
        ]);

    // Ambil semua data dari request tanpa validasi
    $pengaduan = new Pengaduan();
    $pengaduan->isi_laporan = $request->input('isi_laporan');
    $pengaduan->id_kecamatan_fk = $request->input('id_kecamatan_fk');
    $pengaduan->id_desa_fk = $request->input('id_desa_fk');
    //cari id_kelurahan di objek desa
        $desa = Desa::find($request->id_desa_fk);
        $id_kelurahan = $desa->kelurahan->id;
        $pengaduan->id_kelurahan_fk = $id_kelurahan;
        
    $pengaduan->lokasi_kejadian = $request->input('lokasi_kejadian');
    $pengaduan->latitude = $request->input('latitude', null);
    $pengaduan->longitude = $request->input('longitude', null);
    $pengaduan->tanggal_kejadian = date("Y-m-d", strtotime($request->input('tanggal_kejadian')));
    $pengaduan->id_opd_fk = $request->input('id_opd_fk');
    $pengaduan->id_category_fk = $request->input('id_category_fk');
    $pengaduan->lampiran = $request->hasFile('lampiran') ? $request->file('lampiran')->storeAs('pengaduan-dokumen-lampiran', 'lampiran_' . uniqid() . '.pdf') : null;
    $pengaduan->first_image = $request->hasFile('first_image') ? $request->file('first_image')->store('pengaduan-images') : null;
    $pengaduan->sec_image = $request->hasFile('sec_image') ? $request->file('sec_image')->store('pengaduan-images') : null;
    $pengaduan->anonim = $request->filled('anonim') ? 'Y' : null;
    $pengaduan->disposisi_opd = $request->input('disposisi_opd', 'P');
    $pengaduan->validasi_laporan = $request->input('validasi_laporan', 'P');
    $pengaduan->proses_tindak = $request->input('proses_tindak', 'P');
    $pengaduan->status_selesai = $request->input('status_selesai', null);
    $pengaduan->id_user_fk = auth()->user()->id;

    try {
        $pengaduan->save();
        $pengaduan->tanggal_lapor = $pengaduan->created_at;
        $pengaduan->save();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    } catch (\Exception $e) {
        \Log::error($e);
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    }
}



    public function view_edit_pengaduan($id_pengaduan) {

        $laporans = Pengaduan::findOrFail($id_pengaduan);

        return view('pengadu.edit_laporan', [
            'active' => 'beranda',
            'categories' => Category::all(),
            'desas' => Desa::all(),
            'kecamatans' => Kecamatan::all(),
            'opds' => Opd::where('name', '!=', 'pengadu')->get(['id', 'name']),
            'laporan' => $laporans,
        ]);
    }
    public function view_edit_pengaduan_invalid($id_pengaduan) {

        $laporans = Pengaduan::findOrFail($id_pengaduan);

        return view('pengadu.edit_laporan_invalid', [
            'active' => 'beranda',
            'categories' => Category::all(),
            'desas' => Desa::all(),
            'kecamatans' => Kecamatan::all(),
            'opds' => Opd::where('name', '!=', 'pengadu')->get(['id', 'name']),
            'laporan' => $laporans,
        ]);
    }

    public function update_pengaduan(Request $request, $id_pengaduan)
    {
        $laporan = Pengaduan::find($id_pengaduan);
        // Jika laporan tidak ditemukan, tampilkan halaman 404.
        if (!$laporan) {
            abort(404);
        }

        // Validasi
        $request->validate([
            'id_category_fk' => 'required',
            'id_kecamatan_fk' => 'required',
            'id_desa_fk' => 'required',
            'isi_laporan' => 'required',
            'lokasi_kejadian' => 'required',
            'tanggal_kejadian' => 'required',
            'id_opd_fk' => 'required',
            'lampiran' => 'nullable|file|mimes:pdf|max:5048',
            'first_image' => 'nullable|mimes:jpeg,png|max:5048',
            'sec_image' => 'nullable|mimes:jpeg,png|max:5048',
            'anonim' => 'nullable|in:Y',
        ]);

        // Mengupdate data laporan
        $laporan->id_category_fk = $request->id_category_fk;
        $laporan->isi_laporan = $request->isi_laporan;
        $laporan->id_kecamatan_fk = $request->input('id_kecamatan_fk');
        $laporan->id_desa_fk = $request->input('id_desa_fk');
        //cari id_kelurahan di objek desa
            $desa = Desa::find($request->id_desa_fk);
            $id_kelurahan = $desa->kelurahan->id;
            $laporan->id_kelurahan_fk = $id_kelurahan;
        $laporan->lokasi_kejadian = $request->lokasi_kejadian;
        $laporan->latitude = $request->latitude;
        $laporan->longitude = $request->longitude;
        $laporan->tanggal_kejadian = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_kejadian)->format('Y-m-d');
        $laporan->anonim = $request->has('anonim') ? 'Y' : 'N';

        if ($laporan->disposisi_opd == 'N' && $laporan->id_opd_fk == $request->id_opd_fk) {
            $laporan->id_opd_fk = $request->id_opd_fk;
            $laporan->validasi_laporan = 'P';
            $laporan->disposisi_opd = 'P';
            $laporan->tanggal_lapor = Carbon::now();
    
        } elseif ($laporan->disposisi_opd == 'N' && $laporan->id_opd_fk !== $request->id_opd_fk) { //laporan di alihkan ke OPD lain.
            $laporan->id_opd_fk = $request->id_opd_fk;
            $laporan->disposisi_opd = 'P';
            $laporan->validasi_laporan = 'P';
            $laporan->tanggal_lapor = Carbon::now();
        }
        
            // Menghandle unggah lampiran dan gambar
        if ($request->hasFile('lampiran')) {
            // Menghapus file lama jika ada
            if ($laporan->lampiran) {
                Storage::delete($laporan->lampiran);
            }
            // Mengunggah file baru
            $laporan->lampiran = $request->file('lampiran')->store('pengaduan-dokumen-lampiran');
        }

        if ($request->hasFile('first_image')) {
            // Menghapus file lama jika ada
            if ($laporan->first_image) {
                Storage::delete($laporan->first_image);
            }
            // Mengunggah file baru
            $laporan->first_image = $request->file('first_image')->store('pengaduan-images');
        }

        if ($request->hasFile('sec_image')) {
            // Menghapus file lama jika ada
            if ($laporan->sec_image) {
                Storage::delete($laporan->sec_image);
            }
            // Mengunggah file baru
            $laporan->sec_image = $request->file('sec_image')->store('pengaduan-images');
        }

        // Menyimpan perubahan ke database
        if ($laporan->save()) {
            return redirect('/laporanterkirim')->with('edited', 'Laporan berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui laporan. Silakan coba lagi.');
        }
}
    
public function update_pengaduan_invalid(Request $request, $id_pengaduan)
{
    $laporan = Pengaduan::find($id_pengaduan);
    // Jika laporan tidak ditemukan, tampilkan halaman 404.
    if (!$laporan) {
        abort(404);
    }

    // Validasi
    $request->validate([
        'id_category_fk' => 'required',
        'id_kecamatan_fk' => 'required',
        'id_desa_fk' => 'required',
        'isi_laporan' => 'required',
        'lokasi_kejadian' => 'required',
        'tanggal_kejadian' => 'required',
        'id_opd_fk' => 'required',
        'lampiran' => 'nullable|file|mimes:pdf|max:5048',
        'first_image' => 'nullable|mimes:jpeg,png|max:5048',
        'sec_image' => 'nullable|mimes:jpeg,png|max:5048',
        'anonim' => 'nullable|in:Y',
    ]);

    // Mengupdate data laporan
    $laporan->id_category_fk = $request->id_category_fk;
    $laporan->isi_laporan = $request->isi_laporan;
    $laporan->id_kecamatan_fk = $request->input('id_kecamatan_fk');
    $laporan->id_desa_fk = $request->input('id_desa_fk');
    //cari id_kelurahan di objek desa
        $desa = Desa::find($request->id_desa_fk);
        $id_kelurahan = $desa->kelurahan->id;
        $laporan->id_kelurahan_fk = $id_kelurahan;
    $laporan->lokasi_kejadian = $request->lokasi_kejadian;
    $laporan->latitude = $request->latitude;
    $laporan->longitude = $request->longitude;
    $laporan->tanggal_kejadian = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_kejadian)->format('Y-m-d');
    $laporan->anonim = $request->has('anonim') ? 'Y' : 'N';


    if ($laporan->disposisi_opd == 'Y' && $laporan->validasi_laporan == 'N' && $laporan->id_opd_fk == $request->id_opd_fk) {
        $laporan->id_opd_fk = $request->id_opd_fk;
        $laporan->validasi_laporan = 'P';
        $laporan->tanggal_disposisi = Carbon::now();

    } elseif ($laporan->disposisi_opd == 'Y' && $laporan->validasi_laporan == 'N' && $laporan->id_opd_fk !== $request->id_opd_fk) {
        $laporan->id_opd_fk = $request->id_opd_fk;
        $laporan->disposisi_opd = 'P';
        $laporan->validasi_laporan = 'P';
        $laporan->tanggal_lapor = Carbon::now();
    }
    
        // Menghandle unggah lampiran dan gambar
    if ($request->hasFile('lampiran')) {
        // Menghapus file lama jika ada
        if ($laporan->lampiran) {
            Storage::delete($laporan->lampiran);
        }
        // Mengunggah file baru
        $laporan->lampiran = $request->file('lampiran')->store('pengaduan-dokumen-lampiran');
    }

    if ($request->hasFile('first_image')) {
        // Menghapus file lama jika ada
        if ($laporan->first_image) {
            Storage::delete($laporan->first_image);
        }
        // Mengunggah file baru
        $laporan->first_image = $request->file('first_image')->store('pengaduan-images');
    }

    if ($request->hasFile('sec_image')) {
        // Menghapus file lama jika ada
        if ($laporan->sec_image) {
            Storage::delete($laporan->sec_image);
        }
        // Mengunggah file baru
        $laporan->sec_image = $request->file('sec_image')->store('pengaduan-images');
    }

    // Menyimpan perubahan ke database
    if ($laporan->save()) {
        return redirect('/laporanterkirim')->with('edited', 'Laporan berhasil diperbarui!');
    } else {
        return redirect()->back()->with('error', 'Gagal memperbarui laporan. Silakan coba lagi.');
    }
}

}

