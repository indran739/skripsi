@extends('layouts.main')   
@section('container')
<div class="container" style="margin-top:80px; margin-bottom:80px;">
  <div class="d-flex justify-content-center row">
    <div class="col-6">
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Laporan Pengaduan Berhasil dikirim!</strong> Anda dapat Menunggu Validasi dan Tindak Lanjut dari Admin Instansi.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
        <div class="card-header fw-bold bg-dark">
            <h5 class="fw-bold text-light">SILAHKAN BUAT LAPORAN ANDA</h5>
        </div>
    <form method="post" action="/store" enctype="multipart/form-data">
    @csrf        
        <div class="card-body">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Isi Pengaduan</label>
                <textarea class="form-control @error('isi_pengaduan') is-invalid @enderror" id="exampleFormControlTextarea1" name="isi_laporan" required value="{{ old('isi_laporan') }}" rows="3" placeholder="Ketik Isi Pengaduan Anda"></textarea>
                @error('isi_laporan')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div> 
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Tanggal Kejadian</label>
                <input type="date" class="form-control @error('tanggal_kejadian') is-invalid @enderror" name="tanggal_kejadian" required value="{{ old('tanggal_kejadian') }}" id="exampleFormControlInput1" placeholder="Pilih Tanggal Kejadian">
                @error('tanggal_kejadian')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div> 
                @enderror  
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Lokasi Kejadian</label>
                <input type="text" class="form-control @error('lokasi_kejadian') is-invalid @enderror" name="lokasi_kejadian" required value="{{ old('lokasi_kejadian') }}" id="exampleFormControlInput1" placeholder="Lokasi Detail Kejadian">
                @error('lokasi_kejadian')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div> 
                @enderror           
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="opd">OPD Tujuan</label>
                    <select class="form-select" id="inputGroupSelect01" name="id_opd_fk">
                    <option selected>Pilih OPD Tujuan</option>
                    @foreach($opds as $opd)
                        <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                    @endforeach
                    </select>   
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="kategori">Kategori Pengaduan</label>
                    <select class="form-select" id="inputGroupSelect01" name="id_category_fk">
                        <option selected>Pilih Kategori Pengaduan</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                    </select>   
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control  @error('lampiran') is-invalid @enderror" required value="{{ old('lampiran') }}" id="inputGroupFile02" name="lampiran">
                @error('lampiran')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div> 
                @enderror 
                <label class="input-group-text" for="inputGroupFile02">Lampiran Pedukung</label>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile02">Foto 1</label>
                <input type="file" class="form-control @error('first_image') is-invalid @enderror"  required value="{{ old('first_image') }}" id="inputGroupFile02" name="first_image">
                @error('first_image')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div> 
                @enderror 
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile02">Foto 2</label>
                <input type="file" class="form-control @error('first_image') is-invalid @enderror" required value="{{ old('first_image') }}" id="inputGroupFile02" name="sec_image">
                @error('sec_image')
                <div class="invalid-feedback">
                    {{ $message }}  
                </div> 
                @enderror 
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary" type="submit">LAPOR</button>
            </div>
        </div>
    </form>
    </div>  
    </div>
  </div>
</div>
@endsection
