@extends('layouts.main_third')   
@section('container')
<div class="container" style="margin-top:230px; margin-bottom:100px;" >
  <div class="row">
    <div class="col d-flex justify-content-center">
        <div class="login-box">
      <!-- /.login-logo -->
        <div class="card card-outline card-dark">
        <div class="card-header text-center text-white" style="background-color:#4030A3;">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="row"><strong>Berhasil membuat Akun</strong></div>
                <div class="row">Anda dapat menunggu verifikasi akun dari admin 1x24 jam</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="row"><strong>Gagal Login</strong></div>
                <div class="row">{{ error }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <h2><strong>Login</strong></h2>
            <img src="{{asset('/')}}dist/img/gumas.png" alt="AdminLTE Logo" class="img mr-2" style="opacity: .8; height:90px; width:75px;">
            <h1><strong>SIPEMAS</strong></h1>
             <!-- <h1>Login</h1> -->
        </div>
        <div class="card-body">
          <p class="login-box-msg text-muted">Silahkan login kedalam sistem </p>

          <form action="{{ route('login') }}" method="post">
            @csrf
              @error('nik')
                <div class="alert alert-danger">
                  <h7><i class="fas fa-brake-warning"></i>NIK atau Password Salah!</h7>
                </div>
              @enderror
            <div class="input-group mb-3">
              <input type="text" class="form-control @error('nik') is-invalid @enderror" placeholder="NIK" name="nik">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="EMAIL" name="email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
              @error('password')
                <div class="alert alert-danger">
                  <h7><i class="fas fa-brake-warning"></i>NIK atau Password Salah!</h7>
                </div>
              @enderror
            <div class="input-group mb-3">
              <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
              <p class="mb-0">
                Belum punya akun? <a href="/daftar" class="text-center">Daftar</u></a>
              </p>
            <div class="row">
              <div class="col-8">
                  &nbsp;
              </div>
              <!-- /.col -->
              <div class="col-12">
                <button type="submit" class="btn btn-default text-white btn-block" style="background-color:#4030A3;">Masuk</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          <!-- <div class="social-auth-links text-center mt-2 mb-3">
            <a href="#" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
          </div>
          /.social-auth-links -->

          <!-- <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p>
          <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
          </p>
        </div> -->
        <!-- /.card-body -->
      </div>
  <!-- /.card -->
</div>
    </div>
  </div>
</div>

@endsection
