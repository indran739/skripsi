@extends('layouts.main_pengadu')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Laporan Selesai</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Selesai</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    <!-- /.content-header -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Laporan yang sudah selesai ditindak lanjuti</h3>

                        <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 500px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
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
                            <th>Tanggal Selesai</th>
                            <th>Kategori</th>
                            <th>OPD Tujuan</th>
                            <th class="">Status</th>
                            <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                    @if(count($laporans) > 0)
                        @php
                            $no = ($laporans->currentPage() - 1) * $laporans->perPage() + 1;
                        @endphp
                        @foreach($laporans as $laporan)
                            <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ Str::limit($laporan->isi_laporan, 50) }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan->tgl_dinyatakan_selesai)->format('d F Y') }}</td>
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
                                        @else
                                            @if ($laporan->disposisi_opd == 'Y')
                                                <td>
                                                    <div class=""><span class="badge badge-primary">Disposisi</span></div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class=""><span class="badge badge-warning">Proses Disposisi</span></div>
                                                </td>
                                            @endif
                                        @endif
                                    @endif
                            @endif

                            <td style="text-align:center;" colspan="2">
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
                                    {{ $laporans->links('vendor.pagination.adminlte_sec') }}
                                </div>
                            </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                </div>
                <!-- /.row -->
            </div>
        <!-- /.card -->
</div><!-- /.container-fluid -->
@endsection