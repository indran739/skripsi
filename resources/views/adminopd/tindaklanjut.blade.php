@extends('layouts.main_opd_sec')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Tindak Lanjut Pengaduan</h1>
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible mt-3 fade show" role="alert">
                <strong>Pengaduan ditindak lanjuti</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(Session::has('berhasil'))
            <div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">
                <strong>Pengaduan tidak ditindak lanjuti</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/adminopd">Beranda</a></li>
              <li class="breadcrumb-item"><a href="/laporanterdisposisiopd">Laporan Terdisposisi</a></li>
              <li class="breadcrumb-item active">Tindak Lanjut</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
    <form method="post" action="/prosestindak/{{$data->id}}">
    @csrf
    @method('put')
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tindak Lanjuti Pengaduan</h3>
              </div>
              <!-- /.card-header -->    
              <!-- form start -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">ID</label>
                        <input type="text" class="form-control" value="{{ $data->id }}" name="id" id="exampleInputEmail1" disabled>
                    </div>
                    <div class="form-group">
                        <label>Melanjutkan ke Proses Tindak Lanjut </label>
                        <select class="form-control" id="proses_tindak" name="proses_tindak">
                        @if($data->proses_tindak == 'Y')
                        <option value="Y" selected>Ya</option>
                        <option value="N">Tidak</option>
                        <option value="P">Pending</option>
                        @elseif($data->proses_tindak == 'P')
                        <option value="Y">Ya</option>
                        <option value="N">Tidak</option>
                        <option value="P" selected>Pending</option>
                        @else
                        <option value="Y">Ya</option>
                        <option value="N"  selected>Tidak</option>
                        <option value="P">Pending</option>
                        @endif 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Tindak</label>
                        <input type="date" id="inputField1" name="tanggal_tindak" class="form-control" value="{{ $data->tanggal_tindak }}" name="id">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Selesai</label>
                        <input type="date" id="inputField2" name="tanggal_selesai" class="form-control" value="{{ $data->tanggal_selesai }}" name="id">
                    </div>
                </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="row">
                          <div class="col-sm">
                              <button type="submit" class="btn btn-primary mr-4">Tindak</button> 
                              <a href="/laporanterdisposisiopd" class="btn btn-info">Kembali</a>
                          </div>
                      </div>
                    </div>
            </div>
        </div>
        <script>
            document.getElementById('proses_tindak').addEventListener('change', function() {
                var selectedOption = this.value;
                var inputField1 = document.getElementById('inputField1');
                var inputField2 = document.getElementById('inputField2');

                if (selectedOption === 'N') {
                    inputField1.disabled = true; // Menonaktifkan form input
                    inputField2.disabled = true; // Menonaktifkan form input
                } else {
                    inputField1.disabled = false; // Mengaktifkan form input
                    inputField2.disabled = false; // Mengaktifkan form input
                }
            });
        </script>

    </form>
@endsection