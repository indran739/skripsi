@extends('layouts.main_opd')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Kelola Kategori Pengaduan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Kategori Pengaduan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
<form method="post" action="/storekategori">
    @csrf
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Tambah Kategori</h3>
              </div>
              <!-- /.card-header -->    
              <!-- form start -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Kategori</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" required autofocus value="{{ old('name') }}" value="" name="name" id="">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}  
                        </div> 
                    @enderror  
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="row">
                          <div class="col-sm">
                              <button type="submit" class="btn btn-primary">Tambah</button> 
                              <a href="/kategori" class="btn btn-info">Kembali</a>
                          </div>
                      </div>
                    </div>
                </div>
                </form>
            <!-- /.card -->
@endsection