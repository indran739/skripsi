@extends('layouts.main_opd_sec')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
    @if(Session::has('selesai'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan Sudah dinyatakan selesai</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(Session::has('updatedcategories'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Data Laporan berhasil diedit</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Laporan Selesai</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminopd">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Selesai</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    <!-- /.content-header -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header"> 
                        <div class="row">
                            <div class="col-8">
                                <select class="form-control filter select2" style="width: 35%;" name="id_category_fk" id="id_category_fk" required>
                                    <option selected="selected">Filter Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn bg-gradient-info ml-3">
                                    <a href="/laporanselesaiopd"  style="text-decoration: none; color:white;"><i class="fas fa-reset"></i>Reset</a> 
                                </button>
                            </div>
                            <div class="col-4">
                                <div class="input-group input-group-md" style="width: 100%;">
                                    <input type="text" id="searchTerm" class="form-control" placeholder="Cari berdasarkan isi laporan...">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-8">
                                <form action="{{ url('/cetak-laporan-selesai-opd') }}" method="post">
                                    @csrf
                                    <select class="form-control select2" style="width: 20%;" name="rentang" required>
                                        <option selected="selected" value="">Pilih Rentang</option>
                                        <option value="1">1 Bulan Terakhir</option>
                                        <option value="3">3 Bulan Terakhir</option>
                                        <option value="6">6 Bulan Terakhir</option>
                                        <option value="12">1 Tahun Terakhir</option>
                                        <option value="2022">Tahun 2022</option>
                                    </select>
                                    <button type="submit" class="btn bg-gradient-olive ml-3">Cetak Laporan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap" id="laporanTable">
                        <thead>
                            <tr>
                            <th>No</th>
                            <th>Isi Laporan</th>
                            <th>Tanggal Tindak</th>
                            <th>Tanggal Selesai</th>
                            <th>Kategori</th>
                            <th class="">Status</th>
                            <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTable">
                    @if(count($laporans) > 0)
                        @php
                            $no = 1
                        @endphp
                        @foreach($laporans as $laporan)
                            <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ Str::limit($laporan->isi_laporan, 50) }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_tindak)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan->tgl_dinyatakan_selesai)->format('d F Y') }}</td>
                            <td>{{ $laporan->category->name }}</td>
                            
                            @if ($laporan->status_selesai == 'Y')
                                <td>
                                    <div><span class="badge badge-success">Selesai</span><br>{{\Carbon\Carbon::parse($laporan->tgl_dinyatakan_selesai)->diffForHumans()}}</div>
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
                          
                            <td style="text-align: center;" colspan="2">
                                <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                                    <a href="/detailpengaduanopd/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                </button>
                                <button type="button"  class="ml-2 btn bg-gradient-warning" data-toggle="modal" data-target="#modal-edit-kategori__{{ $laporan->id }}">
                                    <a style="text-decoration: none; color:black;"><i class="fas fa-edit"></i></a>
                                </button>
                                    <div class="modal fade" id="modal-edit-kategori__{{ $laporan->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Kategori</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="fw-bold">Pilihlah Kategori yang sesuai untuk laporan pengaduan</h5>
                                        <form method="post" action="/editkategorilaporan/{{ $laporan->id }}">
                                            @csrf
                                            @method('put')
                                            <select class="form-control select2" style="width: 100%;" name="id_category_fk" required>
                                                <option selected="selected">Pilih Kategori Pengaduan</option>
                                                @foreach($kategori as $category)
                                                    <option value="{{ $category->id }}"  @if($laporan->id_category_fk == $category->id) selected @endif>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="submit" class="btn btn-success">Simpan</button> 
                                                <a href="" data-dismiss="modal" class="btn btn-danger">Batal</a>
                                            </div>
                                        </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
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
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                </div>
                <!-- /.row -->
            </div>
        <!-- /.card -->
</div><!-- /.container-fluid -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    $('#searchTerm').on('input', function () {
        var searchTerm = $(this).val();
        $.ajax({
            url: '/searchopd', // Ganti dengan URL yang sesuai dengan endpoint pencarian
            method: 'GET',
            data: { searchTerm: searchTerm },
            success: function (data) {
                // Perbarui tampilan dengan hasil pencarian
                var results = data.results;
                var tableBody = $('#bodyTable');
                tableBody.empty();

                if (results.length > 0) {
                    $.each(results, function (index, result) {
                        var formattedDate = result.tgl_dinyatakan_selesai ? new Date(result.tgl_dinyatakan_selesai).toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';
                        var formattedTindakDate = result.tanggal_tindak ? new Date(result.tanggal_tindak).toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';

                        var rowNumber = index + 1; // Nomor urut, dimulai dari 1
                        var row = '<tr>';
                        row += '<td>' + rowNumber + '</td>';
                        row += '<td>' + result.isi_laporan + '</td>';
                        row += '<td>' + formattedTindakDate + '</td>'; // Menggunakan tanggal yang sudah diformat
                        row += '<td>' + formattedDate + '</td>'; // Menggunakan tanggal yang sudah diformat
                        row += '<td>' + result.category.name + '</td>';
                        row += '<td>' + getStatusBadge(result.status_selesai) + '</td>';
                        row += '<td style="text-align: center;" colspan="2"><button type="button" class="btn bg-gradient-info"><a href="/detailpengaduanopd/' + result.id + '" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a></button> </td>';
                        row += '</tr>';
                        tableBody.append(row);
                    });
                } else {
                    var noData = '<tr><td colspan="7" style="text-align: center;">No Data</td></tr>';
                    tableBody.append(noData);
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    function getStatusBadge(status_selesai, proses_tindak, validasi_laporan, disposisi_opd) {
            if (status_selesai === 'Y') {
                return '<div><span class="badge badge-success">Selesai</span></div>';
            } else if (proses_tindak === 'Y') {
                return '<div><span class="badge badge-dark">Ditindak</span></div>';
            } else if (validasi_laporan === 'Y') {
                return '<div><span class="badge badge-info">Valid</span></div>';
            } else if (disposisi_opd === 'Y') {
                return '<div class=""><span class="badge badge-primary">Disposisi</span></div>';
            } else {
                return '<div class=""><span class="badge badge-warning">Proses Disposisi</span></div>';
            }
        }

});

</script>

<script>
    $(document).ready(function(){
        // Inisialisasi Select2 untuk elemen select form
        $('.select2').select2();

        // Fungsi untuk memfilter data saat nilai select form berubah
        $('.filter').change(function(){
            filterData();
        });

        // Fungsi untuk memfilter data dan memperbarui tabel
        function filterData() {
            var idCategory = $('#id_category_fk').val();

            // Lakukan filter hanya jika kedua nilai select form sudah dipilih
            if(idCategory !== 'Pilih Kategori'){
                $.ajax({
                    url: '{{ route("laporanselesaiopd.filter") }}',
                    method: 'GET',
                    data: {
                        id_category_fk: idCategory
                    },
                    success: function(data){
                        // Perbarui tabel dengan data yang difilter
                        var laporans = data.laporans;
                        var tableBody = '';
                        if (laporans.data.length > 0) {
                            $.each(laporans.data, function(index, laporan){

                                var formattedDateCreated = laporan.tanggal_lapor ? new Date(laporan.tanggal_tindak).toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';
                                // Format tanggal
                                var formattedDateUpdated = laporan.tgl_dinyatakan_selesai ? new Date(laporan.tgl_dinyatakan_selesai).toLocaleDateString('en-GB', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';
                                // Bangun baris tabel
                                tableBody += '<tr>' +
                                    '<td>' + (index + 1) + '</td>' + // Nomor urut
                                    '<td>' + (laporan.isi_laporan ? laporan.isi_laporan.substring(0, 50) : '') + '</td>' +
                                    '<td>' + formattedDateCreated + '</td>' +
                                    '<td>' + formattedDateUpdated + '</td>' +
                                    '<td>' + (laporan.category && laporan.category.name ? laporan.category.name : '') + '</td>' +
                                    '<td>' + getStatusBadge(laporan.status_selesai) + '</td>' +
                                    '<td style="text-align: center;" colspan="2"><button type="button" class="btn bg-gradient-info"><a href="/detailpengaduanopd/' + laporan.id + '" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a></button></td>' +
                                    '</tr>';
                            });
                        } else {
                            tableBody += '<tr><td colspan="7" style="text-align: center;">No Data</td></tr>';
                        }
                        // Perbarui isi tabel
                        $('#laporanTable tbody').html(tableBody);
                    }
                });
            }
    }

        function getStatusBadge(status_selesai, proses_tindak, validasi_laporan, disposisi_opd) {
            if (status_selesai === 'Y') {
                return '<div><span class="badge badge-success">Selesai</span></div>';
            } else if (proses_tindak === 'Y') {
                return '<div><span class="badge badge-dark">Ditindak</span></div>';
            } else if (validasi_laporan === 'Y') {
                return '<div><span class="badge badge-info">Valid</span></div>';
            } else if (disposisi_opd === 'Y') {
                return '<div class=""><span class="badge badge-primary">Disposisi</span></div>';
            } else {
                return '<div class=""><span class="badge badge-warning">Proses Disposisi</span></div>';
            }
        }
    });
    
</script>

@endsection