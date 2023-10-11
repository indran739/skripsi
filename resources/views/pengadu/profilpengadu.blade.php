@extends('layouts.main_pengadu')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Profile User</h1>
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>Profile telah diperbarui!</strong> harap periksa kembali data anda.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="berandapengadu">Beranda</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="col-12 col-sm-6">
            <div class="card card-indigo card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" style="color: black;text-decoration: none;" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><i class="fas fa-user mr-2"></i>Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false"><i class="fas fa-edit mr-2"></i>Edit Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Ubah Sandi</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <div class="card-body">
                                <dl class="row">
                                <dt class="col-sm-4 mb-3">NIK</dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->nik }} </dd>
                                <dt class="col-sm-4 mb-3">Nama</dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->name }} </dd>
                                <dt class="col-sm-4 mb-3">Alamat</dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->alamat }} </dd>
                                <dt class="col-sm-4 mb-3">Tempat Lahir </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->tempat_lahir }} </dd>
                                <dt class="col-sm-4 mb-3">Tanggal Lahir </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d F Y') }} </dd>
                                <dt class="col-sm-4 mb-3">Jenis Kelamin </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->jenis_kelamin }} </dd>
                                <dt class="col-sm-4 mb-3">Agama </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->agama }} </dd>
                                <dt class="col-sm-4 mb-3">No. Handphone </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->no_hp }} </dd>
                                <dt class="col-sm-4 mb-3">Pekerjaan </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->pekerjaan }} </dd>
                                <dt class="col-sm-4 mb-3">Golongan Darah </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->gol_darah }} </dd>
                                <dt class="col-sm-4 mb-3">Status Pernikahan </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->status_pernikahan }} </dd>
                                <dt class="col-sm-4 mb-3 mt-4">Foto Wajah </dt>
                                <dd class="col-sm-8 mb-3 mt-4"> <span>:</span> @if (auth()->user()->foto_wajah)
                                                                             <img class="profile-user-img" style="height:300px; width:200px;" src="{{ asset('storage/' . auth()->user()->foto_wajah) }}"alt="User profile picture">
                                                                          @else
                                                                             <h5> No Pict </h5>
                                                                          @endif</dd>
                                <dt class="col-sm-4 mt-4">Foto KTP </dt>
                                <dd class="col-sm-8 mt-4"> <span>:</span> @if (auth()->user()->foto_ktp)
                                                                             <img class="profile-user-img" style="height:220px; width:370px;" src="{{ asset('storage/' . auth()->user()->foto_ktp) }}"alt="User profile picture">
                                                                          @else
                                                                             <h5> No Pict </h5>
                                                                          @endif</dd>

                                </dl>
                        </div>
                    </div>
                  <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  <form method="post" action="/editprofile/{{ auth()->user()->id }}" enctype="multipart/form-data" >
                    @csrf
                    @method('put')
                    @auth
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="" name="name" value="{{ auth()->user()->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="3" placeholder="" name="alamat" value="" required>{{ auth()->user()->alamat }} </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="" name="tempat_lahir" value="{{ auth()->user()->tempat_lahir }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <div class="input-group date" style="width: 35%;" id="reservationdate" data-target-input="nearest" >
                                <input type="text" class="form-control datetimepicker-input" name="tanggal_lahir" data-target="#reservationdate" value="{{ \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d/m/Y') }}" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 70%;" name="jenis_kelamin">
                                <option selected="selected" disabled>Pilih Jenis Kelamin</option>
                                <option value="Laki-Laki" {{ auth()->user()->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ auth()->user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Agama</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 70%;" name="agama">
                                <option selected="selected" disbabled>Pilih Agama</option>
                                <option value="Islam" {{ auth()->user()->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ auth()->user()->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ auth()->user()->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ auth()->user()->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Budha" {{ auth()->user()->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                                <option value="Kong Hu Chu" {{ auth()->user()->agama == 'Kong Hu Chu' ? 'selected' : '' }}>Kong Hu Chu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" style="width: 25%;" placeholder="" name="no_hp" value="{{ auth()->user()->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">No. Handphone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" style="width: 25%;" placeholder="" name="no_hp" value="{{ auth()->user()->no_hp }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Pekerjaan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 70%;" name="pekerjaan">
                                <option selected="selected">Pilih Pekerjaan</option>
                                <option value="PNS" {{ auth()->user()->pekerjaan == 'PNS' ? 'selected' : '' }}>PNS</option>
                                <option value="Wiraswasta" {{ auth()->user()->pekerjaan == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="Mahasiswa" {{ auth()->user()->pekerjaan == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="Pelajar" {{ auth()->user()->pekerjaan == 'Pelajar' ? 'selected' : '' }}>Pelajar</option>   
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Golongan Darah</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 70%;" name="gol_darah">
                                <option selected="selected" disbabled>Pilih Gol.Darah</option>
                                <option value="A" {{ auth()->user()->gol_darah == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ auth()->user()->gol_darah == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ auth()->user()->gol_darah == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ auth()->user()->gol_darah == 'O' ? 'selected' : '' }}>O</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Status Pernikahan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 70%;" name="status_pernikahan">
                                <option selected="selected" disabled>Pilih Status</option>
                                <option value="Belum Menikah" {{ auth()->user()->status_pernikahan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Sudah Menikah" {{ auth()->user()->status_pernikahan == 'Sudah Menikah' ? 'selected' : '' }}>Sudah Menikah</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foto Wajah</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 40%;">
                                <input type="file" class="custom-file-input" id="customFile" name="foto_wajah">
                                <label class="custom-file-label" for="customFile">Choose File</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foto KTP</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 40%;">
                                <input type="file" class="custom-file-input" id="customFile" name="foto_ktp">
                                <label class="custom-file-label" for="customFile">Choose File</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button class="btn btn-info float-right"><a href="/profile" style="color:white;">Kembali</a></button>
                    </div>
                </div>
                  <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                     
                  </div>
                  @endauth
                </form>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>  
@endsection

