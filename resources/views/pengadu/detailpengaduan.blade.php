@extends('layouts.main_pengadu')   
@section('container')
<style>
        /* CSS khusus untuk mengatur ukuran gambar dalam carousel */
        .carousel-inner img {
            width: 100%; /* Mengisi lebar parent */
            height: auto; /* Menjaga aspek rasio gambar */
        }
        /* Ganti warna ikon menjadi hitam */
        .carousel-control-custom-icon i {
            color: black;
        }

    </style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Detail Pengaduan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Detail Pengaduan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <section class="content">

<!-- Default box -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title"></h3>
  </div>

  <div class="card-body">
    <div class="row">
    @if($laporan->first_image || $laporan->sec_image )
      <div class="col-sm-5">
          <div class="card">
              <div class="card-header text-white" style="background-color:#4030A3;">
                <div class="card-title">
                    <h5>Foto</h5>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                    @if($laporan->first_image)
                        <img class="d-block" src="{{ asset('storage/' . $laporan->first_image) }}" alt="First slide">
                    @else
                     <h5 class="d-flex justify-content-center"> Tidak ada gambar.</h5>
                    @endif
                    </div>
                    <div class="carousel-item">
                    @if($laporan->sec_image)
                        <img class="d-block" src="{{ asset('storage/' . $laporan->sec_image) }}" alt="Second slide">
                    @else
                     <h5 class="d-flex justify-content-center"> Tidak ada gambar.</h5>
                    @endif
                    </div>
                  </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i> 
                    </span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-custom-icon" aria-hidden="true">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        <div class="container">
                <div class="card">
                    <div class="card-header text-white" style="background-color:#4030A3;">
                        <div class="card-title">
                            <h5>Tanggapan Admin</h5>
                        </div>
                    </div>
                        <div class="card-body">
                        @if(count($tanggapans) > 0)
                                @foreach ($tanggapans as $tanggapan)
                                <div class="post">
                                    <div class="user-block">
                                    @if($tanggapan->id_user_fk !== '3' && $tanggapan->user->jenis_kelamin == 'Laki-laki')
                                        <img src="{{asset('/')}}dist/img/avatar5.png" class="img-circle img-bordered-sm" alt="User Image">
                                    @else
                                        <img src="{{asset('/')}}dist/img/avatar3.png" class="img-circle img-bordered-sm" alt="User Image">
                                    @endif
                                    <span class="username">
                                        <a href="#">{{ $tanggapan->user->name }}</a>
                                    </span>
                                    <span class="description">Memberi tanggapan - {{ \Carbon\Carbon::parse($tanggapan->created_at)->format('d F Y, H:i') }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                    {{ $tanggapan->tanggapan }}
                                    </p>
                                </div>
                                @endforeach
                        @else
                            <p>Belum ada tanggapan untuk pengaduan ini</p>
                        @endif
                        </div>
                </div>
        </div>
    </div>
        
        @else
        <div class="col-sm-5">
          <div class="card">
              <div class="card-header text-white" style="background-color:#4030A3;">
                <div class="card-title">
                    <h5>Foto</h5>
                </div>
              </div>
              <div class="card-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                    @if($laporan->first_image)
                        <img class="d-block" src="{{ asset('storage/' . $laporan->first_image) }}" alt="First slide">
                    @else
                     <h5 class="d-flex justify-content-center"> Tidak ada gambar.</h5>
                    @endif
                    </div>
                    <div class="carousel-item">
                    @if($laporan->sec_image)
                        <img class="d-block" src="{{ asset('storage/' . $laporan->sec_image) }}" alt="Second slide">
                    @else
                     <h5 class="d-flex justify-content-center"> Tidak ada gambar.</h5>
                    @endif
                    </div>
                  </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i> 
                    </span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-custom-icon" aria-hidden="true">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
                <div class="card">
                    <div class="card-header text-white" style="background-color:#4030A3;">
                        <div class="card-title">
                            <h5>Tanggapan Admin</h5>
                        </div>
                    </div>
                        <div class="card-body">
                        @if(count($tanggapans) > 0)
                                @foreach ($tanggapans as $tanggapan)
                                <div class="post">
                                    <div class="user-block">
                                    @if($tanggapan->id_user_fk !== '3' && $tanggapan->user->jenis_kelamin == 'Laki-laki')
                                        <img src="{{asset('/')}}dist/img/avatar5.png" class="img-circle img-bordered-sm" alt="User Image">
                                    @else
                                        <img src="{{asset('/')}}dist/img/avatar3.png" class="img-circle img-bordered-sm" alt="User Image">
                                    @endif
                                    <span class="username">
                                        <a href="#">{{ $tanggapan->user->name }}</a>
                                    </span>
                                    <span class="description">Memberi tanggapan - {{ \Carbon\Carbon::parse($tanggapan->created_at)->diffForHumans() }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                    {{ $tanggapan->tanggapan }}
                                    </p>
                                </div>
                                @endforeach
                        @else
                            <p>Belum ada tanggapan untuk pengaduan ini</p>
                        @endif
                        </div>
                </div>
                
        <!--col-->
        @endif
              <!-- /.card-body -->
            </div>
            <div class="col-sm-7">
                   <div class="card">
                        <div class="card-header">
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-5 mb-3 h4">Data Laporan</dt>
                                    <dd class="col-sm-7 mb-2" style="text-align:right; display: flex; align-items: center;">
                                        @if (auth()->check())
                                            <span style="display: flex; align-items: center; margin-left: auto;">
                                              <!-- Jumlah Likes disamping tombol -->
                                              <span class="badge bg-gray disabled color-palette" style="font-size: 14px; display: flex; align-items: center; margin-right: 10px;">
                                                    <i class="fas fa-thumbs-up mr-2"></i>{{ $laporan->likes->count() }}
                                                </span>
                                                @if ($laporan->likes->where('id_user_fk', auth()->user()->id)->count() > 0)
                                                    {{-- Tombol untuk Unlike --}}
                                                    <form action="/unlike" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id_pengaduan_fk" value="{{ $laporan->id }}">
                                                        <button type="submit" class="btn bg-gradient-info"><i class="fas fa-thumbs-down mr-2"></i>Unlike</button>
                                                    </form>
                                                @else
                                                    {{-- Tombol untuk Like --}}
                                                    <form action="/like" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id_pengaduan_fk" value="{{ $laporan->id }}">
                                                        <button type="submit" class="btn bg-gradient-info"><i class="fas fa-thumbs-up mr-2"></i> Like</button>
                                                    </form>
                                                @endif
                                            </span>
                                        @endif
                                    </dd>
                                    <dt class="col-sm-5 mb-3">Nama Pengadu</dt>
                                    @if($laporan->anonim == 'Y' && $laporan->id_user_fk !== auth()->user()->id)
                                        <dd class="col-sm-7 mb-3"> <span>:</span> -Anonim- </dd>
                                    @else
                                        <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->user->name }} </dd>
                                    @endif
                                    <dt class="col-sm-5 mb-3">Kategori</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->category->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Kecamatan</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->kecamatan->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Kelurahan</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->kelurahan->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Desa</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->desa->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Lokasi Detail</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->lokasi_kejadian }}</dd>
                                    <dt class="col-sm-5 mb-3">OPD Tujuan</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->opd->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Tanggal Kejadian</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d F Y') }}</dd>
                                    <dt class="col-sm-5 mb-3">Tanggal Lapor</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y') }}</dd>
                                    <dt class="col-sm-5 mb-3">Tanggal Tindak Lanjut</dt>
                                    @if($laporan->tanggal_tindak === NULL)
                                    <dd class="col-sm-7 mb-3"> <span>:</span> - </dd>
                                    @else
                                    <dd class="col-sm-5 mb-3"> <span>:</span> {{ \Carbon\Carbon::parse($laporan->tanggal_tindak)->format('d F Y') }}</dd>
                                    @endif
                                    <dt class="col-sm-5 mb-3">Tanggal Estimasi Selesai</dt>
                                    @if($laporan->tanggal_selesai === NULL)
                                    <dd class="col-sm-5 mb-3"> <span>:</span> - </dd>
                                    @else
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ \Carbon\Carbon::parse($laporan->tanggal_selesai)->format('d F Y') }}</dd>
                                    @endif
                                    <dt class="col-sm-5 mb-3">Tanggal dinyatakan Selesai</dt>
                                    @if($laporan->tanggal_selesai === NULL && $laporan->status_selesai === NULL)
                                    <dd class="col-sm-7 mb-3"> <span>:</span> - </dd>
                                    @elseif($laporan->tanggal_selesai && $laporan->status_selesai === NULL)
                                    <dd class="col-sm-5 mb-3"> <span>:</span> - </dd>
                                    @elseif($laporan->tanggal_selesai && $laporan->status_selesai == 'Y')
                                        <dd class="col-sm-7 mb-3"> <span>:</span> {{ \Carbon\Carbon::parse($laporan->tgl_dinyatakan_selesai)->format('d F Y') }} </dd>
                                        @endif
                                    <dt class="col-sm-5 mb-2">Isi Laporan :</dt>
                                    <dd>{{ $laporan->isi_laporan }}</dd>
                                    <dt class="col-sm-5 mt-3">Progress Bar</dt>
                                        <div class="container mt-2 ml-2">
                                        <div class="progress" style="height: 30px; font-size:16px">
                                            @if ($laporan->disposisi_opd && $laporan->disposisi_opd == 'Y')
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Menunggu</div>
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Terdisposisi</div>
                                            @elseif($laporan->disposisi_opd && $laporan->disposisi_opd == 'N')
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Menunggu</div>
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                            role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Ditolak</div>
                                            @elseif($laporan->disposisi_opd && $laporan->disposisi_opd == 'P')
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Menunggu</div>
                                            @endif
                                            @if ($laporan->validasi_laporan && $laporan->validasi_laporan == 'Y')
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Valid</div>
                                            @elseif($laporan->validasi_laporan && $laporan->validasi_laporan == 'N')
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                            role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Tidak Valid</div>
                                            @elseif($laporan->validasi_laporan && $laporan->validasi_laporan == 'P')
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                            @endif
                                            @if ($laporan->proses_tindak && $laporan->tanggal_tindak)
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark"
                                            role="progressbar" style="width: 25%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Tindak Lanjut</div>
                                            @else
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                            @endif
                                            @if ($laporan->status_selesai)
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 25%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100">Selesai</div>
                                            @else
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        </dl>
                    </div>
                </div>
            </div>
    </div>
<!--- row ---->

<!-- /.card -->

@endsection