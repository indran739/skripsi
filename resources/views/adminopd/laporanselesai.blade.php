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
                    <form id="filterForm"> <!-- Menambahkan ID "filterForm" pada elemen form -->
                        <select class="form-control select2" style="width: 25%;" name="id_category_fk" id="id_category_fk" required> <!-- Menambahkan ID "id_category_fk" -->
                            <option selected="selected">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                        </select>
                        <button type="button" class="btn bg-gradient-olive ml-3" id="filterButton"> <!-- Menambahkan ID "filterButton" -->
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </form>
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
                        <table class="table table-hover text-nowrap" id="laporanTable">
                        <thead>
                            <tr>
                            <th>No</th>
                            <th>Isi Laporan</th>
                            <th>Tanggal Tindak</th>
                            <th>Tanggal Selesai</th>
                            <th>Kategori</th>
                            <th class="">Status</th>
                            <th style="text-align: center;">Kecepatan Kinerja</th>
                            <th style="text-align: center;">Aksi</th>
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
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_tindak)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($laporan->updated_at)->format('d F Y') }}</td>
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
                            @if($laporan->kecepatan == "Cepat")
                            <td><div class="d-flex justify-content-center"><span class="badge badge-success">Cepat</span></div></td>
                            @elseif($laporan->kecepatan == "Tepat Waktu")
                            <td><div class="d-flex justify-content-center"><span class="badge badge-info">Tepat Waktu</span></div></td>
                            @elseif($laporan->kecepatan == "Lambat")
                            <td><div class="d-flex justify-content-center"><span class="badge badge-danger">Lambat</span></div></td>
                            @elseif($laporan->kecepatan == NULL)
                            <td><div class="d-flex justify-content-center"><span class="badge badge-danger">Tidak ada</span></div></td>
                            @endif
                            <td style="text-align: center;" colspan="2">
                                <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#filterButton').click(function(){
            var idCategory = $('#id_category_fk').val();

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
                    console.log(data); 
                    if (laporans.data.length > 0) {
                        $.each(laporans.data, function(index, laporan){
                            // Mengonversi tanggal updated_at ke format 'd M Y'
                            var formattedDateupdated = laporan.updated_at ? new Date(laporan.updated_at).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            }) : '';

                            var formattedDatecreated = laporan.updated_at ? new Date(laporan.tanggal_tindak).toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            }) : '';

                            // Membuat baris tabel untuk setiap laporan
                            tableBody += '<tr>' +
                                '<td>' + ((laporans.current_page - 1) * laporans.per_page + index + 1) + '</td>' + // Menggunakan formula untuk menghitung nomor urut pada setiap halaman
                                '<td>' + (laporan.isi_laporan ? laporan.isi_laporan.substring(0, 50) : '') + '</td>' +
                                '<td>' + formattedDatecreated + '</td>' + // Menggunakan tanggal yang sudah di-format
                                '<td>' + formattedDateupdated + '</td>' + // Menggunakan tanggal yang sudah di-format
                                '<td>' + (laporan.category && laporan.category.name ? laporan.category.name : '') + '</td>' +
                                '<td>' + getStatusBadge(laporan.status_selesai) + '</td>' +
                                '<td>' + getKecepatanBadge(laporan.kecepatan) + '</td>' +
                                '<td style="text-align: center;" colspan="2"><button type="button" class="btn bg-gradient-info"><a href="/detailpengaduanadmin/' + laporan.id + '" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a></button></td>' +
                                '</tr>';
                        });
                    } else {
                        tableBody += '<tr><td colspan="7" style="text-align: center;">No Data</td></tr>';
                    }

                    // Perbarui isi tabel
                    $('#laporanTable tbody').html(tableBody);

                    // Perbarui tautan halaman
                    var pagination = laporans.links;
                    $('.pagination').html(pagination);
                }
            });
        });

        // Fungsi untuk mendapatkan label status berdasarkan kode status
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
        // Fungsi untuk mendapatkan label kecepatan berdasarkan kode kecepatan
        function getKecepatanBadge(kecepatan) {
            if (kecepatan === 'Cepat') {
                return '<div class="d-flex justify-content-center"><span class="badge badge-success">Cepat</span></div>';
            } else if (kecepatan === 'Tepat Waktu') {
                return '<div class="d-flex justify-content-center"><span class="badge badge-info">Tepat Waktu</span></div>';
            } else if (kecepatan === 'Lambat') {
                return '<div class="d-flex justify-content-center"><span class="badge badge-danger">Lambat</span></div>';
            } else if (kecepatan === null) {
                return '<div class="d-flex justify-content-center"><span class="badge badge-danger">Tidak ada</span></div>';
            } else {
                // Handle nilai kecepatan lainnya jika diperlukan
                return ''; // Atau sesuaikan dengan kebutuhan Anda
            }
        }
    });
</script>

@endsection