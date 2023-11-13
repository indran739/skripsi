@extends('layouts.main_opd_dashboard')   
@section('container')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Selamat Datang Admin Inspektorat </h1>
            <div class="row">
              <div class="col-3">
                <form action="{{ url('/cetak-laporan-kinerja') }}" method="post">
                    @csrf
                      <select id="tahunSelect" style="width:100%;" class="form-control mt-3" name="year">
                        <option selected="selected" style="text-align:center;" value="2023">-- Filter Tahun --</option>
                        <option value="2022" style="text-align:center;">2022</option>
                      </select>
              </div>
            </div>
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
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <!-- PIE CHART -->
            <div class="card">
                <div class="card-header" style="background-color:#4030A3;">
                  <h3 class="card-title text-white">Total Pengaduan Selesai Per Kategori </h3>
                  
                </div>
                <div class="row mb-2 mt-3 ml-3">
                <div class="card-body" style="width: 100%; margin: auto;">
                  <canvas id="pieChartKate" style="min-height: 329px; margin: auto;"></canvas>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
           
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-6 connectedSortable">
            <div class="card">
                <div class="card-header" style="background-color:#4030A3;">
                  <h3 class="card-title text-white">Total Pengaduan OPD</h3>
                </div>
                <div class="card-body">
                <div class="row mb-3">
                  </div>   
                <div class="box">
                    <div class="box-body" style="width: 100%; margin: auto;">
                        <canvas id="opdPengaduan" style="min-height: 337px; margin: auto;"></canvas>
                    </div>
                </div>
                </div>
              </div>
          </section>
          <!-- right col -->
        </div>
        <div class="row">

          <section class="col-lg-6 connectedSortable">
            <div class="card">
                <div class="card-header" style="background-color:#4030A3;">
                  <h3 class="card-title text-white">Rata-rata waktu kinerja OPD</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body  table-responsive p-0 ">
                        <button type="submit" class="btn bg-gradient-olive ml-2 mt-3 mb-3 ">Cetak Laporan Kinerja</button>
                      </form>
                <div class="box">
                    <div class="box-body">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">No.</th>
                                    <th class="text-center align-middle">Nama OPD</th>
                                    <th style="text-align: center;">Total <br>Pengaduan Selesai</th>
                                    <!-- <th style="text-align: center;">Total <br>Selisih waktu respon <br>(Jam)</th>
                                    <th style="text-align: center;">Total <br>Selisih waktu penyelesaian <br>(Jam)</th> -->
                                    <th style="text-align: center;">Waktu Respon <br> (Jam)</th>
                                    <th style="text-align: center;">Waktu Penyelesaian <br>(Jam)</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @php $count = 1 @endphp
                                @foreach($opdAverages as $index => $opdAverage)
                                <tr>
                                    <td style="text-align: center;">{{ $count++ }}</td>
                                    <td style="text-align: left;">{{ $opdAverage['opd_name'] }}</td>
                                    <td style="text-align: right;">{{ $opdAverage['count_laporan_selesai']}}</td>
                                    <!-- <td style="text-align: right;">{{ $opdAverage['respons_duration'] }}</td>
                                    <td style="text-align: right;">{{ $opdAverage['completed_duration'] }}</td> -->
                                    <td style="text-align: right;">{{ $opdAverage['rataRataWaktuRespon'] }}</td>
                                    <td style="text-align: right;">{{ $opdAverage['average_duration'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
              </div>
          </section>

          <section class="col-lg-6 connectedSortable">
              <div class="card">
                  <div class="card-header" style="background-color:#4030A3;">
                      <h3 class="card-title text-white">TOP 3 Laporan yang paling banyak disukai</h3>
                      <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove">
                              <i class="fas fa-times"></i>
                          </button>
                      </div>
                  </div>
                  <div class="card-body table-responsive p-0 ">
                      <table class="table table-hover text-nowrap">
                          <thead>
                              <tr>
                                  <th class="text-center align-middle">No.</th>
                                  <th style="text-align:center;">Isi <br>Laporan</th>
                                  <th class="text-center align-middle">Kategori</th>
                                  <th style="text-align:center;">OPD <br>Tujuan</th>
                                  <th class="text-center align-middle">Total Like</th>
                                  <th class="text-center align-middle">Aksi</th>
                              </tr>
                          </thead>
                          <tbody id="tableBody">
                              @php $count = 1 @endphp
                              @foreach($laporans as $laporan)
                                  <tr>
                                      <td style="text-align: center;">{{ $count++ }}</td>
                                      <td>{{ Str::limit($laporan->isi_laporan, 20) }}</td>
                                      <td>{{ $laporan->category->name }}</td>
                                      <td>{{ $laporan->opd->name }}</td>
                                      <td style="text-align: center;">
                                          <span class="badge bg-gray disabled color-palette"  style="font-size: 14px;"> <!-- Adjust the font size as needed -->
                                              <i class="fas fa-thumbs-up mr-2"></i>{{ $laporan->likes->count() }}
                                          </span>
                                      </td>
                                      <td style="text-align: center;" colspan="2">
                                          <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                                              <a href="/detailpengaduanadmin/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                          </button>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </section>

          
    </div>

@endsection

