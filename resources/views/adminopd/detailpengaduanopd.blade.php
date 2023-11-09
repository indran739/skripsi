@extends('layouts.main_opd_sec')
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
 
    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan telah ditambahkan</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif  
    @if(Session::has('updatetanggapans'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan berhasil diedit</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(Session::has('deletetanggapans'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan berhasil dihapus</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Detail Pengaduan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininopd">Beranda</a></li>
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
                            <div class="col d-flex justify-content-between">
                                <div class="card-title">
                                    <h5>Tanggapan Admin</h5>
                                </div>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-tanggapi__{{ $laporan->id }}">
                                        <i class="fas fa-comment-medical mr-2"></i>Tambah Tanggapan
                                </button>
                                <!-- Modal Button Detail Pengaduan -->
                                <div class="modal fade" id="modal-tanggapi__{{ $laporan->id }}">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                            <form method="post" action="/storetanggapanopd">
                                                    @csrf
                                                    <div class="row">
                                                      <div class="col-sm">
                                                        <!-- textarea -->
                                                        <div class="form-group">
                                                          <input type="hidden" name="id_pengaduan_fk" value="{{ $laporan->id }}">
                                                          <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan..."></textarea>
                                                      </div>
                                                    </div>
                                              </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Tanggapi</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- Modal Button Detail Pengaduan -->
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
                                    @if($tanggapan->id_user_fk === auth()->user()->id )
                                    <div class="row">
                                    <div class="col-sm">
                                            <div class="d-flex justify-content-end"><a style="color: black;text-decoration: none;" id="" class="ml-3" href="" data-toggle="modal" data-target="#modal-update-tanggapan__{{ $tanggapan->id }}" ><i class="fas fa-edit"></i></a>
                                             <!-- Modal Button Detail Pengaduan -->
                                                <div class="modal fade" id="modal-update-tanggapan__{{ $tanggapan->id }}">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                        <form method="post" action="/edittanggapanopd/{{ $tanggapan->id }}">
                                                                @csrf
                                                                @method('put')
                                                                <div class="row">
                                                                <div class="col-sm">
                                                                    <!-- textarea -->
                                                                    <div class="form-group">
                                                                    <input type="hidden" name="id_pengaduan_fk" value="{{ $laporan->id }}">
                                                                    <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan...">{{ $tanggapan->tanggapan }}</textarea>
                                                                </div>
                                                                </div>
                                                        </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="submit" class="btn btn-primary">Tanggapi</button>
                                                                <button type="button" class="btn btn-danger " data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                    <!-- Modal Button Detail Pengaduan -->
                                    <div class="d-flex justify-content-end"><a style="color: black;text-decoration: none;" id="" class="ml-3" href="" data-toggle="modal" data-target="#modal-delete-tanggapan__{{ $tanggapan->id }}" ><i class="fas fa-trash"></i></a>
                                                </div>
                                                
                                                    <div class="modal fade" id="modal-delete-tanggapan__{{ $tanggapan->id }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <!-- <h4 class="modal-title">Default Modal</h4> -->
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="post" action="/hapustanggapanopd/{{ $tanggapan->id }}">
                                                                @csrf
                                                                <h5 class="d-flex justify-content-center">Apakah anda yakin menghapus tanggapan ini?</h5>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="submit" class="btn btn-primary">Hapus</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    </div>
                                        </div>       <!-- /.modal -->
                                    </div>
                                    @endif
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
                            <div class="col-sm d-flex justify-content-between">
                                <div class="card-title">
                                    <h5>Tanggapan Admin</h5>
                                </div>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-tanggapi__{{ $laporan->id }}">
                                        <i class="fas fa-comment-medical mr-2"></i>Tambah Tanggapan
                                </button>
                                <!-- Modal Button Detail Pengaduan -->
                                    <div class="modal fade" id="modal-tanggapi__{{ $laporan->id }}">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                            <form method="post" action="/storetanggapanopd">
                                                    @csrf
                                                    <div class="row">
                                                      <div class="col-sm">
                                                        <!-- textarea -->
                                                        <div class="form-group">
                                                          <input type="hidden" name="id_pengaduan_fk" value="{{ $laporan->id }}">
                                                          <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan..."></textarea>
                                                      </div>
                                                    </div>
                                              </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Tanggapi</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                <!-- Modal Button Detail Pengaduan -->
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
                                    @if($tanggapan->id_user_fk === auth()->user()->id )
                                    <div class="row">
                                    <div class="col-sm">
                                            <div class="d-flex justify-content-end"><a style="color: black;text-decoration: none;" id="" class="ml-3" href="" data-toggle="modal" data-target="#modal-update-tanggapan__{{ $tanggapan->id }}" ><i class="fas fa-edit"></i></a>
                                             <!-- Modal Button Detail Pengaduan -->
                                                <div class="modal fade" id="modal-update-tanggapan__{{ $tanggapan->id }}">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                        <form method="post" action="/edittanggapanopd/{{ $tanggapan->id }}">
                                                                @csrf
                                                                @method('put')
                                                                <div class="row">
                                                                <div class="col-sm">
                                                                    <!-- textarea -->
                                                                    <div class="form-group">
                                                                    <input type="hidden" name="id_pengaduan_fk" value="{{ $laporan->id }}">
                                                                    <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan...">{{ $tanggapan->tanggapan }}</textarea>
                                                                </div>
                                                                </div>
                                                        </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="submit" class="btn btn-primary">Tanggapi</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                    <!-- Modal Button Detail Pengaduan -->
                                    <div class="d-flex justify-content-end"><a style="color: black;text-decoration: none;" id="" class="ml-3" href="" data-toggle="modal" data-target="#modal-delete-tanggapan__{{ $tanggapan->id }}" ><i class="fas fa-trash"></i></a>
                                                </div>
                                                
                                                    <div class="modal fade" id="modal-delete-tanggapan__{{ $tanggapan->id }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <!-- <h4 class="modal-title">Default Modal</h4> -->
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="post" action="/hapustanggapanopd/{{ $tanggapan->id }}">
                                                                @csrf
                                                                <h5 class="d-flex justify-content-center">Apakah anda yakin menghapus tanggapan ini?</h5>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="submit" class="btn btn-primary">Hapus</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    </div>
                                        </div>       <!-- /.modal -->
                                    </div>
                                    @endif
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
                                    <dd class="col-sm-7 mb-2"> </dd> 
                                    <dt class="col-sm-5 mb-3">Kategori</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->category->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Kecamatan</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->kecamatan->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Kelurahan</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->kelurahan->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Desa</dt>
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->desa->name }}</dd>
                                    <dt class="col-sm-5 mb-3">Detail Lokasi</dt>
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
                                            aria-valuemax="100">Pending</div>
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
                                @if($laporan->lampiran)
                                    <dt class="col-sm-2 mb-2 ">
                                        @php
                                            $fileNameParts = explode('/', $laporan->lampiran);
                                            $fileName = end($fileNameParts);
                                        @endphp
                                        <a class="btn btn-app bg-gradient-info" href="{{ asset('storage/' . $laporan->lampiran) }}">
                                            <i class="fas fa-download"></i>Lampiran
                                        </a>
                                    </dt>
                                @endif
                        </dl>
                    </div>
                </div>
                <div class="card">
                        <div class="card-header">
                            <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-5 mb-4 h4">Data Pengadu</dt>
                                <dd class="col-sm-7 mb-3"> </dd> 
                                <dt class="col-sm-5 mb-3">NIK Pengadu</dt>
                                @if($laporan->anonim === 'Y')
                                    <dd class="col-sm-7 mb-3"> <span>:</span> - Anonim - </dd>  
                                @else
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->user->nik}}</dd>
                                @endif
                                <dt class="col-sm-5 mb-3">Nama Pengadu</dt>
                                @if($laporan->anonim === 'Y')
                                    <dd class="col-sm-7 mb-3"> <span>:</span> - Anonim - </dd>  
                                @else
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->user->name}}</dd>
                                @endif
                                <dt class="col-sm-5 mb-3">Alamat</dt>
                                @if($laporan->anonim === 'Y')
                                    <dd class="col-sm-7 mb-3"> <span>:</span> - Anonim - </dd>  
                                @else
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->user->alamat}}, {{$laporan->user->desa->name}}, {{$laporan->user->kecamatan->name}}, 74511</dd>
                                @endif
                                <dt class="col-sm-5 mb-3">Email</dt>
                                @if($laporan->anonim === 'Y')
                                <dd class="col-sm-7 mb-3"> <span>:</span> - Anonim - </dd>  
                                @else
                                <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->user->email}}</dd>
                                <dt class="col-sm-5 mb-3">No.Hp</dt>
                                @if($laporan->anonim === 'Y')
                                    <dd class="col-sm-7 mb-3"> <span>:</span> - Anonim - </dd>  
                                @else
                                    <dd class="col-sm-7 mb-3"> <span>:</span> {{ $laporan->user->no_hp}}</dd>
                                @endif
                                @endif
                                </dl>
                            </div>
                        </div>
                        </div>
                        
                    </div>
                </div>
            </div>
    </div>
<!--- row ---->

@endsection