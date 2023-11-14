@extends('layouts.main_opd_sec_dashboard')
@section('container')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Selamat Datang Admin {{ $opd->name }}</h1>
                    <select id="tahunSelect" style="width:20%;" class="form-control mt-3">
                        <option selected="selected" style="text-align:center;"> -- Filter Tahun -- </option>
                        <option value="2022" style="text-align:center;">2022</option>
                    </select>
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
            <section class="col-lg-6 connectedSortable">
                <div class="card card">
                    <div class="card-header" style="background-color:#4030A3;">
                        <h3 class="card-title text-white">Total Pengaduan Per Kategori</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChartKate" style="min-height: 358px; margin: auto;"></canvas>
                    </div>
                </div>
            </section>
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
        </div>
        <div class="row">
            <!-- Left col -->

            <section class="col-lg-7 connectedSortable">
                <div class="card card-info">
                    <div class="card-header" style="background-color:#4030A3;">
                        <h3 class="card-title text-white">Jumlah Pengaduan Selesai per Bulan</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="pengaduanChart" style="min-height: 150px; max-height: 700px; min-width: 500px; max-width: 2000px;"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg-5 connectedSortable">
              <div class="card">
                  <div class="card-header" style="background-color:#4030A3;">
                      <h3 class="card-title text-white">Sorotan 3 Laporan yang paling banyak disukai</h3>
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
                                      <td style="text-align: center;">
                                          <span class="badge bg-gray disabled color-palette"  style="font-size: 14px;">
                                              <i class="fas fa-thumbs-up mr-2"></i>{{ $laporan->likes->count() }}
                                          </span>
                                      </td>
                                      <td style="text-align: center;" colspan="2">
                                          <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                                              <a href="/detailpengaduanopd/{{ $laporan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                          </button>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endsection
