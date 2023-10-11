@extends('layouts.main_sec')   
@section('container')
<div class="container" style="margin-top:80px; margin-bottom:80px;">
    <h1>DAFTAR AKUN</h1>
    @if(Session::has('berhasil'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Pendaftaran Berhasil!</strong> Anda dapat Menunggu verifikasi akun oleh admin.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="container">
        <div class="row mt-4">
            <form method="post" action="/daftarakun">
                @csrf
                <div class="col-md-9">
                <div class="row">
                    <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required autofocus id="floatingInput" name="nik">
                        @error('nik')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="floatingInput">NIK</label>
                    </div>
                    </div>
                    <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="floatingInput" name="name" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="floatingInput">Nama Lengkap</label>
                    </div>
                    </div>
                </div>
                <div class="rowspan-2 mt-4">
                <div class="form-floating">
                    <textarea class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" required placeholder="Leave a comment here" name="alamat" id="floatingTextarea2" style="height: 100px"></textarea>
                    @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                    <label for="floatingTextarea2">Alamat</label>
                </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"  value="{{ old('tempat_lahir') }}" required id="floatingInput" name="tempat_lahir">
                        @error('tempat_lahir')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="floatingInput">Tempat Lahir</label>
                    </div>
                    </div> 
                    <div class="col">
                        <input class="form-control mt-3 @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" aria-label="default input example">
                        @error('tanggal_lahir')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="input-group">
                            <select class="form-select" name="jenis_kelamin">
                                <option selected disabled>Jenis Kelamin</option>
                                <option value="Laki-Laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <select class="form-select" name="agama">
                                <option selected disabled>Agama</option>
                                <option value="Laki-Laki">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Kong Hu Chu">Kong Hu Chu</option>
                            </select>
                        </div>
                    </div>  
                </div>
                <div class="row mt-4">
                    <div class="col">
                    <div class="form-floating">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required id="floatingInput" name="email" placeholder="name@example.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="floatingInput">Email</label>
                    </div>
                    </div>
                    <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('no_tlp') is-invalid @enderror" value="{{ old('no_tlp') }}" required id="floatingInput" name="no_tlp">
                        @error('no_tlp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="floatingInput">No.Handphone</label>
                    </div>
                    </div> 
                </div>
                <div class="row mt-4">
                <div class="col">
                        <div class="input-group">
                            <select class="form-select" name="pekerjaan">
                                <option selected disabled>Pekerjaan</option>
                                <option value="PNS">PNS</option>
                                <option value="Wiraswasta">Wiraswasta</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Pelajar">Pelajar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                    <div class="input-group">
                            <select class="form-select" name="gol_darah">
                                <option selected disabled>Golongan darah</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                     </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <div class="input-group">
                            <label class="input-group-text fw-bold" for="inputGroupFile01">Upload Foto Wajah</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="foto_wajah">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <label class="input-group-text fw-bold" for="inputGroupFile01">Upload Foto KTP</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="foto_ktp">
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                            <div class="input-group">
                                    <select class="form-select" name="status_pernikahan">
                                        <option selected disabled>Status Pernikahan</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Sudah Menikah">Sudah Menikah</option>
                                    </select>
                            </div>
                    </div> 
                    <div class="col">
                        <div class="form-floating">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="floatingPassword" required name="password" placeholder="Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label for="floatingPassword">Password</label>
                        </div>
                    </div> 
                </div>
                <div class="row mt-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" type="submit">LAPOR</button>
                </div>
                </div>
                </form> 
            </div>
        <!-- <div class="col-md-3">
            <div class="card border-info mb-3">
            <div class="card-header">Keterangan Cara Daftar Akun</div>
                <div class="card-body">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">An item</li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </div> -->
        </div>
</div>
@endsection