@extends('layouts.main_opd')
@section('container')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Detail Pengaduan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img" style="height:300px; width:200px" src="{{ asset('storage/' . $data->foto_wajah) }}"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $data->name }}</h3>
                            <p class="text-muted text-center">Pengadu/Pelapor</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>NIK</b> <a class="float-right">{{ $data->nik }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tempat Lahir</b> <a class="float-right">{{ $data->tempat_lahir }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tanggal Lahir</b> <a class="float-right">{{ $data->tanggal_lahir }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Jenis Kelamin</b> <a class="float-right">{{ $data->jenis_kelamin }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Agama</b> <a class="float-right">{{ $data->agama }}</a>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About User</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Pekerjaan</strong>
                            <p class="text-muted">
                                {{ $data->pekerjaan }}
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i>
                                Alamat</strong>
                            <p class="text-muted">{{ $data->alamat }}</p>
                            <hr>
                            <strong><i class="fas fa-phone-alt mr-1"></i>Kontak</strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">{{ $data->no_hp }} /
                                </span>
                                <span class="tag tag-success">{{ $data->email }}</span>
                            </p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Golongan
                                Darah</strong>
                            <p class="text-muted">{{ $data->gol_darah }}</p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Status
                                Pernikahan</strong>
                            <p class="text-muted">{{ $data->status_pernikahan }}</p>
                        </div>

                    </div>

                </div>
    </section>
@endsection
