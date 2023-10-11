    @extends('layouts.main_pengadu')   
    @section('container')
    <!-- Content Header (Page header) -->
    <ol class="breadcrumb float-sm-right mt-2">
        <li class="breadcrumb-item"><a href="/berandapengadu">Beranda</a></li>
    </ol>
    <section class="content-header">
        <h2 class="text-center display-4">Beranda</h2>
    </section>  
    <!-- Main content -->
            <form action="enhanced-results.html">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" value="">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Sort Order:</label>
                                    <select class="select2" style="width: 100%;">
                                        <option selected>ASC</option>
                                        <option>DESC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Order By:</label>
                                    <select class="select2" style="width: 100%;">
                                        <option selected>Kategori</option>
                                        <option>Date</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row mt-3">
            @foreach ($laporans as $laporan)
                <div class="col-md-10 offset-md-1">
                    <div class="list-group">
                        <div class="list-group-item mb-3">
                            <div class="row">
                                <div class="col-auto">
                                    @if($laporan->first_image)
                                    <img class="img-fluid" src="{{ asset('storage/' . $laporan->first_image) }}" alt="Photo" style="max-height: 200px;">
                                    @else
                                    <h4>No <br>Picture</h4>
                                    @endif
                                </div>
                                <div class="col px-4">
                                    <div>
                                        <div class="float-right">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d F Y, H:i') }}</div>
                                        @if($laporan->anonim === 'Y' && $laporan->id_user_fk !== auth()->user()->id)
                                        <h3>Nama Pelapor : Anonim </h3>
                                        @else
                                        <h3>Nama Pelapor : {{ $laporan->user->name }}</h3>
                                        @endif
                                        <p class="mb-2 fw-bold">Kategori : {{ $laporan->category->name }} </p>
                                        <p class="mb-2 fw-bold">Lokasi Kejadian : {{ $laporan->lokasi_kejadian }}</p>
                                        <p class="mb-2 fw-bold">OPD Tujuan : {{ $laporan->opd->name }}</p>
                                        <p class="mb-0 fw-bold">Isi Laporan : {{ Str::limit($laporan->isi_laporan, 50) }}</p>
                                        <button type="button"  class="btn bg-gradient-info mr-2 mt-2" data-toggle="" data-target="">
                                            <i class="fas fa-eye"></i> <a href="/detailpengaduan/{{ $laporan->id }}" style="text-decoration: none; color:white;">Detail</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- Pagination Links -->
            <div class="container col-md-0 offset-md-0 mb-3">
                    {{ $laporans->links('vendor.pagination.adminlte') }}
                </div>
            </div>

@endsection