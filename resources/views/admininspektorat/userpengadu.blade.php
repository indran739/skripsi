@extends('layouts.main_opd')   
@section('container')
<style>
.vertical-table {
    width: 100%;
    border-collapse: collapse;
}

.vertical-table th, .vertical-table td {
    text-align: left;
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.vertical-table th {
    background-color: #f2f2f2;
}

</style>
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

            @if (Session::has('suspended'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Akun sudah ditangguhkan</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(Session::has('hapus'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Akun User berhasil dihapus</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-2">
                <div class="col-sm-6 mb-3">
                    <h1 class="m-0">User Pengadu</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
                        <li class="breadcrumb-item active">User Pengadu</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- /.content-header -->

            <div class="col-12 col-sm-12">
                <div class="card card-indigo card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" style="color: black;text-decoration: none;" id="custom-tabs-four-pending-tab" data-toggle="pill" href="#custom-tabs-four-pending" role="tab" aria-controls="custom-tabs-four-pending" aria-selected="true"><i class="fas fa-clock mr-2"></i>Menunggu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-tolak-tab" data-toggle="pill" href="#custom-tabs-four-tolak" role="tab" aria-controls="custom-tabs-four-tolak" aria-selected="false"><i class="fas fa-exclamation-circle mr-2"></i>Ditolak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-verif-tab" data-toggle="pill" href="#custom-tabs-four-verif" role="tab" aria-controls="custom-tabs-four-verif" aria-selected="false"><i class="fas fa-check-circle mr-2"></i>Terverifikasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-suspended-tab" data-toggle="pill" href="#custom-tabs-four-suspended" role="tab" aria-controls="custom-tabs-four-suspended" aria-selected="false"><i class="fas fa-power-off mr-2"></i>Suspended</a>
                    </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-pending" role="tabpanel" aria-labelledby="custom-tabs-four-pending-tab">
                        <div class="row">
                                <div class="col-12">
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 500px;">
                                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                            <div class="input-group-append float-left">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama Pelapor</th>
                                        <th>Email</th>
                                        <th>No. Handphone</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($users) > 0)
                                    @php
                                        $no = ($users->currentPage() - 1) * $users->perPage() + 1;
                                    @endphp
                                    @foreach($users as $u)
                                        <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->nik }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->no_hp }}</td>
                                        <td>{{ $u->jenis_kelamin }}</td>
                                        @if ($u->verification == 'Y')
                                        <td><div class=""><span class="badge badge-success">Terverifikasi</span></div></td>
                                        @elseif($u->verification == 'P')
                                        <td><div class=""><span class="badge badge-warning">Menunggu</span></div></td>
                                        @elseif($u->verification == 'N')
                                        <td><div class=""><span class="badge badge-danger">Tidak Terverifikasi</span></div></td>
                                        @endif
                
                                        <td style="text-align: center;" colspan="2">
                                            <button type="button" class="btn bg-gradient-info mr-2" data-toggle="modal" data-target="#modal-lg__{{ $u->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="modal fade" id="modal-lg__{{ $u->id }}">
                                                <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h4 class="" >Data Pengadu</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="vertical-table">
                                                            <tr>
                                                                <th>NIK</th>
                                                                <td>{{ $u->nik }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nama</th>
                                                                <td>{{ $u->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Alamat</th>
                                                                <td>{{ $u->alamat }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kecamatan</th>
                                                                <td>{{ $u->kecamatan->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kelurahan</th>
                                                                <td>{{ $u->kelurahan->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Desa</th>
                                                                <td>{{ $u->desa->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tempat Lahir</th>
                                                                <td>{{ $u->tempat_lahir }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tanggal Lahir</th>
                                                                <td>{{ \Carbon\Carbon::parse($u->tanggal_lahir)->format('d F Y') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Kelamin</th>
                                                                <td>{{ $u->jenis_kelamin }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Agama</th>
                                                                <td>{{ $u->agama }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>No. Handphone</th>
                                                                <td>{{ $u->no_hp }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pekerjaan</th>
                                                                <td>{{ $u->pekerjaan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Golongan Darah</th>
                                                                <td>{{ $u->gol_darah }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status Pernikahan</th>
                                                                <td>{{ $u->status_pernikahan }}</td>
                                                            </tr>
                                                            <tr>
                                                            <tr>
                                                            <th>Foto Wajah</th>
                                                            <td>
                                                                @if ($u->foto_wajah)
                                                                    <img class="profile-user-img" style="height:300px; width:200px;" src="{{ asset('storage/' . $u->foto_wajah) }}" alt="Foto Wajah">
                                                                @else
                                                                    <h5> Tidak Ada Foto </h5>
                                                                @endif
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Foto KTP</th>
                                                                <td>
                                                                    @if ($u->foto_ktp)
                                                                        <img class="profile-user-img" style="height:220px; width:370px;" src="{{ asset('storage/' . $u->foto_ktp) }}" alt="Foto KTP">
                                                                    @else
                                                                        <h5> Tidak Ada Foto </h5>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                        <button type="button" class=" btn btn-success" data-toggle="modal"
                                            data-target="#modal-default__{{ $u->id }}"><i class="fas fa-check-circle"></i>
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
                                                            <h5 class="text-center mb-3">Apakah anda ingin melakukan verifikasi?</h5>
                                                            <div class="form-group">
                                                                <label class="d-flex justify-content-start">Verifikasi Akun </label>
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
                                                                        <option value="P" selected>Menunggu</option>
                                                                    @else
                                                                        <option value="Y">Ya</option>
                                                                        <option value="N" selected>Tidak</option>
                                                                        <option value="P">Pending</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="d-flex justify-content-start" for="exampleInputEmail1">Alasan</label>
                                                                <textarea class="form-control" rows="3" name="tanggapan_admin"
                                                                    id="inputField1__{{ $u->id }}"placeholder="Beri alasan akun ditolak..."></textarea>
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
                                        {{ $users->links('vendor.pagination.adminlte_sec') }}
                                    </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-tolak" role="tabpanel" aria-labelledby="custom-tabs-four-tolak-tab">
                    <div class="row">
                                <div class="col-12">
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 500px;">
                                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                            <div class="input-group-append float-left">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama Pelapor</th>
                                        <th>Email</th>
                                        <th>No. Handphone</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($users_tolak) > 0)
                                    @php
                                        $no = ($users_tolak->currentPage() - 1) * $users_tolak->perPage() + 1;
                                    @endphp
                                    @foreach($users_tolak as $u)
                                        <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->nik }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->no_hp }}</td>
                                        <td>{{ $u->jenis_kelamin }}</td>
                                        @if ($u->verification == 'Y')
                                        <td><div class=""><span class="badge badge-success">Terverifikasi</span></div></td>
                                        @elseif($u->verification == 'P')
                                        <td><div class=""><span class="badge badge-warning">Belum Terverifikasi</span></div></td>
                                        @elseif($u->verification == 'N')
                                        <td><div class=""><span class="badge badge-danger">Ditolak</span></div></td>
                                        @endif
                
                                        <td style="text-align: center;" colspan="2">
                                            <button type="button" class="btn bg-gradient-info" data-toggle="modal" data-target="#modal-lg__{{ $u->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="modal fade" id="modal-lg__{{ $u->id }}">
                                                <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Data Pengadu</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="vertical-table">
                                                            <tr>
                                                                <th>NIK</th>
                                                                <td>{{ $u->nik }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nama</th>
                                                                <td>{{ $u->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Alamat</th>
                                                                <td>{{ $u->alamat }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kecamatan</th>
                                                                <td>{{ $u->kecamatan->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kelurahan</th>
                                                                <td>{{ $u->kelurahan->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Desa</th>
                                                                <td>{{ $u->desa->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tempat Lahir</th>
                                                                <td>{{ $u->tempat_lahir }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tanggal Lahir</th>
                                                                <td>{{ \Carbon\Carbon::parse($u->tanggal_lahir)->format('d F Y') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Kelamin</th>
                                                                <td>{{ $u->jenis_kelamin }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Agama</th>
                                                                <td>{{ $u->agama }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>No. Handphone</th>
                                                                <td>{{ $u->no_hp }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pekerjaan</th>
                                                                <td>{{ $u->pekerjaan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Golongan Darah</th>
                                                                <td>{{ $u->gol_darah }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status Pernikahan</th>
                                                                <td>{{ $u->status_pernikahan }}</td>
                                                            </tr>
                                                            <tr>
                                                            <tr>
                                                            <th>Foto Wajah</th>
                                                            <td>
                                                                @if ($u->foto_wajah)
                                                                    <img class="profile-user-img" style="height:300px; width:200px;" src="{{ asset('storage/' . $u->foto_wajah) }}" alt="Foto Wajah">
                                                                @else
                                                                    <h5> Tidak Ada Foto </h5>
                                                                @endif
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Foto KTP</th>
                                                                <td>
                                                                    @if ($u->foto_ktp)
                                                                        <img class="profile-user-img" style="height:220px; width:370px;" src="{{ asset('storage/' . $u->foto_ktp) }}" alt="Foto KTP">
                                                                    @else
                                                                        <h5> Tidak Ada Foto </h5>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
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
                                <!-- Pagination Links -->
                                    <div class="container col-md-12 float-right mt-2 mb-3">
                                        {{ $users_tolak->links('vendor.pagination.adminlte_sec') }}
                                    </div>
                        </div>
                </div>
                    <div class="tab-pane fade" id="custom-tabs-four-verif" role="tabpanel" aria-labelledby="custom-tabs-four-verif-tab">
                    <div class="row">
                                <div class="col-12">
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 500px;">
                                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                            <div class="input-group-append float-left">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama Pelapor</th>
                                        <th>Email</th>
                                        <th>No. Handphone</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($users_verif) > 0)
                                    @php
                                        $no = ($users_verif->currentPage() - 1) * $users_verif->perPage() + 1;
                                    @endphp
                                    @foreach($users_verif as $u)
                                        <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $u->nik }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->no_hp }}</td>
                                        <td>{{ $u->jenis_kelamin }}</td>
                                        @if ($u->verification == 'Y')
                                        <td><div class=""><span class="badge badge-success">Terverifikasi</span></div></td>
                                        @elseif($u->verification == 'P')
                                        <td><div class=""><span class="badge badge-warning">Belum Terverifikasi</span></div></td>
                                        @elseif($u->verification == 'N')
                                        <td><div class=""><span class="badge badge-danger">Tidak Terverifikasi</span></div></td>
                                        @endif
                
                                        <td style="text-align: center;" colspan="2">
                                            <button type="button" class="btn bg-gradient-info" data-toggle="modal" data-target="#modal-lg__{{ $u->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="modal fade" id="modal-lg__{{ $u->id }}">
                                                <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Data Pengadu</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="vertical-table">
                                                            <tr>
                                                                <th>NIK</th>
                                                                <td>{{ $u->nik }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nama</th>
                                                                <td>{{ $u->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Alamat</th>
                                                                <td>{{ $u->alamat }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kecamatan</th>
                                                                <td>{{ $u->kecamatan->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Kelurahan</th>
                                                                <td>{{ $u->kelurahan->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Desa</th>
                                                                <td>{{ $u->desa->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tempat Lahir</th>
                                                                <td>{{ $u->tempat_lahir }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tanggal Lahir</th>
                                                                <td>{{ \Carbon\Carbon::parse($u->tanggal_lahir)->format('d F Y') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Kelamin</th>
                                                                <td>{{ $u->jenis_kelamin }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Agama</th>
                                                                <td>{{ $u->agama }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>No. Handphone</th>
                                                                <td>{{ $u->no_hp }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pekerjaan</th>
                                                                <td>{{ $u->pekerjaan }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Golongan Darah</th>
                                                                <td>{{ $u->gol_darah }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status Pernikahan</th>
                                                                <td>{{ $u->status_pernikahan }}</td>
                                                            </tr>
                                                            <tr>
                                                            <tr>
                                                            <th>Foto Wajah</th>
                                                            <td>
                                                                @if ($u->foto_wajah)
                                                                    <img class="profile-user-img" style="height:300px; width:200px;" src="{{ asset('storage/' . $u->foto_wajah) }}" alt="Foto Wajah">
                                                                @else
                                                                    <h5> Tidak Ada Foto </h5>
                                                                @endif
                                                            </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Foto KTP</th>
                                                                <td>
                                                                    @if ($u->foto_ktp)
                                                                        <img class="profile-user-img" style="height:220px; width:370px;" src="{{ asset('storage/' . $u->foto_ktp) }}" alt="Foto KTP">
                                                                    @else
                                                                        <h5> Tidak Ada Foto </h5>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->  
                                            <button type="button"  class=" ml-2 btn bg-gradient-danger" data-toggle="modal" data-target="#modal-suspend__{{ $u->id }}">
                                                <a style="text-decoration: none; color:white;"><i class="fas fa-power-off"></i></a>
                                            </button>
                                            <div class="modal fade" id="modal-suspend__{{ $u->id }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <!-- <h4 class="modal-title">Default Modal</h4> -->
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="post" action="/suspendedakun/{{ $u->id }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <h5 class="d-flex justify-content-center">Apakah anda yakin menangguhkan akun ini?</h5>
                                                                <input type="hidden" value="S" name="verification">
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button type="button" class="btn btn-default mr-5" data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Suspend</button>
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
                                <!-- Pagination Links -->
                                    <div class="container col-md-12 float-right mt-2 mb-3">
                                        {{ $users_verif->links('vendor.pagination.adminlte_sec') }}
                                    </div>
                        </div>
                        </div>
                    <div class="tab-pane fade show" id="custom-tabs-four-suspended" role="tabpanel" aria-labelledby="custom-tabs-four-suspended-tab">
                    <div class="row">
                                    <div class="col-12">
                                        <div class="card-tools">
                                            <div class="input-group input-group-sm" style="width: 500px;">
                                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                                <div class="input-group-append float-left">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama Pelapor</th>
                                            <th>Email</th>
                                            <th>No. Handphone</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @if(count($users_suspend) > 0)
                                        @php
                                            $no = ($users_suspend->currentPage() - 1) * $users_suspend->perPage() + 1;
                                        @endphp
                                        @foreach($users_suspend as $u)
                                            <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $u->nik }}</td>
                                            <td>{{ $u->name }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->no_hp }}</td>
                                            <td>{{ $u->jenis_kelamin }}</td>
                                            @if ($u->verification == 'Y')
                                            <td><div class=""><span class="badge badge-success">Terverifikasi</span></div></td>
                                            @elseif($u->verification == 'P')
                                            <td><div class=""><span class="badge badge-warning">Belum Terverifikasi</span></div></td>
                                            @elseif($u->verification == 'N')
                                            <td><div class=""><span class="badge badge-danger">Tidak Terverifikasi</span></div></td>
                                            @elseif($u->verification == 'S')
                                            <td><div class=""><span class="badge badge-danger">Suspended</span></div></td>
                                            @endif
                    
                                            <td style="text-align: center;" colspan="2">
                                                <button type="button" class="btn bg-gradient-info" data-toggle="modal" data-target="#modal-lg__{{ $u->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <div class="modal fade" id="modal-lg__{{ $u->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Data Pengadu</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="vertical-table">
                                                                <tr>
                                                                    <th>NIK</th>
                                                                    <td>{{ $u->nik }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Nama</th>
                                                                    <td>{{ $u->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Alamat</th>
                                                                    <td>{{ $u->alamat }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Kecamatan</th>
                                                                    <td>{{ $u->kecamatan->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Kelurahan</th>
                                                                    <td>{{ $u->kelurahan->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Desa</th>
                                                                    <td>{{ $u->desa->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tempat Lahir</th>
                                                                    <td>{{ $u->tempat_lahir }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tanggal Lahir</th>
                                                                    <td>{{ \Carbon\Carbon::parse($u->tanggal_lahir)->format('d F Y') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Jenis Kelamin</th>
                                                                    <td>{{ $u->jenis_kelamin }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Agama</th>
                                                                    <td>{{ $u->agama }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>No. Handphone</th>
                                                                    <td>{{ $u->no_hp }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Pekerjaan</th>
                                                                    <td>{{ $u->pekerjaan }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Golongan Darah</th>
                                                                    <td>{{ $u->gol_darah }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status Pernikahan</th>
                                                                    <td>{{ $u->status_pernikahan }}</td>
                                                                </tr>
                                                                <tr>
                                                                <tr>
                                                                <th>Foto Wajah</th>
                                                                <td>
                                                                    @if ($u->foto_wajah)
                                                                        <img class="profile-user-img" style="height:300px; width:200px;" src="{{ asset('storage/' . $u->foto_wajah) }}" alt="Foto Wajah">
                                                                    @else
                                                                        <h5> Tidak Ada Foto </h5>
                                                                    @endif
                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Foto KTP</th>
                                                                    <td>
                                                                        @if ($u->foto_ktp)
                                                                            <img class="profile-user-img" style="height:220px; width:370px;" src="{{ asset('storage/' . $u->foto_ktp) }}" alt="Foto KTP">
                                                                        @else
                                                                            <h5> Tidak Ada Foto </h5>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->  
                                            <button type="button"  class="btn bg-gradient-danger ml-2" data-toggle="modal" data-target="#modal-hapus__{{ $u->id }}">
                                                <a style="text-decoration: none; color:white;"><i class="fas fa-trash"></i></a>
                                            </button>    
                                                <div class="modal fade" id="modal-hapus__{{ $u->id }}">
                                                            <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <!-- <h4 class="modal-title">Default Modal</h4> -->
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                <form method="post" action="/hapususer/{{ $u->id }}">
                                                                    @csrf
                                                                    <h5 class="d-flex justify-content-center">Apakah anda yakin menghapus akun user ini?</h5>
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <button type="button" class="btn btn-default mr-5" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Hapus</button>
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
                                        <tr> <td colspan="8" style="text-align: center;">No Data</td> </tr>
                                        @endif
                                        </tbody>
                                        </table>
                                    </div>
                                    <!-- Pagination Links -->
                                        <div class="container col-md-12 float-right mt-2 mb-3">
                                            {{ $users_suspend->links('vendor.pagination.adminlte_sec') }}
                                        </div>
                            </div>
                    </div>    

@endsection