@extends('layouts.main_opd')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
      @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Kategori berhasil ditambahkan</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(Session::has('berhasil'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Kategori berhasil diedit</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(Session::has('hapus'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Kategori berhasil dihapus</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Kategori Pengaduan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admininspektorat">Beranda</a></li>
              <li class="breadcrumb-item active">Kategori Pengaduan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    <!-- /.content-header -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-3 mt-3 ml-3">
                          <button type="button"  class="btn bg-gradient-success mr-2" data-toggle="modal" data-target="#modal-default">
                              <a style="text-decoration: none; color:white;"><i class="fas fa-plus-square mr-2"></i> Tambah Kategori</a>
                          </button>
                          <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Tambah Kategori</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <form method="post" action="/storekategori">
                                  @csrf
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Nama Kategori</label>
                                      <input type="text" class="form-control @error('name') is-invalid @enderror" required autofocus value="{{ old('name') }}" value="" name="name" id="">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}  
                                        </div> 
                                    @enderror  
                                  </div>
                                </div>
                                  <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-primary">Tambah</button> 
                                        <a href="" data-dismiss="modal" class="btn btn-info">Kembali</a>
                                  </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <!-- /.modal -->
                        </div>
                      </div>
                        <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 500px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
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
                            <th>Kategori</th>
                            <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                    @if(count($categories) > 0)
                        @php
                            $no = ($categories->currentPage() - 1) * $categories->perPage() + 1;
                        @endphp
                        @foreach($categories as $c)
                            <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $c->name }}</td>
                            <td style="text-align: center;" colspan="2">
                                <button type="button"  class="btn bg-gradient-warning mr-2" data-toggle="modal" data-target="#modal-edit__{{ $c->id }}">
                                    <a style="text-decoration: none; color:black;"><i class="fas fa-edit"></i></a>
                                </button>
                                <div class="modal fade" id="modal-edit__{{ $c->id }}">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="modal-title">Edit Kategori</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                      <form method="post" action="/editkategori/{{ $c->id }}">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label class="d-flex justify-content-start" for="exampleInputEmail1">Nama Kategori</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" required autofocus value="{{ $c->name }}" value="" name="name" id="">
                                          @error('name')
                                              <div class="invalid-feedback">
                                                  {{ $message }}  
                                              </div> 
                                          @enderror  
                                        </div>
                                      </div>
                                        <div class="modal-footer justify-content-center">
                                              <button type="submit" class="btn btn-primary">Tambah</button> 
                                              <a href="" data-dismiss="modal" class="btn btn-info">Kembali</a>
                                        </div>
                                      </form>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                <button type="button"  class="btn bg-gradient-danger" data-toggle="modal" data-target="#modal-hapus__{{ $c->id }}">
                                    <a style="text-decoration: none; color:white;"><i class="fas fa-trash"></i></a>
                                </button>
                                <div class="modal fade" id="modal-hapus__{{ $c->id }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <!-- <h4 class="modal-title">Default Modal</h4> -->
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form method="post" action="/hapuskategori/{{ $c->id }}">
                                                                @csrf
                                                                <h5 class="d-flex justify-content-center">Apakah anda yakin menghapus kategori ini?</h5>
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
                        <tr> <td colspan="7" style="text-align: center;">No Data</td> </tr>
                        @endif
                        </tbody>
                        </table>
                    </div>
                         <!-- Pagination Links -->
                                <div class="container col-md-12 float-right mt-2 mb-3">
                                    {{ $categories->links('vendor.pagination.adminlte_sec') }}
                                </div>
                            </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                </div>
                <!-- /.row -->
            </div>
        <!-- /.card -->
</div><!-- /.container-fluid -->
@endsection