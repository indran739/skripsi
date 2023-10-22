<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/select2/css/select2.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- CSS & JS Bootstrap 5.1 -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('/')}}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('/')}}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/')}}dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('/')}}plugins/summernote/summernote-bs4.min.css">
</head>
<body>
<div class="container mt-5">
        <div class="card">
            <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="searchTerm" class="form-control" placeholder="Cari berdasarkan isi laporan...">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div id="defaultTable">
                                    <table class="table table-hover text-nowrap" >
                                        <thead>
                                            <tr>
                                            <th>Isi Laporan</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Kategori</th>
                                            <th>OPD Tujuan</th>
                                            <th class="">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyTable">
                                    @if(count($laporans) > 0)
                                        @foreach($laporans as $laporan)
                                            <tr>
                                            <td>{{ Str::limit($laporan->isi_laporan, 50) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tgl_dinyatakan_selesai)->format('d F Y') }}</td>
                                            <td>{{ $laporan->category->name }}</td>
                                            <td>{{ $laporan->opd->name }}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- jQuery -->
<script src="{{asset('/')}}plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- jQuery -->
<script src="{{asset('/')}}plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/')}}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('/')}}plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('/')}}plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{asset('/')}}plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{asset('/')}}plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{asset('/')}}plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('/')}}plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{asset('/')}}plugins/moment/moment.min.js"></script>
<script src="{{asset('/')}}plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('/')}}plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{asset('/')}}plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/')}}plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Select2 -->
<script src="{{asset('/')}}plugins/select2/js/select2.full.min.js"></script>
<!-- Filterizr-->
<script src="{{asset('/')}}plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- Ekko Lightbox -->
<script src="{{asset('/')}}plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('/')}}dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/')}}dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/')}}dist/js/pages/dashboard.js"></script>

<script>
$(document).ready(function () {
    $('#searchTerm').on('input', function () {
        var searchTerm = $(this).val();
        $.ajax({
            url: '/search', // Ganti dengan URL yang sesuai dengan endpoint pencarian
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

                        var row = '<tr>';
                        row += '<td>' + result.isi_laporan + '</td>';
                        row += '<td>' + formattedDate + '</td>'; // Menggunakan tanggal yang sudah diformat
                        row += '<td>' + result.category.name + '</td>';
                        row += '<td>' + result.opd.name + '</td>';
                        row += '<td>' + getStatusBadge(result.status_selesai) + '</td>';
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

</html>

