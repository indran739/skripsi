@extends('layouts.main')
@section('container')
    <h1 class='mt-5 mb-3 text-center'>List Pengaduan</h1>
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <form action="/posts">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search" value="">
                    <button class="btn text-white" style="background-color:#4030A3;" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach ($laporans as $laporan)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class='position-absolute px-3 py-2 text-white' style='background-color: rgba(0,0,0,0.7)'><a
                                href="" class='text-white text-decoration-none'>{{ $laporan->category->name }}</a>
                        </div>
                        @if ($laporan->first_image)
                            <img src="{{ asset('storage/' . $laporan->first_image) }}" class='card-img-top'>
                        @else
                            <img src="https://source.unsplash.com/500x400?{{ $laporan->category->name }}"
                                class="card-img-top" alt="$laporan->category->name">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $laporan->judul }}</h5>
                            <!-- @if ($laporan->disposisi_opd == 'Y')
                                    @if ($laporan->disposisi_opd == 'Y' && $laporan->validasi_laporan == 'Y')
                                    <h6 class="card-title">Status : Sampai Ke OPD dan Sudah di Validasi </h6>
                                @else
                                    <h6 class="card-title">Status : Sampai Ke OPD </h6>
                                    @endif
                                @else
                                    <h6 class="card-title">Status : Pending </h6>s
                                    @endif -->
                            <p>
                                <small class="text-muted">
                                    By. {{ $laporan->user->name }} {{ $laporan->created_at->diffForHumans() }}
                                </small>
                            </p>
                            <a href="/detailpengaduan/{{ $laporan->id }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
