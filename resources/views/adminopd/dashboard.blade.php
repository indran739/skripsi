@extends('layouts.main_opd_sec_dashboard')   
@section('container')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Selamat Datang Admin {{ $opd->name }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Home</a></li>
              <li class="breadcrumb-item active">Beranda</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-2 col-6">
              <div class="small-box bg-olive">
                <div class="inner">
                  <h3>{{ $averageResolutionTime }} Hours<sup></sup></h3>

                  <p>Rata-rata waktu penyelesaian</p>
                </div>
                <div class="icon">
                  <i class="far fa-clock"></i>
                </div>
              </div>
            </div>
          <div class="col-lg-2 col-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{ $count_laporandisposisi }}<sup></sup></h3>

                  <p>Jumlah Laporan Tedisposisi</p>
                </div>
                <div class="icon">
                <i class="fas fa-paper-plane mr-2"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $count_laporanvalid }}<sup></sup></h3>

                  <p>Jumlah Laporan Valid</p>
                </div>
                <div class="icon">
                  <i class="fas fa-check-circle mr-2"></i>
                </div>
              </div>
            </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $count_laporaninvalid }}</h3>

                <p>Jumlah Laporan Invalid</p>
              </div>
              <div class="icon">
                <i class="fas fa-times-circle mr-2"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-dark">
              <div class="inner">
                <h3>{{ $count_laporanditindak }}</h3>

                <p>Jumlah Sedang Ditindak</p>
              </div>
              <div class="icon">
                <i class="fas fa-cog mr-2"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $count_laporanselesai }}</h3>

                <p>Jumlah Laporan Selesai</p>
              </div>
              <div class="icon">
                <i class="fas fa-clipboard-check"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <!-- PIE CHART -->
            <div class="card card">
                <div class="card-header" style="background-color:#4030A3;">
                  <h3 class="card-title text-white">Total Pengaduan Per Kategori</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="barChartKate" style="min-height: 348px; margin: auto;"></canvas>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-6 connectedSortable">
              <div class="card card-info">
                <div class="card-header" style="background-color:#4030A3;">
                  <h3 class="card-title text-white">Jumlah Pengaduan Selesai per Bulan</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                </div>
                    <div class="card-body">
                      <div class="chart">
                        <canvas id="pengaduanChart" style="min-height: 300px; height: 300px; max-height: 500px; max-width: 500%;"></canvas>
                      </div>
                    </div>
              </div>

          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
@endsection