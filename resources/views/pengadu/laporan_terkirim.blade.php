@extends('layouts.main_pengadu')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
    @if(Session::has('edited'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Laporan Pengaduan telah di update</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Laporan Terkirim</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Terkirim</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

            <div class="col-12 col-sm-12">
                <div class="card card-indigo card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="color: black;text-decoration: none;" id="custom-tabs-four-pending-tab" data-toggle="pill" href="#custom-tabs-four-pending" role="tab" aria-controls="custom-tabs-four-pending" aria-selected="true"><i class="fas fa-clock mr-2"></i>Menunggu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-tolak-tab" data-toggle="pill" href="#custom-tabs-four-tolak" role="tab" aria-controls="custom-tabs-four-tolak" aria-selected="false"><i class="fas fa-exclamation-circle mr-2"></i>Ditolak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-disposisi-tab" data-toggle="pill" href="#custom-tabs-four-disposisi" role="tab" aria-controls="custom-tabs-four-disposisi" aria-selected="false"><i class="fas fa-paper-plane mr-2"></i>Terdisposisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-invalid-tab" data-toggle="pill" href="#custom-tabs-four-invalid" role="tab" aria-controls="custom-tabs-four-invalid" aria-selected="false"><i class="fas fa-times-circle mr-2"></i>Tidak Valid</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-valid-tab" data-toggle="pill" href="#custom-tabs-four-valid" role="tab" aria-controls="custom-tabs-four-valid" aria-selected="false"><i class="fas fa-check-circle mr-2"></i></i>Valid</a>
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
                                        <th>OPD Tujuan</th>
                                        <th class="">Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($laporans_pending) > 0)
                                    @php
                                        $no = ($laporans_pending->currentPage() - 1) * $laporans_pending->perPage() + 1;
                                    @endphp
                                    @foreach($laporans_pending as $laporan)
                                        <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y') }}</td>
                                        <td>{{ $laporan->category->name }}</td>
                                        <td>{{ $laporan->opd->name }}</td>
                                        
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
                                                                <div class=""><span class="badge badge-warning">Menunggu</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_lapor)->diffForHumans()}}</div>
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endif
                                        @endif

                                        <td class="d-flex justify-content-center" colspan="2">
                                            <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                                                <a href="/detailpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
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
                                        {{ $laporans_pending->links('vendor.pagination.adminlte_sec') }}
                                    </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-tolak" role="tabpanel" aria-labelledby="custom-tabs-four-tolak-tab">
                        <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
                                            
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
                                            <th>OPD Tujuan</th>
                                            <th class="">Status</th> 
                                            <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @if(count($laporans_tolak) > 0)
                                        @php
                                            $no = ($laporans_tolak->currentPage() - 1) * $laporans_tolak->perPage() + 1;
                                        @endphp
                                        @foreach($laporans_tolak as $laporan)
                                            <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y') }}</td>
                                            <td>{{ $laporan->category->name }}</td>
                                            <td>{{ $laporan->opd->name }}</td>
                                            
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
                                                                <div><span class="badge badge-danger">Tidak valid</span></div>
                                                            </td>
                                                        @else
                                                            @if ($laporan->disposisi_opd == 'Y')
                                                                <td>
                                                                    <div class=""><span class="badge badge-primary">Terdisposisi</span></div>
                                                                </td>
                                                            @elseif($laporan->disposisi_opd == 'N')
                                                                <td>
                                                                    <div class=""><span class="badge badge-danger">Ditolak</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_disposisi)->diffForHumans()}}</div>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <div class=""><span class="badge badge-warning">Menunggu</span></div>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif
                                            @endif

                                            <td style="text-align: center;" colspan="2">
                                                <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                                                    <a href="/detailpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                                </button>
                                                <button type="button"  class="btn bg-gradient-warning">
                                                    <a href="/editpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:black;"><i class="fas fa-edit"></i></a>
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
                                            {{ $laporans_tolak->links('vendor.pagination.adminlte_sec') }}
                                        </div>
                            </div>
                        </div>
                    <div class="tab-pane fade" id="custom-tabs-four-disposisi" role="tabpanel" aria-labelledby="custom-tabs-four-disposisi-tab">
                    <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
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
                                            <th>OPD Tujuan</th>
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
                                            <td>{{ $laporan->opd->name }}</td>
                                            
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
                                                                    <div class=""><span class="badge badge-warning">Menunggu</span></div>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif
                                            @endif

                                            <td style="text-align: center;" colspan="2">
                                            <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                                                <a href="/detailpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
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
                                            {{ $laporans_disposisi->links('vendor.pagination.adminlte_sec') }}
                                        </div>
                            </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-invalid" role="tabpanel" aria-labelledby="custom-tabs-four-invalid-tab">
                    <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
                                            
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
                                            <th>OPD Tujuan</th>
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
                                            <td>{{ $laporan->opd->name }}</td>
                                            
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
                                                    <a href="/detailpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                                </button>
                                                <button type="button"  class="btn bg-gradient-warning">
                                                        <a href="/editpengaduaninvalid/{{ $laporan->id }}" style="text-decoration: none; color:black;"><i class="fas fa-edit"></i></a>
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
                    <div class="tab-pane fade" id="custom-tabs-four-valid" role="tabpanel" aria-labelledby="custom-tabs-four-valid-tab">
                    <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
                                            
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
                                            <th>OPD Tujuan</th>
                                            <th class="">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @if(count($laporans_valid) > 0)
                                        @php
                                            $no = ($laporans_valid->currentPage() - 1) * $laporans_valid->perPage() + 1;
                                        @endphp
                                        @foreach($laporans_valid as $laporan)
                                            <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y') }}</td>
                                            <td>{{ $laporan->category->name }}</td>
                                            <td>{{ $laporan->opd->name }}</td>
                                            
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
                                                <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                                                    <a href="/detailpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
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
                                            {{ $laporans_valid->links('vendor.pagination.adminlte_sec') }}
                                        </div>
                            </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-tindak" role="tabpanel" aria-labelledby="custom-tabs-four-tindak-tab">
                    <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
                                            
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
                                            <th>OPD Tujuan</th>
                                            <th class="">Status</th>
                                            <th style="text-align: center">Aksi</th>
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
                                            <td>{{ $laporan->opd->name }}</td>
                                            
                                            @if ($laporan->status_selesai == 'Y')
                                                <td>
                                                    <div><span class="badge badge-success">Selesai</span></div>
                                                </td>
                                                @else
                                                    @if ($laporan->proses_tindak == 'Y')
                                                        <td>
                                                            <div><span class="badge badge-dark">Ditindak</span> <br>{{\Carbon\Carbon::parse($laporan->tanggal_tindak)->diffForHumans()}}</div>
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
                                                <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                                                    <a href="/detailpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
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
                                            {{ $laporans_tindak->links('vendor.pagination.adminlte_sec') }}
                                        </div>
                            </div>
                    </div>
                </div>
                <!-- /.card -->
                </div>
            </div>
            </div>
        <!-- /.content-header -->
@endsection