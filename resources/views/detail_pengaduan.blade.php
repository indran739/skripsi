@extends('layouts.main')
@section('container')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md">
                    <h5 class="card-title mt-3 ml-3">Judul Laporan : {{ $laporan->judul }}</h5>
                </div>
                <div class="col-md d-flex justify-content-end">
                    <div class="row">
                        <div class="col-sm mt-3">
                            <h5 class="text-muted">ID : {{ $laporan->id }}</h5>
                        </div>
                        <div class="col-sm px-4 mt-3">
                            <p class="text-muted"> {{ $laporan->created_at }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        @if ($laporan->first_image)
                            <img src="{{ asset('storage/' . $laporan->first_image) }}" class='card-img-top'>
                        @else
                            <h1> No Pict </h1>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if ($laporan->sec_image)
                            <img src="{{ asset('storage/' . $laporan->sec_image) }}" class="card-img-top">
                        @else
                            <h1> No Pict </h1>
                        @endif
                    </div>
                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-sm mt-4">
                        <h6>Nama Pelapor : {{ $laporan->user->name }}</h6>
                    </div>
                    <div class="col-sm mt-4">
                        <h6>Lokasi Detail : {{ $laporan->lokasi_kejadian }}</h6>
                    </div>
                    <div class="col-sm mt-4">
                        <h6>OPD Tujuan : {{ $laporan->opd->name }}
                    </div>
                    </h6>
                    <div class="col-sm mt-4">
                        <h6>Kategori : {{ $laporan->category->name }}
                    </div>
                    </h6>
                </div>
            </div>
            <div class="row-md-mt-3">
                <nav class="mb-3 mt-3">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active text-dark fw-bold" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Isi Laporan</button>
                        <button class="nav-link text-dark fw-bold " id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Track Pengaduan</button>
                        <button class="nav-link text-dark fw-bold" id="nav-contact-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                            aria-selected="false">Tanggapan Admin</button>
                    </div>
                </nav>
                <div class="tab-content mb-3 mt-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <p class="card-text">{{ $laporan->isi_laporan }}</p>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row">
                            <h7 class="mb-3 text-muted">Status dan progress pengaduan dapat dilihat di progress bar dibawah
                                ini</h7>
                        </div>
                        <div class="row">
                            <div class="container">
                                <div class="progress" style="height: 30px; font-size:16px">
                                    @if ($laporan->disposisi_opd && $laporan->disposisi_opd == 'Y')
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                            role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0"
                                            aria-valuemax="100">Proses Disposisi</div>
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-default"
                                            role="progressbar" style="width: 15%" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100">Sudah Disposisi</div>
                                    @elseif($laporan->disposisi_opd && $laporan->disposisi_opd == 'N')
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                            role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0"
                                            aria-valuemax="100">Pengaduan di Tolak</div>
                                    @elseif($laporan->disposisi_opd && $laporan->disposisi_opd == 'P')
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-default"
                                            role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0"
                                            aria-valuemax="100">Proses Disposisi</div>
                                    @endif
                                    @if ($laporan->validasi_laporan && $laporan->validasi_laporan == 'Y')
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100">Pengaduan Valid</div>
                                    @elseif($laporan->validasi_laporan && $laporan->validasi_laporan == 'N')
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                            role="progressbar" style="width: 25%" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100">Pengaduan tidak Valid</div>
                                    @elseif($laporan->validasi_laporan && $laporan->validasi_laporan == 'P')
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    @endif
                                    @if ($laporan->proses_tindak && $laporan->tanggal_tindak)
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                            role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100">Tindak Lanjut Pengaduan</div>
                                    @else
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    @endif
                                    @if ($laporan->status_selesai)
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100">Pengaduan Selesai ditindak lanjuti</div>
                                    @else
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                            role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        @foreach ($tanggapans as $tanggapan)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-sm">
                                            <h5>{{ $tanggapan->user->name }}</h5>
                                        </div>
                                        <div class="col-sm d-flex justify-content-end ">
                                            {{ \Carbon\Carbon::parse($tanggapan->created_at)->format('d F Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                    <div class="alert alert-success fw-bold" role="alert">
                                        {{ $tanggapan->tanggapan }}
                                    </div>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row-md-mb-5">
                <a href="/listpengaduan" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
    </div>
@endsection
