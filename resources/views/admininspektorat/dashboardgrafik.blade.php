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
                        <select id="tahunSelect" class="form-control">
                            <option selected="selected">Filter Tahun</option>
                            <option value="2022">2022</option>
                            <!-- Tambahkan opsi tahun lainnya sesuai kebutuhan -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select id="tahunSelectOpd" class="form-control">
                            <option selected="selected">Filter Tahun</option>
                            <option value="2022">2022</option>
                            <!-- Tambahkan opsi tahun lainnya sesuai kebutuhan -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="barChartKate" style="height: 300px;"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="opdPengaduan" width="400px" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- jQuery -->
<script src="{{asset('/')}}plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/')}}plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
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
<!-- DataTables  & Plugins -->
<script src="{{asset('/')}}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('/')}}plugins/jszip/jszip.min.js"></script>
<script src="{{asset('/')}}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('/')}}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('/')}}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/')}}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
    $(function () {
      $('.select2').select2()
    });
        $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
</script>


<script>
    var opdCounts = @json($opdCounts); // Mengonversi data PHP ke JSON
    var ctx = document.getElementById('opdPengaduan').getContext('2d');

    var labels = Object.keys(opdCounts);
    var data = {
        labels: labels,
        datasets: [{
            label: 'Selesai',
            backgroundColor: 'rgba(54, 162, 235, 0.7)', // Warna latar belakang batang grafik dengan transparansi
            borderColor: 'rgba(54, 162, 235, 1)', // Warna garis batang grafik
            borderWidth: 1,
            data: labels.map(opd => opdCounts[opd]['Selesai'])
        }, {
            label: 'Tindak Lanjut',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            data: labels.map(opd => opdCounts[opd]['Tindak Lanjut'])
        }, {
            label: 'Belum Ditindak (Terdisposisi, Valid, Invalid)',
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1,
            data: labels.map(opd => opdCounts[opd]['Belum Ditindak'])
        }]
    };

    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };

    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });


</script>

<script>
        // JavaScript section
        var barChartCanvas = document.getElementById('barChartKate').getContext('2d');
        var myBarChart;

        var barData = {
            labels: [],
            datasets: [{
                label: 'Total Pengaduan',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        var barOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: '#333'
                    },
                    gridLines: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: '#333'
                    },
                    gridLines: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }]
            },
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        };

        // Mengambil data awal untuk tahun sekarang saat halaman dimuat
        fetchDataAndUpdateChart();

        // Event listener untuk perubahan pada elemen form select
        document.getElementById('tahunSelect').addEventListener('change', function () {
            fetchDataAndUpdateChart();
        });

        function fetchDataAndUpdateChart() {
            var selectedYear = document.getElementById('tahunSelect').value;

            // Jika nilai yang dipilih adalah "Filter Tahun", ganti nilainya dengan tahun sekarang
            if (selectedYear === "Filter Tahun") {
                selectedYear = new Date().getFullYear().toString();
            }

            // Kirim permintaan AJAX ke server dengan tahun yang dipilih
            $.ajax({
                url: '/admininspektorat/chart-data',
                type: 'GET',
                data: { year: selectedYear },
                success: function (response) {
                    // Hancurkan instansi grafik sebelum membuat yang baru
                    if (myBarChart) {
                        myBarChart.destroy();
                    }

                    // Perbarui data grafik dengan data baru dari server
                    barData.labels = response.categoryNames;
                    barData.datasets[0].data = response.categoryCounts;

                    // Buat grafik baru dengan data yang diperbarui
                    myBarChart = new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barData,
                        options: barOptions
                    });
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
</script>
<script>
    var opdCounts = @json($opdCounts); // Mengonversi data PHP ke JSON
        var ctx = document.getElementById('opdPengaduan').getContext('2d');

        var labels = Object.keys(opdCounts);
        var data = {
            labels: labels,
            datasets: [{
                label: 'Selesai',
                backgroundColor: 'rgba(54, 162, 235, 0.7)', // Warna latar belakang batang grafik dengan transparansi
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna garis batang grafik
                borderWidth: 1,
                data: labels.map(opd => opdCounts[opd]['Selesai'])
            }, {
                label: 'Tindak Lanjut',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: labels.map(opd => opdCounts[opd]['Tindak Lanjut'])
            }, {
                label: 'Belum Ditindak (Terdisposisi, Valid, Invalid)',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1,
                data: labels.map(opd => opdCounts[opd]['Belum Ditindak'])
            }]
        };

        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
</script>
</html>

