@extends('layouts.main_pengadu')   
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 mb-3">
            <h1 class="m-0">Profile User</h1>
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
                    <a class="nav-link" style="color: black;text-decoration: none;" id="custom-tabs-four-pass-tab" data-toggle="pill" href="#custom-tabs-four-pass" role="tab" aria-controls="custom-tabs-four-pass" aria-selected="false"><i class="fas fa-lock mr-2"></i>Ubah Password</a>
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
                                <dt class="col-sm-4 mb-3">Kecamatan </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->kecamatan->name }} </dd>
                                <dt class="col-sm-4 mb-3">Kelurahan/Desa </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->desa->kelurahan->name }} </dd>
                                <dt class="col-sm-4 mb-3">Tempat Lahir </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->tempat_lahir }} </dd>
                                <dt class="col-sm-4 mb-3">Tanggal Lahir </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d F Y') }} </dd>
                                <dt class="col-sm-4 mb-3">Jenis Kelamin </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->jenis_kelamin }} </dd>
                                <dt class="col-sm-4 mb-3">Agama </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->agama }} </dd>
                                <dt class="col-sm-4 mb-3">Email </dt>
                                <dd class="col-sm-8 mb-3"> <span>:</span> {{ auth()->user()->email }} </dd>
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
                            <input type="text" class="form-control" placeholder="" name="name" value="{{ auth()->user()->name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="3" placeholder="" name="alamat" value="" required>{{ auth()->user()->alamat }} </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" style="width: 45%;" placeholder="" name="no_hp" value="{{ auth()->user()->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">No. Handphone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" style="width: 25%;" placeholder="" name="no_hp" value="{{ auth()->user()->no_hp }}">
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foto Wajah</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 40%;">
                                <input type="file" class="custom-file-input" id="customFile" name="foto_wajah">
                                <label class="custom-file-label" for="customFile">Choose File</label>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foto KTP</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 40%;">
                                <input type="file" class="custom-file-input" id="customFile" name="foto_ktp">
                                <label class="custom-file-label" for="customFile">Choose File</label>
                            </div>
                        </div>
                    </div> -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="custom-tabs-four-pass" role="tabpanel" aria-labelledby="custom-tabs-four-pass-tab">
                <form id="changePasswordForm" method="post" action="/ubahpassword/{{ auth()->user()->id }}" enctype="multipart/form-data" >
                    @csrf
                    @method('put')
                    @auth
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" style="width: 45%;" placeholder="*********" name="password" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Password Baru (ulangi)</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" style="width: 45%;" placeholder="*********" name="password_confirmation" value="">
                        </div>
                    </div>
                    <!-- Catatan Password -->
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <small class="text-muted">
                                <strong>Catatan:</strong>  
                                <li>Password minimal 8 karakter.</li>
                                <li>Gunakan password yang unik dan sulit ditebak oleh pengguna lain, tetapi cukup mudah Anda ingat.</li>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                    @endauth
                </form>
                </div>
                  @endauth
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>  

@endsection

