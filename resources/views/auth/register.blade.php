@extends('layouts.main_sec')
@section('container')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <style>
    ::placeholder {
      font-style: italic; /* Menjadikan teks miring */
    }
  </style>
  
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-5">
        <div class="card">
            <div class="card-header  d-flex justify-content-center" style="background-color:#4030A3;">
            <div class="card-title">
                <h4 class="text-white">
                    Registrasi Akun
                </h4>
            </div>
            </div>
            <div class="card-body">
            <form method="post" action="{{ route('register') }}" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">NIK</label>
                        <div class="col-sm-9">
                            <input type="text" style="width: 40%;" value="{{ old('nik') }}" class="form-control @error('nik') is-invalid @enderror" placeholder="62**************" name="nik">
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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap Anda" name="name"  value="{{ old('name') }}">
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Ketik Alamat Anda.." name="alamat" value="{{ old('alamat') }}" required>Ketik Alamat Anda.. </textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Kecamatan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2 @error('id_kecamatan_fk') is-invalid @enderror" value="{{ old('id_kecamatan_fk') }}" required autocomplete="id_kecamatan_fk" style="width: 70%;" name="id_kecamatan_fk">
                                <option selected="selected" disabled>Pilih Kecamatan</option>
                                @foreach($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('id_kecamatan_fk') == $kecamatan->id ? 'selected' : '' }}>
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
                                    <option value="{{ $desa->id }}" {{ old('id_desa_fk') == $desa->id ? 'selected' : '' }}>
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
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Ketik Tempat Lahir Anda" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
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
                                <input type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror datetimepicker-input" name="tanggal_lahir" data-target="#reservationdate" value="{{ old('tanggal_lahir') }}"/>
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
                                <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" >Perempuan</option>
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
                            <select class="form-control select2 @error('agama') is-invalid @enderror" value="{{ old('agama') }}"  required autocomplete="agama" style="width: 70%;" name="agama">
                                <option selected="selected" disbabled>Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                                <option value="Kong Hu Chu" {{ old('agama') == 'Kong Hu Chu' ? 'selected' : '' }}>Kong Hu Chu</option>
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
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" style="width: 25%;" placeholder="" name="no_hp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Pekerjaan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2  @error('pekerjaan') is-invalid @enderror" style="width: 70%;" name="pekerjaan" required autocomplete="pekerjaan">
                                <option selected="selected">Pilih Pekerjaan</option>
                                <option value="PNS" {{ old('pekerjaan') == 'PNS' ? 'selected' : '' }} >PNS</option>
                                <option value="Wiraswasta" {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                <option value="Mahasiswa" {{ old('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="Pelajar" {{ old('pekerjaan') == 'Pelajar' ? 'selected' : '' }}>Pelajar</option>   
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
                            <select class="form-control select2 @error('gol_darah') is-invalid @enderror" style="width: 70%;" 
                                    <select class="form-select @error('gol_darah') is-invalid @enderror" name="gol_darah" value="{{ old('gol_darah') }}" required autocomplete="gol_darah">
                                <option selected="selected" disbabled>Pilih Gol.Darah</option>
                                <option value="A" {{ old('gol_darah') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('gol_darah') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('gol_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('gol_darah') == 'O' ? 'selected' : '' }}>O</option>
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
                                <option value="Belum Menikah" {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="Sudah Menikah" {{ old('status_pernikahan') == 'Sudah Menikah' ? 'selected' : '' }}>Sudah Menikah</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foto Wajah</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 50%;">
                                <input type="file" class="custom-file-input @error('foto_wajah') is-invalid @enderror" id="customFile" name="foto_wajah" required autocomplete="foto_wajah">
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
                                <input type="file" class="custom-file-input @error('foto_ktp') is-invalid @enderror" id="customFile" name="foto_ktp" required autocomplete="foto_ktp">
                                <label class="custom-file-label" for="customFile">Choose File</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input id="password" style="width: 40%;" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>
                    <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input id="password-confirm" style="width: 40%;" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                            </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-default text-white btn-block" style="width: 40%;background-color:#4030A3;">Submit</button>
                    </div>
                </div>
                  <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                     
                  </div>
                </form>
            </div>
        </div>
          <!-- /.col-md-6 -->
          <!-- <div class="col-lg-5">
            
          </div> -->
          <!-- /.col-md-6 -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection