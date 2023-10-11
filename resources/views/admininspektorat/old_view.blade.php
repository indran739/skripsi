@extends('layouts.main_opd')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan Sudah dilakukan disposisi ke OPD terkait</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif  

    @if(Session::has('berhasil'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan di disposisikan ke Pengadu</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif  

        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Laporan Masuk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Masuk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    <!-- /.content-header -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan pengaduan yang dikirim ke OPD terkait</h3>
        </div><!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>NIK</th>
                    <th>Nama Pelapor</th>
                    <th>Isi Laporan</th>
                    <th>Kategori</th>
                    <th>Tanggal Lapor</th>
                    <th>OPD Tujuan</th>
                    <th class="d-flex justify-content-center">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($pengaduans as $pengaduan)
                  <tr>
                    <td>{{ $pengaduan->user->nik }}</td>
                    <td>{{ $pengaduan->user->name }}</td>
                    <td>{{ $pengaduan->isi_laporan }}</td>
                    <td>{{ $pengaduan->category->name }}</td>
                    <td> {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d F Y') }} </td>
                    <td>{{ $pengaduan->opd->name }}</td>
                    <td class="d-flex justify-content-center" colspan="2">
                        <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                        <i class="fas fa-eye"></i> <a href="/detailpengaduanadmin/{{ $pengaduan->id }}" style="text-decoration: none; color:white;">Detail</a>
                        </button>
                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modal-default__{{ $pengaduan->id }}">
                        <i class="fas fa-paper-plane"></i> Disposisi
                        </button>
                                <!-- Modal Button Detail Pengaduan -->
                                      <div class="modal fade" id="modal-default__{{ $pengaduan->id }}">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Disposisi</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <h5 class="text-center">Apakah anda ingin melakukan disposisi pengaduan dengan ID : {{ $pengaduan->id }} ini ?</h5>
                                              </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form method="post" action="/disposisi/{{$pengaduan->id}}">
                                                    @csrf
                                                    @method('put')
                                                          <input type="hidden" name="disposisi_opd" value="Y">
                                                          <button type="submit" class="btn btn-success mr-3">Ya</button>
                                                    </form>
                                                    <form method="post" action="/disposisi/{{$pengaduan->id}}">
                                                    @csrf
                                                    @method('put')
                                                          <input type="hidden" name="disposisi_opd" value="N">
                                                          <button type="submit" class="btn btn-danger">Tidak</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>
                                          <!-- /.modal-dialog -->
                                        </div>
                                  <!-- Modal Button Detail Pengaduan -->
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot> 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.card -->
</div><!-- /.container-fluid -->

      <!-- /.modal
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
          $(document).ready(function() {
            $('#modal-sm').on('show.bs.modal', function(e) {
              var button = $(e.relatedTarget);
              var href = button.data('href');
              $('#disposisi-form').attr('action', href);
            });

            $('#modal-sm').on('shown.bs.modal', function(e) {
              var href = $(e.relatedTarget).data('href');
              $('#disposisi-form2').attr('action', href);
            });
          });
      </script> -->

      @extends('layouts.main_opd')   
@section('container')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
      @if(Session::has('tanggapi'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan telah ditambahkan</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif  
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Selesai </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Selesai</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

<div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan pengaduan yang dinyatakan selesai</h3>
        </div><!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>NIK Pelapor</th>
                    <th>Nama Pelapor</th>
                    <th>Isi Laporan</th>
                    <th>Kategori</th>
                    <th>OPD Tujuan</th>
                    <th>Tanggal dinyatakan Selesai</th>
                    <th>Kecepatan Kinerja</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($pengaduans as $pengaduan)
                  <tr>
                    <td>{{ $pengaduan->user->nik }}</td>
                    <td>{{ $pengaduan->user->name }}</td>
                    <td>{{ Str::limit($pengaduan->isi_laporan, 20) }}</td>
                    <td>{{ $pengaduan->category->name }}</td>
                    <td>{{ $pengaduan->opd->name }}</td>

                    @if($pengaduan->updated_at)
                    <td> {{ \Carbon\Carbon::parse($pengaduan->updated_at)->format('d F Y') }} </td>
                    @else
                    <td>Belum ada</td>
                    @endif

                    @if($pengaduan->kecepatan == "Cepat")
                    <td><div class="d-flex justify-content-center"><span class="badge badge-success">Cepat</span></div></td>
                    @elseif($pengaduan->kecepatan == "Tepat Waktu")
                    <td><div class="d-flex justify-content-center"><span class="badge badge-info">Tepat Waktu</span></div></td>
                    @elseif($pengaduan->kecepatan == "Lambat")
                    <td><div class="d-flex justify-content-center"><span class="badge badge-danger">Lambat</span></div></td>
                    @endif

                    <td>
                      <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                          <a href="/detailpengaduanadmin/{{ $pengaduan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i> Detail</a>
                        </button>
                    </td>
                  </tr>
                  @endforeach
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
    </div>



@endsection
@extends('layouts.main_opd')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Akun sudah diverifikasi</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (Session::has('berhasil'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Akun sudah ditolak</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Pengadu / Pelapor</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
                        <li class="breadcrumb-item active">User Pengadu</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- /.content-header -->

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data User Pengadu</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Pelapor</th>
                                <th>Email</th>
                                <th>No. Handphone</th>
                                <th>Jenis Kelamin</th>
                                <th>Status Verifikasi</th>
                                <th class="d-flex justify-content-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $u)
                                <tr>
                                    <td>{{ $u->nik }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->no_hp }}</td>
                                    <td>{{ $u->jenis_kelamin }}</td>
                                    @if ($u->verification == 'Y')
                                    <td><div class="d-flex justify-content-center"><span class="badge badge-success">Terverifikasi</span></div></td>
                                    @elseif($u->verification == 'P')
                                    <td><div class="d-flex justify-content-center"><span class="badge badge-warning">Belum Terverifikasi</span></div></td>
                                    @elseif($u->verification == 'N')
                                    <td><div class="d-flex justify-content-center"><span class="badge badge-danger">Tidak Terverifikasi</span></div></td>
                                    @endif
                                    <td class="d-flex justify-content-center" colspan="2">
                                        <button type="button" class="btn bg-gradient-info mr-3" data-toggle="modal"
                                            data-target="#modal-lg__{{ $u->id }}"><i class="fas fa-eye"></i>
                                            Detail
                                        </button>
                                        <div class="modal fade" id="modal-lg__{{ $u->id }}">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detail User</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <section class="content">
                                                            <div class="container-fluid">
                                                                <div class="card card-primary card-outline">
                                                                    <div class="card-body box-profile">
                                                                        <div class="text-center">
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <h4 class="mb-3 text-bold"> Foto Wajah
                                                                                    </h4>
                                                                                    @if ($u->foto_wajah)
                                                                                        <img class="profile-user-img"
                                                                                            style="height:300px; width:200px;"
                                                                                            src="{{ asset('storage/' . $u->foto_wajah) }}"
                                                                                            alt="User profile picture">
                                                                                    @else
                                                                                        <h5> No Pict </h5>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col">
                                                                                    <h4 class="mb-3 text-bold"> Foto KTP
                                                                                    </h4>
                                                                                    @if ($u->foto_ktp)
                                                                                        <img class="profile-user-img"
                                                                                            style="height:300px; width:500px;"
                                                                                            src="{{ asset('storage/' . $u->foto_ktp) }}"
                                                                                            alt="User profile picture">
                                                                                    @else
                                                                                        <h5> No Pict </h5>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        </section>
                                                        <section>

                                                        </section>
                                                        <div class="container">
                                                            <div class="row mt-4">
                                                                <div class="col-md-4">
                                                                    <div class="card card-primary card-outline">
                                                                        <div class="card-body box-profile">
                                                                            <h3 class="profile-username text-center">
                                                                                {{ $u->name }}</h3>
                                                                            <p class="text-muted text-center">Pelapor /
                                                                                Pengadu</p>
                                                                            <ul
                                                                                class="list-group list-group-unbordered mb-5">
                                                                                <li class="list-group-item mb-3">
                                                                                    <b>NIK</b> <a
                                                                                        class="float-right">{{ $u->nik }}</a>
                                                                                </li>
                                                                                <li class="list-group-item mb-3">
                                                                                    <b>Tempat Lahir</b> <a
                                                                                        class="float-right">{{ $u->tempat_lahir }}</a>
                                                                                </li>
                                                                                <li class="list-group-item mb-3">
                                                                                    <b>Tanggal Lahir</b> <a
                                                                                        class="float-right">{{ $u->tanggal_lahir }}</a>
                                                                                </li>
                                                                                <li class="list-group-item mb-3">
                                                                                    <b>Jenis Kelamin</b> <a
                                                                                        class="float-right">{{ $u->jenis_kelamin }}</a>
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <b>Agama</b> <a
                                                                                        class="float-right">{{ $u->agama }}</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="card card-primary">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">About User</h3>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <strong><i class="fas fa-book mr-1"></i>
                                                                                Pekerjaan</strong>
                                                                            <p class="text-muted">
                                                                                {{ $u->pekerjaan }}
                                                                            </p>
                                                                            <hr>
                                                                            <strong><i
                                                                                    class="fas fa-map-marker-alt mr-1"></i>
                                                                                Alamat</strong>
                                                                            <p class="text-muted">{{ $u->alamat }}</p>
                                                                            <hr>
                                                                            <strong><i
                                                                                    class="fas fa-phone-alt mr-1"></i>Kontak</strong>
                                                                            <p class="text-muted">
                                                                                <span
                                                                                    class="tag tag-danger">{{ $u->no_hp }}
                                                                                    /
                                                                                </span>
                                                                                <span
                                                                                    class="tag tag-success">{{ $u->email }}</span>
                                                                            </p>
                                                                            <hr>
                                                                            <strong><i class="far fa-file-alt mr-1"></i>
                                                                                Golongan
                                                                                Darah</strong>
                                                                            <p class="text-muted">{{ $u->gol_darah }}</p>
                                                                            <hr>
                                                                            <strong><i class="far fa-file-alt mr-1"></i>
                                                                                Status
                                                                                Pernikahan</strong>
                                                                            <p class="text-muted">
                                                                                {{ $u->status_pernikahan }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <button type="button" class=" btn btn-success" data-toggle="modal"
                                            data-target="#modal-default__{{ $u->id }}">
                                            Verifikasi
                                        </button>
                                        <!-- Modal Button Detail Pengaduan -->
                                        <div class="modal fade" id="modal-default__{{ $u->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Verifikasi</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="/verifikasiakun/{{ $u->id }}">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-body">
                                                            <h5 class="text-center">Apakah anda ingin melakukan verifikasi
                                                                akun
                                                                user dengan NIK : {{ $u->nik }} ini ?</h5>
                                                            <div class="form-group">
                                                                <label>Verifikasi Akun </label>
                                                                <select class="form-control"
                                                                    id="verification__{{ $u->id }}"
                                                                    name="verification">
                                                                    @if ($u->verification == 'Y')
                                                                        <option value="Y" selected>Ya</option>
                                                                        <option value="N">Tidak</option>
                                                                        <option value="P">Pending</option>
                                                                    @elseif($u->verification == 'P')
                                                                        <option value="Y">Ya</option>
                                                                        <option value="N">Tidak</option>
                                                                        <option value="P" selected>Pending</option>
                                                                    @else
                                                                        <option value="Y">Ya</option>
                                                                        <option value="N" selected>Tidak</option>
                                                                        <option value="P">Pending</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Tanggapan</label>
                                                                <textarea class="form-control" rows="3" name="tanggapan_admin"
                                                                    id="inputField1__{{ $u->id }}"placeholder="Beri tanggapan pengaduan..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <script>
                                                                document.querySelectorAll('[id^="verification"]').forEach(function(element) {
                                                                    element.addEventListener('change', function() {
                                                                        var selectedOption = this.value;
                                                                        var userId = this.id.split('__')[1];
                                                                        var inputField = document.getElementById('inputField1__' + userId);

                                                                        if (selectedOption === 'N') {
                                                                            inputField.disabled = false;
                                                                        } else {
                                                                            inputField.disabled = true;
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                </div>
                </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                    </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
@endsection

@extends('layouts.main_opd')
@section('container')
    <div class="content-header">
        <div class="container-fluid">
    @if(Session::has('tanggapi'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan telah ditambahkan</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif  
            <div class="row mb-2">
                <div class="col-sm-6 mb-3">
                    <h1 class="m-0">Detail Pengaduan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admininspektorat">Beranda</a></li>
                        <li class="breadcrumb-item active">Detail Pengaduan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Detail Pengaduan</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">ID</label>
                                <input type="text" class="form-control" value="{{ $data->id }}" name="id"
                                    id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal Lapor</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}" name=""
                                    id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">OPD Tujuan</label>
                                <input type="text" class="form-control" value="{{ $data->opd->name }}" name="id_opd_fk"
                                    id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kategori Pengaduan</label>
                                <input type="text" class="form-control" value="{{ $data->category->name }}"
                                    name="id_category_fk" id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal Kejadian</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->tanggal_kejadian)->format('d F Y') }}"
                                    name="" id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Judul Laporan</label>
                                <input type="text" class="form-control" value="{{ $data->judul }}" name="judul_laporan"
                                    id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Isi Laporan</label>
                                <textarea class="form-control" value="" rows="3" style="resize:none; width:760px; height:270px;"
                                    name="isi_laporan" disabled> {{ $data->isi_laporan }} </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Lokasi</label>
                                <input type="tex" class="form-control" value="{{ $data->lokasi_kejadian }}"
                                    name="lokasi_kejadian" id="exampleInputPassword1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal Tindak</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->tanggal_tindak)->format('d F Y') }}"
                                    name="" id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estimasi Tanggal Selesai</label>
                                <input type="text" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('d F Y') }}"
                                    name="" id="exampleInputEmail1" disabled>
                            </div>
                            <div class="form-group">
                                <label>Disposisi Ke OPD Terkait</label>
                                <select class="form-control" name="disposisi_opd" disabled>
                                    @if ($data->disposisi_opd == 'Y')
                                        <option value="Y" selected>Ya</option>
                                        <option value="N">Tidak</option>
                                        <option value="P">Pending</option>
                                    @elseif($data->disposisi_opd == 'P')
                                        <option value="Y">Ya</option>
                                        <option value="N">Tidak</option>
                                        <option value="P" selected>Pending</option>
                                    @else
                                        <option value="Y">Ya</option>
                                        <option value="N" selected>Tidak</option>
                                        <option value="P">Pending</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Validasi Laporan</label>
                                <select class="form-control" name="validasi_laporan" disabled>
                                    @if ($data->validasi_laporan == 'Y')
                                        <option value="Y" selected>Ya</option>
                                        <option value="N">Tidak</option>
                                        <option value="P">Pending</option>
                                    @elseif($data->validasi_laporan == 'P')
                                        <option value="Y">Ya</option>
                                        <option value="N">Tidak</option>
                                        <option value="P" selected>Pending</option>
                                    @else
                                        <option value="Y">Ya</option>
                                        <option value="N" selected>Tidak</option>
                                        <option value="P">Pending</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a type="btn" href="/laporanmasuk" class="btn btn-primary">Kembali</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Dokumentasi</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="" data-toggle="modal"
                                        data-target="#modal-gambar1__{{ $data->id }}">
                                        <img src="{{ asset('storage/' . $data->first_image) }}" class="img-fluid mb-2"
                                            alt="red sample" />
                                    </a>
                                    <!-- Modal Button Detail Gambar 1 -->
                                    <div class="modal fade" id="modal-gambar1__{{ $data->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Gambar dari pengaduan dengan ID :
                                                        {{ $data->id }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('storage/' . $data->first_image) }}"
                                                        class="img-fluid mb-2" alt="red sample" />
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <a data-toggle="modal" data-target="#modal-gambar2__{{ $data->id }}">
                                        <img src="{{ asset('storage/' . $data->sec_image) }}" class="img-fluid mb-2"
                                            alt="red sample" />
                                    </a>
                                    <!-- Modal Button Detail Gambar 1 -->
                                    <div class="modal fade" id="modal-gambar2__{{ $data->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Gambar dari pengaduan dengan ID :
                                                        {{ $data->id }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('storage/' . $data->sec_image) }}"
                                                        class="img-fluid mb-2" alt="red sample" />
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        @php
                                            $fileNameParts = explode('/', $data->lampiran);
                                            $fileName = end($fileNameParts);
                                        @endphp
                                        <a class="btn btn-app bg-gradient-default col-lg mt-2"
                                            href="{{ asset('storage/' . $data->lampiran) }}">
                                            <i class="fas fa-download"></i> Download Lampiran Bukti - {{ $fileName }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Data Pelapor</h3>
                        </div>
                        <div class="card-body">
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Biodata yang mengirim pengaduan</h3>
                                        </div>
                                        <!-- ./card-header -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="card card-primary card-outline">
                                                        <div class="card-body box-profile">
                                                            <div class="text-center">
                                                                <img class="profile-user-img img-fluid img-circle"
                                                                    src="../../dist/img/user4-128x128.jpg"
                                                                    alt="User profile picture">
                                                            </div>
                                                            <h3 class="profile-username text-center">
                                                                {{ $data->user->name }}</h3>
                                                            <p class="text-muted text-center">Pelapor / Pengadu</p>
                                                            <ul class="list-group list-group-unbordered mb-3">
                                                                <li class="list-group-item">
                                                                    <b>NIK</b> <a
                                                                        class="float-right">{{ $data->user->nik }}</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>Tempat Lahir</b> <a
                                                                        class="float-right">{{ $data->user->tempat_lahir }}</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>Tanggal Lahir</b> <a
                                                                        class="float-right">{{ $data->user->tanggal_lahir }}</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>Jenis Kelamin</b> <a
                                                                        class="float-right">{{ $data->user->jenis_kelamin }}</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b>Agama</b> <a
                                                                        class="float-right">{{ $data->user->agama }}</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- end section -->
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">About User</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <strong><i class="fas fa-book mr-1"></i> Pekerjaan</strong>
                                                            <p class="text-muted">
                                                                {{ $data->user->pekerjaan }}
                                                            </p>
                                                            <hr>
                                                            <strong><i class="fas fa-map-marker-alt mr-1"></i>
                                                                Alamat</strong>
                                                            <p class="text-muted">{{ $data->user->alamat }}</p>
                                                            <hr>
                                                            <strong><i class="fas fa-phone-alt mr-1"></i>Kontak</strong>
                                                            <p class="text-muted">
                                                                <span class="tag tag-danger">{{ $data->user->no_hp }} /
                                                                </span>
                                                                <span
                                                                    class="tag tag-success">{{ $data->user->email }}</span>
                                                            </p>
                                                            <hr>
                                                            <strong><i class="far fa-file-alt mr-1"></i> Golongan
                                                                Darah</strong>
                                                            <p class="text-muted">{{ $data->user->gol_darah }}</p>
                                                            <hr>
                                                            <strong><i class="far fa-file-alt mr-1"></i> Status
                                                                Pernikahan</strong>
                                                            <p class="text-muted">{{ $data->user->status_pernikahan }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end rows 1 -->
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tanggapan Card -->
                    <div class="card card-dark">
                <div class="card-header">
                  <h3 class="card-title">Tanggapan</h3>
                </div>
                <div class="card-body">
                 <!-- /.row -->
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <div class="row">
                            <div class="col 3">
                              <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#modal-tanggapi__{{ $data->id }}">
                                + Tambah Tanggapan
                              </button>
                               <!-- Modal Button Detail Pengaduan -->
                               <div class="modal fade" id="modal-tanggapi__{{ $data->id }}">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Tanggapi Pengaduan dengan ID : {{ $data->id }}</h4>
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
                                                          <input type="hidden" name="id_pengaduan_fk" value="{{ $data->id }}">
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
                            </div>
                        </div>
                        </div>
                        <!-- ./card-header -->
                        <div class="card-body">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>User</th>
                                <th>Tanggal</th>
                                <th class="d-flex justify-content-center" >Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($tanggapans as $tanggapan)
                              <tr data-widget="expandable-table" aria-expanded="false">
                                <td>{{ $tanggapan->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($tanggapan->created_at)->format('d F Y, H:i')}}</td>
                                @if($tanggapan->id_user_fk === auth()->user()->id )
                                <td class="d-flex justify-content-center" colspan="2">
                                    <button type="button"  class="btn bg-gradient-success mr-3" data-toggle="" data-target="">
                                      <a href="" style="text-decoration: none; color:white;">Edit</a>
                                    </button>
                                    <button type="button"  class=" btn btn-info" data-toggle="modal" data-target="#modal-default">
                                      Hapus
                                    </button>
                                </td> 
                                @else
                                    <td class="d-flex justify-content-center">Bukan Tanggapan Anda</td>
                                @endif
                              </tr>
                              <tr class="expandable-body">
                                <td colspan="5">
                                  <p>
                                    {{ $tanggapan->tanggapan }}
                                  </p>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                            <!-- /.card -->
                        @endsection
                        @extends('layouts.main_opd_sec')   
@section('container')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
      @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan Sudah Tervalidasi</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('berhasil'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan tidak divalidasi atau ditolak</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
       
      @if(Session::has('tindak'))
      <div class="alert alert-success alert-dismissible mt-3 fade show" role="alert">
          <strong>Pengaduan ditindak lanjuti</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('tidaktindak'))
      <div class="alert alert-danger alert-dismissible mt-3 fade show" role="alert">
          <strong>Pengaduan tidak ditindak lanjuti</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('selesai'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan Sudah dinyatakan selesai</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('tidakselesai'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>Laporan Pengaduan dinyatakan belum selesai</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('tanggapi'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan telah ditambahkan</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif  
       

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Terdisposisi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminopd">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Terdisposisi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
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
                    <th>Isi Laporan</th>
                    <th>Kategori</th>
                    <th>Tanggal Lapor</th>
                    <th>Status Valid</th>
                    <th>Status Tindak Lanjut</th>
                    <th class="d-flex justify-content-center">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($pengaduans as $pengaduan)
                  <tr>
                    <td>{{ $pengaduan->user->nik }}</td>
                    <td>{{ $pengaduan->user->name }}</td>
                    <td>{{ $pengaduan->isi_laporan }}</td>
                    <td>{{ $pengaduan->category->name }}</td>
                    <td> {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d F Y') }} </td>

                    @if($pengaduan->validasi_laporan == 'Y')
                        <td><span class="d-flex justify-content-center badge bg-success">Sudah Tervalidasi</span></td>
                    @elseif($pengaduan->validasi_laporan == 'N')
                        <td><span class="d-flex justify-content-center badge bg-danger">Pengaduan Tidak Valid</span></td>
                    @elseif($pengaduan->validasi_laporan == 'P')
                        <td><span class="d-flex justify-content-center badge bg-warning">Belum Tervalidasi</span></td> 
                    @endif

                        @if($pengaduan->proses_tindak == 'Y')
                        <td><span class="d-flex justify-content-center badge bg-success">Sedang ditindak</span></td>
                    @elseif($pengaduan->proses_tindak == 'N')
                        <td><span class="d-flex justify-content-center badge bg-danger">Tidak ditindak</span></td>
                    @elseif($pengaduan->proses_tindak == 'P')
                        <td><span class="d-flex justify-content-center badge bg-warning">Belum ditindak</span></td>
                    @endif

                    <td class="d-flex justify-content-center" colspan="2">
                      <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
                            <a href="/detailpengaduanopd/{{ $pengaduan->id }}" style="text-decoration: none; color:white;">Detail</a>
                      </button>
                      @if($pengaduan->validasi_laporan == 'P')
                      <button type="button" class="btn btn-danger mr-2" data-toggle="modal" data-target="#modal-default__{{ $pengaduan->id }}">
                          Validasi
                      </button>
                                <!-- Modal Button Detail Pengaduan -->
                                      <div class="modal fade" id="modal-default__{{ $pengaduan->id }}">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Validasi</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <h5 class="text-center">Apakah pengaduan dengan ID : {{ $pengaduan->id }} ini valid?</h5>
                                              </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form method="post" action="/validasi/{{$pengaduan->id}}">
                                                    @csrf
                                                    @method('put')
                                                          <input type="hidden" name="validasi_laporan" value="Y">
                                                          <button type="submit" class="btn btn-success mr-3">Ya</button>
                                                    </form>
                                                    <form method="post" action="/validasi/{{$pengaduan->id}}">
                                                    @csrf
                                                    @method('put')
                                                          <input type="hidden" name="validasi_laporan" value="N">
                                                          <button type="submit" class="btn btn-danger">Tidak</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                          </div>
                                          <!-- /.modal-dialog -->
                                        </div>
                      @endif
                                <!-- Modal Button Detail Pengaduan -->  
                        <button type="button"  class="btn bg-gradient-warning mr-2" data-toggle="" data-target="">
                          <a href="/tindaklanjutpage/{{ $pengaduan->id }}" style="text-decoration: none; color:white;">Tindak</a>
                        </button>
                      <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#modal-selesai__{{ $pengaduan->id }}">
                            Status Selesai
                      </button>
                       <!-- Modal Button Detail Pengaduan -->
                       <div class="modal fade" id="modal-selesai__{{ $pengaduan->id }}">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h4 class="modal-title">Status Selesai</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <h5 class="text-center">Apakah anda yakin bahwa pengaduan dengan ID:{{ $pengaduan->id }} dinyatakan selesai?</h5>
                                              </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form method="post" action="/statusselesai/{{$pengaduan->id}}">
                                                    @csrf
                                                    @method('put')
                                                          <input type="hidden" name="status_selesai" value="Y">
                                                          <button type="submit" class="btn btn-success mr-3">Ya</button>
                                                    </form>
                                                    <form method="post" action="/statusselesai/{{$pengaduan->id}}">
                                                    @csrf
                                                    @method('put')
                                                          <input type="hidden" name="status_selesai" value="N">
                                                          <button type="submit" class="btn btn-danger">Tidak</button>
                                                    </form>
                                                </div>
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
@endsection
@extends('layouts.main_opd_sec')   
@section('container')
 <!-- Content Header (Page header) -->
 <div class="content-header">
      <div class="container-fluid">
      @if(Session::has('tanggapi'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Tanggapan telah ditambahkan</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif  
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Laporan Selesai </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminopd">Beranda</a></li>
              <li class="breadcrumb-item active">Laporan Selesai</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->

<div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan pengaduan yang dinyatakan selesai</h3>
        </div><!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>NIK Pelapor</th>
                    <th>Nama Pelapor</th>
                    <th>Isi Laporan</th>
                    <th>Kategori</th>
                    <th>Tanggal dinyatakan Selesai</th>
                    <th>Kecepatan Kinerja</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($laporans as $pengaduan)
                  <tr>
                    <td>{{ $pengaduan->user->nik }}</td>
                    <td>{{ $pengaduan->user->name }}</td>
                    <td>{{ $pengaduan->isi_laporan }}</td>
                    <td>{{ $pengaduan->category->name }}</td>
                    @if($pengaduan->updated_at)
                    <td> {{ \Carbon\Carbon::parse($pengaduan->updated_at)->format('d F Y') }} </td>
                    @else
                    <td>Belum ada</td>
                    @endif
                    
                    @if($pengaduan->kecepatan == "Cepat")
                    <td><div class="d-flex justify-content-center"><span class="badge badge-success">Cepat</span></div></td>
                    @elseif($pengaduan->kecepatan == "Tepat Waktu")
                    <td><div class="d-flex justify-content-center"><span class="badge badge-info">Tepat Waktu</span></div></td>
                    @elseif($pengaduan->kecepatan == "Lambat")
                    <td><div class="d-flex justify-content-center"><span class="badge badge-danger">Lambat</span></div></td>
                    @endif
                    
                    <td>
                        <button type="button"  class="btn bg-gradient-info" data-toggle="" data-target="">
                          <a href="/detailpengaduanopd/{{ $pengaduan->id }}" style="text-decoration: none; color:white;"><i class="fas fa-eye"></i> Detail</a>
                        </button>
                    </td>
                  </tr>
                  @endforeach
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
    </div>



@endsection
@endsection