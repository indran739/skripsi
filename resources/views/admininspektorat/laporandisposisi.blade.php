@extends('layouts.main_opd')   
@section('container')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Laporan Terdisposisi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Terdisposisi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    <!-- /.content-header -->
        <!-- /.content-header -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan pengaduan yang dikirim ke OPD terkait</h3>
        </div><!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                  <th>NIK Pelapor</th>
                  <th>Nama Pelapor</th>
                    <th>Laporan</th>
                    <th>OPD Tujuan</th>
                    <th>Kategori</th>
                    <th>Tanggal Lapor</th>
                    <th>Tanggapi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($pengaduans as $pengaduan)
                  <tr>
                    <td>{{ $pengaduan->user->nik }}</td>
                    <td>{{ $pengaduan->user->name }}</td>
                    <td>
                        <button type="button"  class="btn bg-gradient-primary" data-toggle="" data-target="">
                          <a href="/detailpengaduanadmin/{{ $pengaduan->id }}" style="text-decoration: none; color:white;">Detail</a>
                        </button>
                    </td>
                    <td>{{ $pengaduan->opd->name }}</td>
                    <td>{{ $pengaduan->category->name }}</td>
                    <td> {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d F Y') }} </td>
                    <td>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default__{{ $pengaduan->id }}">
                        Tanggapi
                      </button>
                                <!-- Modal Button Detail Pengaduan -->
                                      <div class="modal fade" id="modal-default__{{ $pengaduan->id }}">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Tanggapi Pengaduan dengan ID : {{ $pengaduan->id }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <form method="post" action="/storetanggapan">
                                                    @csrf
                                                    <div class="row">
                                                      <div class="col-sm">
                                                        <!-- textarea -->
                                                        <div class="form-group">
                                                          <label>Tanggapan</label>
                                                          <input type="hidden" name="id_pengaduan_fk" value="{{ $pengaduan->id }}">
                                                          <textarea class="form-control" rows="3" name="tanggapan" placeholder="Beri tanggapan pengaduan..."></textarea>
                                                      </div>
                                                    </div>
                                              </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Tanggapi</button>
                                                </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>
                                          <!-- /.modal-dialog -->
                                        </div>
                                  <!-- Modal Button Detail Pengaduan -->
                    </td>
                  </tr>
                  @endforeach
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
    </div>
        <!-- /.card -->
</div><!-- /.container-fluid -->
@endsection
