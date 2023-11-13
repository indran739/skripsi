@extends('layouts.main_fourth')
@section('container')
    @auth
        @if (auth()->user()->verification == 'P')
            <div class="container">
                <h6 class="fw-bold mt-4">Akun anda masih dalam proses verifikasi dan sedang dilakukan check untuk validasi data anda</h6>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        @endif
        @if (auth()->user()->verification == 'S')
            <div class="container">
                <h6 class="fw-bold mt-4">Akun anda ditangguhkan sementara.</h6>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        @endif
        @if (auth()->user()->verification == 'N')
        <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container">
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                <div class="container">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>Profile telah diperbarui!</strong> harap periksa kembali data anda.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                    <div class="row">
                    <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header" style="background-color:#4030A3;">
                            <h5 class="card-title text-white">
                                Registrasi Akun
                            </h5>
                        </div>
                        <div class="card-body">
                        <form method="post" action="/editdataregister/{{ auth()->user()->id }}" enctype="multipart/form-data" >
                        @csrf
                        @method('put')
                        @auth
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">NIK</label>
                                    <div class="col-sm-9">
                                        <input type="text" style="width: 40%;" value="{{ auth()->user()->nik }}" class="form-control @error('nik') is-invalid @enderror" placeholder="" name="nik">
                                        @error('nik')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" name="name"  value="{{ auth()->user()->name }}">
                                        @error('name')0
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="" name="alamat" value="{{ old('alamat') }}" required>{{ auth()->user()->alamat }} </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 @error('id_kecamatan_fk') is-invalid @enderror" value="{{ old('id_kecamatan_fk') }}" required autocomplete="id_kecamatan_fk" style="width: 70%;" name="id_kecamatan_fk">
                                            <option selected="selected" disabled>Pilih Kecamatan</option>
                                            @foreach($kecamatans as $kecamatan)
                                                <option value="{{ $kecamatan->id }}" {{ auth()->user()->id_kecamatan_fk == $kecamatan->id ? 'selected' : '' }}>
                                                    {{ $kecamatan->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_kecamatan_fk')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Kelurahan / Desa</label>
                                    <div class="col-sm-9">
                                    <select class="form-control select2 @error('id_desa_fk') is-invalid @enderror" value="{{ old('id_desa_fk') }}" required autocomplete="id_desa" style="width: 70%;" name="id_desa_fk">
                                            <option selected="selected" disabled>Pilih Kelurahan / Desa</option>
                                            @foreach($desas as $desa)
                                                <option value="{{ $desa->id }}" {{  auth()->user()->id_desa_fk == $desa->id ? 'selected' : '' }}>
                                                    {{ $desa->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_desa_fk')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="" name="tempat_lahir" value="{{ auth()->user()->tempat_lahir }}">
                                        @error('tempat_lahir')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date" style="width: 35%;" id="reservationdate" data-target-input="nearest" >
                                            <input type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror datetimepicker-input" name="tanggal_lahir" data-target="#reservationdate" value="{{ \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d/m/Y') }}"/>
                                            @error('tanggal_lahir')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" value="{{ old('jenis_kelamin') }}" required autocomplete="jenis_kelamin" style="width: 70%;" name="jenis_kelamin">
                                            <option selected="selected" disabled>Pilih Jenis Kelamin</option>
                                            <option value="Laki-Laki" {{ auth()->user()->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ auth()->user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Agama</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 @error('agama') is-invalid @enderror" value=""  required autocomplete="agama" style="width: 70%;" name="agama">
                                        <option selected="selected" disbabled>Pilih Agama</option>
                                        <option value="Islam" {{ auth()->user()->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ auth()->user()->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ auth()->user()->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ auth()->user()->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Budha" {{ auth()->user()->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                                        <option value="Kong Hu Chu" {{ auth()->user()->agama == 'Kong Hu Chu' ? 'selected' : '' }}>Kong Hu Chu</option>
                                        </select>
                                        @error('agama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" style="width: 65%;"name="email" value="{{ auth()->user()->email }}" required autocomplete="email">
                                        @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">No. Handphone</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" value="{{ auth()->user()->no_hp }}" style="width: 25%;" placeholder="" name="no_hp">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Pekerjaan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2  @error('pekerjaan') is-invalid @enderror" style="width: 70%;" name="pekerjaan" required autocomplete="pekerjaan">
                                        <option selected="selected">Pilih Pekerjaan</option>
                                        <option value="PNS" {{ auth()->user()->pekerjaan == 'PNS' ? 'selected' : '' }}>PNS</option>
                                        <option value="Wiraswasta" {{ auth()->user()->pekerjaan == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                        <option value="Mahasiswa" {{ auth()->user()->pekerjaan == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="Pelajar" {{ auth()->user()->pekerjaan == 'Pelajar' ? 'selected' : '' }}>Pelajar</option>   
                                        </select>
                                    </div>
                                    @error('pekerjaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Golongan Darah</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 @error('gol_darah') is-invalid @enderror" name="gol_darah" style="width: 70%;" >
                                        <option selected="selected" disbabled>Pilih Gol.Darah</option>
                                        <option value="A" {{ auth()->user()->gol_darah == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ auth()->user()->gol_darah == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ auth()->user()->gol_darah == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ auth()->user()->gol_darah == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                        @error('gol_darah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Status Pernikahan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 @error('status_pernikahan') is-invalid @enderror" style="width: 70%;" name="status_pernikahan" value="{{ old('status_pernikahan') }}" required autocomplete="status_pernikahan">
                                        <option selected="selected" disabled>Pilih Status</option>
                                        <option value="Belum Menikah" {{ auth()->user()->status_pernikahan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                        <option value="Sudah Menikah" {{ auth()->user()->status_pernikahan == 'Sudah Menikah' ? 'selected' : '' }}>Sudah Menikah</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Foto Wajah</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file" style="width: 50%;">
                                            <input type="file" class="custom-file-input @error('foto_wajah') is-invalid @enderror" id="customFile" name="foto_wajah" autocomplete="foto_wajah">
                                            @error('foto_wajah')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <label class="custom-file-label" for="customFile">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-sm-3 col-form-label">Foto KTP</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file" style="width: 50%;">
                                            <input type="file" class="custom-file-input @error('foto_ktp') is-invalid @enderror" id="customFile" name="foto_ktp"  autocomplete="foto_ktp">
                                            <label class="custom-file-label" for="customFile">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button class="btn btn-info float-right"><a href="/halamanpending" style="color:white;">Kembali</a></button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                
                            </div>
                            @endauth
                            </form>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                    <div class="col-lg-5">
                            <div class="card">
                                <div class="card-header" style="background-color:#4030A3;">
                                    <h5 class="card-title text-white">
                                        Tanggapan Admin
                                    </h5>
                                </div>
                                    <div class="card-body">
                                    @foreach ($tanggapans as $tanggapan)
                                    <div class="user-block">
                                    <span class="username">
                                        <a href="#">Admin Inspektorat</a>
                                    </span>
                                    <span class="description">Memberi tanggapan - {{ \Carbon\Carbon::parse($tanggapan->created_at)->format('d F Y, H:i') }}</span>                                    <p>
                                    {{ $tanggapan->tanggapan }}
                                    </p>

                                    @endforeach
                                    </div>
                                    <!-- /.user-block -->
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- /.col-md-6 -->
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        @endif
        @if (auth()->user()->verification == 'Y')
            <div class="container">
                <h6>Akun anda sudah terverifikasi dan dinyatakan valid, silahkan login kembali</h6>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        @endif
    @endauth
@endsection
