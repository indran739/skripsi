@extends('layouts.main_opd')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Laporan Masuk</h1>
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
                            <form action="{{ url('/cetak-laporan-belumtanggap') }}" method="post" target="_blank">
                                @csrf
                                <select class="form-control select2"style="width: 20%;" name="rentang" required>
                                    <option selected="selected" value="">Pilih Rentang</option>
                                    <option value="1">1 Bulan Terakhir</option>
                                    <option value="3">3 Bulan Terakhir</option>
                                    <option value="6">6 Bulan Terakhir</option>
                                    <option value="12">1 Tahun Terakhir</option>
                                </select>
                                <select class="form-control select2"style="width: 20%;" name="status" required>
                                    <option selected="selected" value="">Pilih Status</option>
                                    <option value="S">Semua</option>
                                    <option value="P">Pending</option>
                                    <option value="D">Terdisposisi</option>
                                    <option value="T">Ditolak</option>
                                    <option value="V">Valid</option>
                                    <option value="I">Tidak Valid</option>
                                    <option value="W">Ditindak</option>
                                </select>
                                <button type="submit" class="btn bg-gradient-olive ml-3">Cetak Laporan</button>
                            </form>
                        </div>
                        <div class="col-4">
                        </div>
                    </div>

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
                    </ul>
                    
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-pending" role="tabpanel" aria-labelledby="custom-tabs-four-pending-tab">
                        <div class="row">
                                <div class="col-12">
                                    <div class="card-tools d-flex justify-content-end">
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

                                        <td style="text-align: center;" colspan="2">
                                            <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                                                <a href="/detailpengaduanadmin/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                            </button>
                                            <button type="button" class="btn bg-gradient-primary mr-2" data-toggle="modal" data-target="#modal-default__{{ $laporan->id }}">
                                              <i class="fas fa-paper-plane"></i>
                                            </button>
                                            <button type="button" class="btn bg-gradient-danger" data-toggle="modal" data-target="#modal-tolak__{{ $laporan->id }}">
                                              <i class="fas fa-exclamation-circle"></i>
                                            </button>
                                              <!-- Modal Button Detail Pengaduan -->
                                                <div class="modal fade" id="modal-default__{{ $laporan->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <h4 class="modal-title">Disposisi</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                            <div class="modal-body">
                                                                <h5 class="text-center">Apakah anda ingin melakukan disposisi ?</h5>
                                                                <label class=" mt-2 d-flex justify-content-start">Beri tanggapan</label>
                                                                    <div class="row">
                                                                        <div class="col-sm">
                                                                        <form method="post" action="/disposisi/{{$laporan->id}}">
                                                                        @csrf
                                                                        @method('put')
                                                                            <div class="form-group">
                                                                                <textarea class="form-control" rows="3" name="tanggapan" id="id_tanggapan" placeholder="Beri tanggapan pengaduan..."></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                                <div class="modal-footer justify-content-center">
                                                                        <input type="hidden" name="disposisi_opd" value="Y">
                                                                        <button type="submit" class="btn btn-success mr-3">Disposisi</button>
                                                                        <a href="" class="btn bg-gradient-danger">Batal</a>
                                                                    </form>
                                                                </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                      </div>
                                                      <!-- /.modal-dialog -->
                                                </div>
                                            <!-- Modal Button Detail Pengaduan -->
                                            <div class="modal fade" id="modal-tolak__{{ $laporan->id }}">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <h4 class="modal-title">Tolak</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body">
                                                            <h5 class="text-center">Apakah anda ingin menolak laporan ini ?</h5>
                                                            <label class=" mt-2 d-flex justify-content-start">Beri tanggapan</label>
                                                                <div class="row">
                                                                    <div class="col-sm">
                                                                        <!-- textarea -->
                                                                    <form method="post" action="/disposisi/{{$laporan->id}}">
                                                                    @csrf
                                                                    @method('put')
                                                                        <div class="form-group">
                                                                            <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                          </div>
                                                            <div class="modal-footer justify-content-center">
                                                                      <input type="hidden" name="disposisi_opd" value="N">
                                                                      <button type="submit" class="btn btn-success mr-3">Tolak</button>
                                                                      <a href="" class="btn bg-gradient-danger">Batal</a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                      </div>
                                                      <!-- /.modal-dialog -->
                                                    </div>
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
                                        {{ $laporans_pending->links('vendor.pagination.adminlte_sec') }}
                                    </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-tolak" role="tabpanel" aria-labelledby="custom-tabs-four-tolak-tab">
                        <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools d-flex justify-content-end">
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                            <th>Isi Laporan</th>
                                            <th>Tanggal Penolakan Disposisi</th>
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
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_disposisi)->format('d F Y') }}</td>
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
                                                                    <div class=""><span class="badge badge-warning">Pending</span></div>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif
                                            @endif

                                            <td style="text-align: center;" colspan="2">
                                                <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                                                    <a href="/detailpengaduanadmin/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
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
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <input type="text" id="searchTerdisposisi" style="width: 70%;" class="form-control" placeholder="Cari berdasarkan isi Laporan">             
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 mb-2 d-flex justify-content-end" style="">
                                    <select class="form-control" id="opdFilter" style="width: 30%;" name="id_opd_fk" required>
                                        <option selected="selected">-------- Filter OPD --------</option>
                                        @foreach($opds as $opd)
                                            @if($opd->name != 'pengadu' && $opd->name != 'Inspektorat Kabupaten Gunung Mas')
                                                <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    <select class="form-control ml-3" id="categoryFilter" style="width:30%;" name="id_category_fk" id="id_category_fk" required>
                                        <option selected="selected">-------- Filter Kategori -------</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                            <th>Isi Laporan</th>
                                            <th>Tanggal Disposisi</th>
                                            <th>Kategori</th>
                                            <th>OPD Tujuan</th>
                                            <th class="">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyTable">
                                    @if(count($laporans_disposisi) > 0) 
                                        @php $count = 1 @endphp
                                        @foreach($laporans_disposisi as $laporan)
                                            <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_disposisi)->format('d F Y') }}</td>
                                            <td>{{ $laporan->category->name }}</td>
                                            <td>{{ $laporan->opd->name }}</td>
                                            
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
                                                                <div><span class="badge badge-info">Valid</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_validasi)->diffForHumans()}}</div>
                                                            </td>
                                                        @elseif($laporan->validasi_laporan == 'N')
                                                            <td>
                                                                <div><span class="badge badge-danger">Tidak valid</span><br>{{\Carbon\Carbon::parse($laporan->tanggal_validasi)->diffForHumans()}}</div>
                                                            </td>
                                                        @else
                                                            @if ($laporan->disposisi_opd == 'Y')
                                                                <td>
                                                                    <div class=""><span class="badge badge-primary">Terdisposisi</span> <br>{{\Carbon\Carbon::parse($laporan->tanggal_disposisi)->diffForHumans()}}</div>
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
                                                <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                                                    <a href="/detailpengaduanadmin/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
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
                            </div>
                    </div>

        <!-- /.content-header -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    $('#searchTerdisposisi').on('input', function () {
        var searchTerm = $(this).val();
        $.ajax({
            url: '/search-laporan-disposisi', // Ganti dengan URL yang sesuai dengan endpoint pencarian
            method: 'GET',
            data: { searchTerm: searchTerm },
            success: function (data) {
                // Perbarui tampilan dengan hasil pencarian
                var results = data.results;
                var tableBody = $('#bodyTable');
                tableBody.empty();

                if (results.length > 0) {
                    $.each(results, function (index, result) {
                        var formattedDate = result.tanggal_disposisi ? new Date(result.tanggal_disposisi).toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';

                        var rowNumber = index + 1; // Nomor urut, dimulai dari 1
                        var row = '<tr>';
                        row += '<td>' + rowNumber + '</td>';
                        row += '<td>' + (result.isi_laporan ? result.isi_laporan.substring(0, 20) : '') + '</td>';
                        row += '<td>' + formattedDate + '</td>'; // Menggunakan tanggal yang sudah diformat
                        row += '<td>' + result.category.name + '</td>';
                        row += '<td>' + result.opd.name + '</td>';
                        row += '<td>' + getStatusBadge(result.status_selesai, result.proses_tindak, result.validasi_laporan, result.disposisi_opd) + '</td>';
                        row += '<td style="text-align: center;" colspan="2"><button type="button" class="btn bg-gradient-info"><a href="/detailpengaduanadmin/' + result.id + '" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a></button> </td>';
                        row += '</tr>';
                        tableBody.append(row);
                    });
                } else {
                    var noData = '<tr><td colspan="4" style="text-align: center;">No Data</td></tr>';
                    tableBody.append(noData);
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    function getStatusBadge(status_selesai, proses_tindak, validasi_laporan, disposisi_opd) {
        if (status_selesai == 'Y') {
            return '<div><span class="badge badge-success">Selesai</span></div>';
        } else if (proses_tindak == 'Y') {
            return '<div><span class="badge badge-dark">Ditindak</span></div>';
        } else if (validasi_laporan == 'Y') {
            return '<div><span class="badge badge-info">Valid</span></div>';
        } else if (validasi_laporan == 'N') {
            return '<div><span class="badge badge-danger">Tidak valid</span></div>';
        } else if (disposisi_opd == 'Y') {
            return '<div><span class="badge badge-primary">Terdisposisi</span></div>';
        } else if (disposisi_opd == 'N') {
            return '<div><span class="badge badge-danger">Ditolak</span></div>';
        } else {
            return '<div><span class="badge badge-warning">Menunggu</span></div>';
        }
    }

});

</script>

<script>
$(document).ready(function () {
    $('#opdFilter').on('change', function () {
        var selectedOpd = $(this).val();
        // Cek apakah nilai dropdown adalah "Pilih OPD"
        if (selectedOpd === '-------- Filter OPD --------') {
            // Muat ulang data seperti pada halaman awal
            window.location.href = '/laporanmasuk'; // Ganti dengan URL halaman awal Anda
            
        } else {

        $.ajax({
            url: '/search-laporan-disposisi', // Ganti dengan URL yang sesuai dengan endpoint pencarian
            method: 'GET',
            data: { opd: selectedOpd },
            success: function (data) {
                // Perbarui tampilan dengan hasil pencarian
                var results = data.results;
                var tableBody = $('#bodyTable');
                tableBody.empty();

                if (results.length > 0) {
                    $.each(results, function (index, result) {
                        var formattedDate = result.tanggal_disposisi ? new Date(result.tanggal_disposisi).toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';

                        var rowNumber = index + 1; // Nomor urut, dimulai dari 1
                        var row = '<tr>';
                        row += '<td>' + rowNumber + '</td>';
                        row += '<td>' + (result.isi_laporan ? result.isi_laporan.substring(0, 20) : '') + '</td>';
                        row += '<td>' + formattedDate + '</td>'; // Menggunakan tanggal yang sudah diformat
                        row += '<td>' + result.category.name + '</td>';
                        row += '<td>' + result.opd.name + '</td>';
                        row += '<td>' + getStatusBadge(result.status_selesai, result.proses_tindak, result.validasi_laporan, result.disposisi_opd) + '</td>';
                        row += '<td style="text-align: center;" colspan="2"><button type="button" class="btn bg-gradient-info"><a href="/detailpengaduanadmin/' + result.id + '" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a></button> </td>';
                        row += '</tr>';
                        tableBody.append(row);
                    });
                } else {
                    var noData = '<tr><td colspan="4" style="text-align: center;">No Data</td></tr>';
                    tableBody.append(noData);
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    });

            function getStatusBadge(status_selesai, proses_tindak, validasi_laporan, disposisi_opd) {
                if (status_selesai == 'Y') {
                    return '<div><span class="badge badge-success">Selesai</span></div>';
                } else if (proses_tindak == 'Y') {
                    return '<div><span class="badge badge-dark">Ditindak</span></div>';
                } else if (validasi_laporan == 'Y') {
                    return '<div><span class="badge badge-info">Valid</span></div>';
                } else if (validasi_laporan == 'N') {
                    return '<div><span class="badge badge-danger">Tidak valid</span></div>';
                } else if (disposisi_opd == 'Y') {
                    return '<div><span class="badge badge-primary">Terdisposisi</span></div>';
                } else if (disposisi_opd == 'N') {
                    return '<div><span class="badge badge-danger">Ditolak</span></div>';
                } else {
                    return '<div><span class="badge badge-warning">Menunggu</span></div>';
                }
            }

});
</script>

<script>
$(document).ready(function () {
    $('#categoryFilter').on('change', function () {
        var selectedCategory = $(this).val();
        // Cek apakah nilai dropdown adalah "Pilih OPD"
        if (selectedCategory === '-------- Filter Kategori --------') {
            // Muat ulang data seperti pada halaman awal
            window.location.href = '/laporanmasuk'; // Ganti dengan URL halaman awal Anda
        } else {

        $.ajax({
            url: '/search-laporan-disposisi', // Ganti dengan URL yang sesuai dengan endpoint pencarian
            method: 'GET',
            data: { category: selectedCategory },
            success: function (data) {
                // Perbarui tampilan dengan hasil pencarian
                var results = data.results;
                var tableBody = $('#bodyTable');
                tableBody.empty();

                if (results.length > 0) {
                    $.each(results, function (index, result) {
                        var formattedDate = result.tanggal_disposisi ? new Date(result.tanggal_disposisi).toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';

                        var rowNumber = index + 1; // Nomor urut, dimulai dari 1
                        var row = '<tr>';
                        row += '<td>' + rowNumber + '</td>';
                        row += '<td>' + (result.isi_laporan ? result.isi_laporan.substring(0, 20) : '') + '</td>';
                        row += '<td>' + formattedDate + '</td>'; // Menggunakan tanggal yang sudah diformat
                        row += '<td>' + result.category.name + '</td>';
                        row += '<td>' + result.opd.name + '</td>';
                        row += '<td>' + getStatusBadge(result.status_selesai, result.proses_tindak, result.validasi_laporan, result.disposisi_opd) + '</td>';
                        row += '<td style="text-align: center;" colspan="2"><button type="button" class="btn bg-gradient-info"><a href="/detailpengaduanadmin/' + result.id + '" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a></button> </td>';
                        row += '</tr>';
                        tableBody.append(row);
                    });
                } else {
                    var noData = '<tr><td colspan="4" style="text-align: center;">No Data</td></tr>';
                    tableBody.append(noData);
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    });

            function getStatusBadge(status_selesai, proses_tindak, validasi_laporan, disposisi_opd) {
                if (status_selesai == 'Y') {
                    return '<div><span class="badge badge-success">Selesai</span></div>';
                } else if (proses_tindak == 'Y') {
                    return '<div><span class="badge badge-dark">Ditindak</span></div>';
                } else if (validasi_laporan == 'Y') {
                    return '<div><span class="badge badge-info">Valid</span></div>';
                } else if (validasi_laporan == 'N') {
                    return '<div><span class="badge badge-danger">Tidak valid</span></div>';
                } else if (disposisi_opd == 'Y') {
                    return '<div><span class="badge badge-primary">Terdisposisi</span></div>';
                } else if (disposisi_opd == 'N') {
                    return '<div><span class="badge badge-danger">Ditolak</span></div>';
                } else {
                    return '<div><span class="badge badge-warning">Menunggu</span></div>';
                }
            }

});
</script>

@endsection