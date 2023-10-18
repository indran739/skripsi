@extends('layouts.main_opd_sec')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan Sudah Tervalidasi</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('berhasil'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan tidak divalidasi atau ditolak</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
       
      @if(Session::has('tindak'))
      <div class="alert alert-success alert-dismissible mt-3 fade show" role="alert">
          <strong>Pengaduan ditindak lanjuti</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('tidaktindak'))
      <div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">
          <strong>Pengaduan tidak ditindak lanjuti</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('selesai'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan Sudah dinyatakan selesai</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('tidakselesai'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan dinyatakan belum selesai</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('tanggapi'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan telah ditambahkan</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif  

        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Laporan Terdisposisi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Masuk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row mt-3 ml-1 mb-3">
                        <div class="col-8">
                            <form action="{{ url('/cetak-laporan-belumtanggapopd') }}" method="post">
                                @csrf
                                <select class="form-control select2"style="width: 20%;" name="rentang" required>
                                    <option selected="selected" value="">Pilih Rentang</option>
                                    <option value="1">1 Bulan Terakhir</option>
                                    <option value="3">3 Bulan Terakhir</option>
                                    <option value="6">6 Bulan Terakhir</option>
                                </select>
                                <select class="form-control select2"style="width: 20%;" name="status" required>
                                    <option selected="selected" value="">Pilih Status</option>
                                    <option value="S">Semua</option>
                                    <option value="D">Terdisposisi</option>
                                    <option value="V">Valid</option>
                                    <option value="I">Tidak Valid</option>
                                    <option value="W">Ditindak</option>
                                </select>
                                <button type="submit" class="btn bg-gradient-olive ml-3">Cetak Laporan</button>
                            </form>
                        </div>
                        <div class="col-4">
                            <div class="input-group input-group-sm" style="width: 450px;">
                                <input type="text" name="table_search" class="form-control" placeholder="Search">
                                    <div class="input-group-append float-left">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </div>

            <div class="col-12 col-sm-12">
                <div class="card card-indigo card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="color: black;text-decoration: none;" id="custom-tabs-four-pending-tab" data-toggle="pill" href="#custom-tabs-four-pending" role="tab" aria-controls="custom-tabs-four-pending" aria-selected="true"><i class="fas fa-clock mr-2"></i>Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-invalid-tab" data-toggle="pill" href="#custom-tabs-four-invalid" role="tab" aria-controls="custom-tabs-four-invalid" aria-selected="false"><i class="fas fa-times-circle mr-2"></i></i>Tidak Valid</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-tindak-tab" data-toggle="pill" href="#custom-tabs-four-tindak" role="tab" aria-controls="custom-tabs-four-tindak" aria-selected="false"><i class="fas fa-cog mr-2"></i>Tindak Lanjut</a>
                    </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-pending" role="tabpanel" aria-labelledby="custom-tabs-four-pending-tab">
                        <div class="row">
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>Isi Laporan</th>
                                        <th>Tanggal Lapor</th>
                                        <th>Kategori</th>
                                        <th class="">Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($laporans_disposisi) > 0)
                                    @php
                                        $no = ($laporans_disposisi->currentPage() - 1) * $laporans_disposisi->perPage() + 1;
                                    @endphp
                                    @foreach($laporans_disposisi as $laporan)
                                        <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y') }}</td>
                                        <td>{{ $laporan->category->name }}</td>
                                        
                                        @if ($laporan->status_selesai == 'Y')
                                            <td>
                                                <div><span class="badge badge-success">Selesai</span></div>
                                            </td>
                                            @else
                                                @if ($laporan->proses_tindak == 'Y')
                                                    <td>
                                                        <div><span class="badge badge-dark">Ditindak</span></div>
                                                    </td>
                                                @else
                                                    @if ($laporan->validasi_laporan == 'Y')
                                                        <td>
                                                            <div><span class="badge badge-info">Valid</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_validasi)->diffForHumans()}}</div>
                                                        </td>
                                                    @elseif($laporan->validasi_laporan == 'N')
                                                        <td>
                                                            <div><span class="badge badge-danger">Tidak valid</span></div>
                                                        </td>
                                                    @else
                                                        @if ($laporan->disposisi_opd == 'Y')
                                                            <td>
                                                                <div class=""><span class="badge badge-primary">Terdisposisi</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_disposisi)->diffForHumans()}}</div>
                                                            </td>
                                                        @elseif($laporan->disposisi_opd == 'N')
                                                            <td>
                                                                <div class=""><span class="badge badge-danger">Ditolak</span></div>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <div class=""><span class="badge badge-warning">Pending</span></div>
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endif
                                        @endif

                                        <td style="text-align: center;" colspan="2">
                                            <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                                                <a href="/detailpengaduanopd/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                            </button>
                                            @if($laporan->validasi_laporan == 'P')
                                            <button type="button" class="btn bg-gradient-olive mr-2" data-toggle="modal" data-target="#modal-default__{{ $laporan->id }}">
                                              <i class="fas fa-check-circle"></i>
                                            </button>
                                            <button type="button" class="btn bg-gradient-red mr-2" data-toggle="modal" data-target="#modal-invalid__{{ $laporan->id }}">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                            <!-- Modal Button Detail Pengaduan -->
                                              <div class="modal fade" id="modal-default__{{ $laporan->id }}">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h4 class="modal-title">Validasi</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <h5 class="text-center">Apakah pengaduan ini valid?</h5>
                                                        <label class=" mt-2 d-flex justify-content-start">Beri tanggapan</label>
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                    <form method="post" action="/validasi/{{$laporan->id}}">
                                                                    @csrf
                                                                    @method('put')
                                                                        <div class="form-group">
                                                                            <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                      </div>
                                                        <div class="modal-footer justify-content-center">
                                                                <input type="hidden" name="validasi_laporan" value="Y">
                                                                <button type="submit" class="btn btn-success mr-3">Validasi</button>
                                                                <a href="" class="btn bg-gradient-danger">Batal</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                  </div>
                                                  <!-- /.modal-dialog -->
                                                </div>
                                                <!-- Modal Button Detail Pengaduan -->  
                                            <!-- Modal Button Detail Pengaduan -->
                                              <div class="modal fade" id="modal-invalid__{{ $laporan->id }}">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h4 class="modal-title">Invalid</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <h5 class="text-center">Apakah pengaduan ini tidak valid?</h5>
                                                        <label class=" mt-2 d-flex justify-content-start">Beri tanggapan</label>
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                    <form method="post" action="/validasi/{{$laporan->id}}">
                                                                    @csrf
                                                                    @method('put')
                                                                        <div class="form-group">
                                                                            <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan..." required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                      </div>
                                                        <div class="modal-footer justify-content-center">
                                                                <input type="hidden" name="validasi_laporan" value="N">
                                                                <button type="submit" class="btn btn-success mr-3">Invalid</button>
                                                                <a href="" class="btn bg-gradient-danger">Batal</a>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                  </div>
                                                  <!-- /.modal-dialog -->
                                                </div>
                                                <!-- Modal Button Detail Pengaduan -->  
                                              @endif
                                            @if($laporan->validasi_laporan == 'Y')
                                            <button type="button"  class="btn bg-gradient-dark mr-2" data-toggle="modal" data-target="#modal-tindak__{{ $laporan->id }}">
                                              <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="modal fade" id="modal-tindak__{{ $laporan->id }}"> 
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h4 class="modal-title">Tindak Lanjut</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                  <form method="post" action="/prosestindak/{{$laporan->id}}">
                                                  @csrf
                                                  @method('put')
                                                            <!-- /.card-header -->    
                                                            <!-- form start -->
                                                      <div class="card-body">
                                                          <input type="hidden" class="form-control" value="{{ $laporan->id }}" name="id" id="exampleInputEmail1">
                                                              <div class="form-group">
                                                                  <label class="d-flex justify-content-start" for="exampleInputEmail1">Tanggal Tindak</label>
                                                                  <input type="date" id="inputField1" name="tanggal_tindak" class="form-control" value="{{ $laporan->tanggal_tindak }}">
                                                              </div>
                                                                  <h7 class="d-flex justify-content-start mb-2 text-red" class="text-red">*tanggal yang diinputkan tidak dapat diubah</h7>
                                                              <div class="form-group mt-3">
                                                                  <label class="d-flex justify-content-start" for="exampleInputEmail1">Tanggal Estimasi Selesai</label>
                                                                  <input type="date" id="inputField2" name="tanggal_selesai" class="form-control" value="{{ $laporan->tanggal_selesai }}">
                                                              </div>
                                                                <h7 class="d-flex justify-content-start text-red">*tanggal yang diinputkan tidak dapat diubah</h7>
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer justify-content-between">
                                                        <div class="col-sm">
                                                          <button type="submit" class="btn btn-primary mr-4">Tindak</button> 
                                                            <a href="/laporanterdisposisiopd" class="btn btn-info">Kembali</a>
                                                        </div>
                                                  </div>
                                                </div>
                                                </form>
                                                <!-- /.modal-content -->
                                              </div>
                                              <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                            @endif
                                        </td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr> <td colspan="7" style="text-align: center;">No Data</td> </tr>
                                    @endif
                                    </tbody>
                                    </table>
                                </div>
                                <!-- Pagination Links -->
                                    <div class="container col-md-12 float-right mt-2 mb-3">
                                        {{ $laporans_disposisi->links('vendor.pagination.adminlte_sec') }}
                                    </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-invalid" role="tabpanel" aria-labelledby="custom-tabs-four-invalid-tab">
                        <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
                                            <div class="input-group input-group-sm" style="width: 500px;">
                                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                                <div class="input-group-append float-left">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                            <th>Isi Laporan</th>
                                            <th>Tanggal Lapor</th>
                                            <th>Kategori</th>
                                            <th class="">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @if(count($laporans_invalid) > 0)
                                        @php
                                            $no = ($laporans_invalid->currentPage() - 1) * $laporans_invalid->perPage() + 1;
                                        @endphp
                                        @foreach($laporans_invalid as $laporan)
                                            <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y') }}</td>
                                            <td>{{ $laporan->category->name }}</td>
                                            
                                            @if ($laporan->status_selesai == 'Y')
                                                <td>
                                                    <div><span class="badge badge-success">Selesai</span></div>
                                                </td>
                                                @else
                                                    @if ($laporan->proses_tindak == 'Y')
                                                        <td>
                                                            <div><span class="badge badge-dark">Ditindak</span></div>
                                                        </td>
                                                    @else
                                                        @if ($laporan->validasi_laporan == 'Y')
                                                            <td>
                                                                <div><span class="badge badge-info">Valid</span></div>
                                                            </td>
                                                        @elseif($laporan->validasi_laporan == 'N')
                                                            <td>
                                                                <div><span class="badge badge-danger">Tidak valid</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_validasi)->diffForHumans()}}</div>
                                                            </td>
                                                        @else
                                                            @if ($laporan->disposisi_opd == 'Y')
                                                                <td>
                                                                    <div class=""><span class="badge badge-primary">Terdisposisi</span></div>
                                                                </td>
                                                            @elseif($laporan->disposisi_opd == 'N')
                                                                <td>
                                                                    <div class=""><span class="badge badge-danger">Ditolak</span></div>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <div class=""><span class="badge badge-warning">Pending</span></div>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif
                                            @endif

                                            <td style="text-align: center;" colspan="2">
                                                <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                                                    <a href="/detailpengaduanopd/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                                </button>
                                            </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr> <td colspan="7" style="text-align: center;">No Data</td> </tr>
                                        @endif
                                        </tbody>
                                        </table>
                                    </div>
                                    <!-- Pagination Links -->
                                        <div class="container col-md-12 float-right mt-2 mb-3">
                                            {{ $laporans_invalid->links('vendor.pagination.adminlte_sec') }}
                                        </div>
                            </div>
                        </div>
                    <div class="tab-pane fade" id="custom-tabs-four-tindak" role="tabpanel" aria-labelledby="custom-tabs-four-tindak-tab">
                    <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
                                            <div class="input-group input-group-sm" style="width: 500px;">
                                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                                <div class="input-group-append float-left">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                            <th>Isi Laporan</th>
                                            <th>Tanggal Lapor</th>
                                            <th>Kategori</th>
                                            <th class="">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @if(count($laporans_tindak) > 0)
                                        @php
                                            $no = ($laporans_tindak->currentPage() - 1) * $laporans_tindak->perPage() + 1;
                                        @endphp
                                        @foreach($laporans_tindak as $laporan)
                                            <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y') }}</td>
                                            <td>{{ $laporan->category->name }}</td>
                                            
                                            @if ($laporan->status_selesai == 'Y')
                                                <td>
                                                    <div><span class="badge badge-success">Selesai</span></div>
                                                </td>
                                                @else
                                                    @if ($laporan->proses_tindak == 'Y')
                                                        <td>
                                                            <div><span class="badge badge-dark">Ditindak</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_tindak)->diffForHumans()}}</div>
                                                        </td>
                                                    @else
                                                        @if ($laporan->validasi_laporan == 'Y')
                                                            <td>
                                                                <div><span class="badge badge-info">Valid</span></div>
                                                            </td>
                                                        @elseif($laporan->validasi_laporan == 'N')
                                                            <td>
                                                                <div><span class="badge badge-danger">Tidak valid</span></div>
                                                            </td>
                                                        @else
                                                            @if ($laporan->disposisi_opd == 'Y')
                                                                <td>
                                                                    <div class=""><span class="badge badge-primary">Terdisposisi</span></div>
                                                                </td>
                                                            @elseif($laporan->disposisi_opd == 'N')
                                                                <td>
                                                                    <div class=""><span class="badge badge-danger">Ditolak</span></div>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <div class=""><span class="badge badge-warning">Pending</span></div>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif
                                            @endif

                                            <td style="text-align: center;" colspan="2">
                                                <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                                                    <a href="/detailpengaduanopd/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                                </button>
                                                <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modal-selesai__{{ $laporan->id }}">
                                                  <i class="fas fa-clipboard-check"></i>
                                                </button>
                                                <!-- Modal Button Detail Pengaduan -->
                                                  <div class="modal fade" id="modal-selesai__{{ $laporan->id }}">
                                                                      <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                          <div class="modal-header">
                                                                            <h4 class="modal-title">Status Selesai</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                              <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                          </div>
                                                                          <div class="modal-body">
                                                                                <h5 class="text-center">Update Status Pengaduan Selesai</h5>
                                                                                <label class=" mt-2 d-flex justify-content-start">Beri tanggapan</label>
                                                                                        <div class="row">
                                                                                            <div class="col-sm">
                                                                                            <form method="post" action="/statusselesai/{{$laporan->id}}">
                                                                                            @csrf
                                                                                            @method('put')
                                                                                                <div class="form-group">
                                                                                                    <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan..."></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                            </div>
                                                                                <div class="modal-footer justify-content-center">
                                                                                        <input type="hidden" name="status_selesai" value="Y">
                                                                                        <button type="submit" class="btn btn-success mr-3">Selesai</button>
                                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                                                    </form>
                                                                                </div>
                                                                        </div>
                                                                        <!-- /.modal-content -->
                                                                      </div>
                                                                      <!-- /.modal-dialog -->
                                                    </div>
                                                              <!-- Modal Button Detail Pengaduan -->
                                            </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr> <td colspan="7" style="text-align: center;">No Data</td> </tr>
                                        @endif
                                        </tbody>
                                        </table>
                                    </div>
                                    <!-- Pagination Links -->
                                        <div class="container col-md-12 float-right mt-2 mb-3">
                                            {{ $laporans_invalid->links('vendor.pagination.adminlte_sec') }}
                                        </div>
                            </div>
                    </div>

        <!-- /.content-header -->


@endsection