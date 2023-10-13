@extends('layouts.main_opd_dashboard')   
@section('container')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Selamat Datang Admin Inspektorat </h1>
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ $count_laporanmasuk }}<sup></sup></h3>

                  <p>Jumlah Laporan Pending</p>
                </div>
                <div class="icon">
                <i class="fas fa-clock mr-2"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{ $count_laporandisposisi }}<sup></sup></h3>

                  <p>Jumlah Terdisposisi</p>
                </div>
                <div class="icon">
                  <i class="fas fa-paper-plane mr-2"></i>
                </div>
              </div>
            </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $count_laporantolak }}</h3>

                <p>Jumlah Laporan Ditolak</p>
              </div>
              <div class="icon">
                <i class="fas fa-times-circle mr-2"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-lightblue">
              <div class="inner">
                <h3>{{ $count_pengadu }}</h3>
                
                <p>Jumlah User Pengadu</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <!-- PIE CHART -->
            <div class="card">
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
                   <!-- BAR CHART -->
                    <div class="card">
                        <div class="card-header" style="background-color:#4030A3;">
                            <h3 class="card-title text-white">Total Pengaduan Selesai OPD</h3>
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
                            <div class="chart" style="width: 100%; margin: auto;">
                                <canvas id="barChart" style="min-height: 200px;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <div class="row">

          <section class="col-lg-6 connectedSortable">
            <div class="card">
                <div class="card-header" style="background-color:#4030A3;">
                  <h3 class="card-title text-white">Rata-rata waktu OPD</h3>

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
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Nama OPD</th>
                                    <th>Average Duration (hours)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($opdAverages as $index => $opdAverage)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $opdAverage['opd_name'] }}</td>
                                        <td>{{ $opdAverage['average_duration'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
              </div>
          </section>
          
    </div>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <!-- <section class="col-lg-6 connectedSortable">
                    <div class="card">
                        <div class="card-header" style="background-color:#4030A3;">
                            <h3 class="card-title text-white">Total Pengaduan Selesai OPD</h3>
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
                            <div class="chart" style="width: 100%; margin: auto;">

                            </div>
                        </div>
                    </div>
          </section>
        </div>

</div>

@endsection

