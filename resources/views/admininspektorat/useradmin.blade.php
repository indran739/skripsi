@extends('layouts.main_opd')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Data berhasil ditambah</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(Session::has('hapus'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Data berhasil dihapus</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(Session::has('updated'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Data berhasil diedit</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(Session::has('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Data gagal ditambah</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User Admin OPD</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">User Admin</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    <!-- /.content-header -->

<div class="card">
        <div class="card-header">
            <h3 class="card-title">Data User Admin</h3>
            <button type="button"  class="btn bg-gradient-success d-flex justify-content-end float-right" data-toggle="modal" data-target="#modal-lg">
                <a style="text-decoration: none; color:white;"><i class="fas fa-plus-square mr-2"></i> Tambah User</a>
            </button>
            <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Tambah User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                <div class="card">
                    <div class="card-header" style="background-color:#4030A3;">
                        <h7 class="card-title">
                           
                        </h7>
                    </div>
                    <div class="card-body">
                    <form method="post" action="/tambahadmin" enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">NIK</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="" style="width: 30%;" name="nik" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="" style="width: 70%;" name="name" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">OPD</label>
                            <div class="col-sm-9">
                                <select class="form-control select2" style="width: 70%;" name="id_opd_fk" required>
                                    <option selected="selected">Pilih OPD</option>
                                    @foreach($opds as $opd)
                                        @if($opd->name != 'pengadu' && $opd->name != 'Inspektorat Kabupaten Gunung Mas')
                                            <option value="{{ $opd->id }}" {{ old('id_opd_fk') == $opd->id ? 'selected' : '' }}>
                                                {{ $opd->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('id_opd_fk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="3" placeholder="" name="alamat" value="" required> </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" style="width: 40%;" placeholder="" name="email" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">No. Handphone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" style="width: 40%;" placeholder="" name="no_hp" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control"  style="width: 40%;" name="password" id="exampleInputPassword1" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success mr-4">Submit</button>
                        <button class="btn btn-info float-right"><a href="/profile" style="color:white;">Kembali</a></button>
                    </div>
                </form>
                    </div>
                </div>
                    
                </div>
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div><!-- /.card-header -->
                    <div class="row">
                        <div class="col-12">
                          <div class="card-tools">
                              <div class="input-group input-group-sm ml-4 mt-3 mb-3" style="width: 500px;">
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
                                    <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                        <th>No</th>
                                        <th>OPD</th>
                                        <th>Email</th>
                                        <th>No. Handphone</th>
                                        <th style="text-align: center;">Status</th>
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
                                        <td>{{ $u->opd->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->no_hp }}</td>
                                        @if ($u->verification == 'Y')
                                        <td><div class="d-flex justify-content-center"><span class="badge badge-success">Terverifikasi</span></div></td>
                                        @elseif($u->verification == 'P')
                                        <td><div class="d-flex justify-content-center"><span class="badge badge-warning">Pending</span></div></td>
                                        @elseif($u->verification == 'N')
                                        <td><div class="d-flex justify-content-center"><span class="badge badge-danger">Tidak Terverifikasi</span></div></td>
                                        @endif
                                        <td colspan="2">
                                        <div class="d-flex justify-content-center">
                                        <button type="button"  class="btn bg-gradient-info" data-toggle="modal" data-target="#modal-view__{{ $u->id }}">
                                            <a style="text-decoration: none; color:white;"><i class="fas fa-eye"></i></a>
                                        </button>
                                            <div class="modal fade" id="modal-view__{{ $u->id }}">
                                                    <div class="modal-dialog modal-default">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Data Admin OPD</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body d-flex justify-content-center">
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
                                                                    <th>Email</th>
                                                                    <td>{{ $u->email }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>No. Handphone</th>
                                                                    <td>{{ $u->no_hp }}</td>
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
                                                <button type="button"  class="ml-2 btn bg-gradient-warning" data-toggle="modal" data-target="#modal-edit__{{ $u->id }}">
                                                    <a style="text-decoration: none; color:black;"><i class="fas fa-edit"></i></a>
                                                </button>
                                                <div class="modal fade" id="modal-edit__{{$u->id}}">
                                                    <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h4 class="modal-title">Edit User</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#4030A3;">
                                                            <h7 class="card-title">
                                                            
                                                            </h7>
                                                        </div>
                                                        <div class="card-body">
                                                        <form method="post" action="/edituseradmin/{{ $u->id }}" enctype="multipart/form-data" >
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-3 col-form-label">NIK</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" disabled placeholder="" style="width: 30%;" name="nik" value="{{$u->nik}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-3 col-form-label">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="" style="width: 70%;" name="name" value="{{ $u->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-3 col-form-label">OPD</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control select2" style="width: 70%;" name="id_opd_fk" required>
                                                                        <option selected="selected">Pilih OPD</option>
                                                                        @foreach($opds as $opd)
                                                                            @if($opd->name != 'pengadu' && $opd->name != 'Inspektorat Kabupaten Gunung Mas')
                                                                            <option value="{{ $opd->id }}" @if($u->id_opd_fk == $opd->id) selected @endif>
                                                                                {{ $opd->name }}
                                                                            </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    @error('id_opd_fk')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-3 col-form-label">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control" rows="3" placeholder="" name="alamat" value="" required>{{$u->alamat}} </textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-3 col-form-label">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input type="email" class="form-control" style="width: 40%;" placeholder="" name="email" value="{{$u->email}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-3 col-form-label">No. Handphone</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" style="width: 40%;" placeholder="" name="no_hp" value="{{$u->no_hp}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="" class="col-sm-3 col-form-label">Password</label>
                                                                <div class="col-sm-9">
                                                                    <input type="password" class="form-control"  style="width: 40%;" name="password" id="exampleInputPassword1" placeholder="*************">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="submit" class="btn btn-success mr-4">Submit</button>
                                                        </div>
                                                    </form>
                                                        </div>
                                                    </div>
                                                        
                                                    </div>
                                                    <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                                <button type="button"  class="ml-2 btn bg-gradient-danger" data-toggle="modal" data-target="#modal-hapus__{{ $u->id }}">
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
                                                                <form method="post" action="/delete_admin/{{ $u->id }}">
                                                                    @csrf
                                                                    <h5 class="d-flex justify-content-center">Apakah anda yakin menghapus akun ini?</h5>
                                                                    <input type="hidden" value="S" name="verification">
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <button type="button" class="btn btn-danger mr-5" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Hapus</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                        <!-- /.modal -->
                                        </div>
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
                                    <div class="container col-md-12 float-right mt-3 mb-3">
                                        {{ $users->links('vendor.pagination.adminlte_sec') }}
                                    </div>
                        </div>
            </div>
        <!-- /.card -->
</div><!-- /.container-fluid -->
@endsection