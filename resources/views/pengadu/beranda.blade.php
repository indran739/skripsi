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
                            <div class="input-group input-group-lg">
                                <input type="search" id="searchTerm" class="form-control form-control-lg" placeholder="Cari berdasarkan isi laporan...">
                            </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Filter By Kategori:</label>
                                    <select class="form-control select2" style="width: 100%;" name="id_category_fk" id="id_category_fk" required>
                                        <option selected="selected">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Filter By OPD:</label>
                                    <select class="form-control filter select2 mr-2" style="width: 100%;" name="id_opd_fk" id="id_opd_fk" required>
                                        <option selected="selected">Pilih OPD</option>
                                    @foreach($opds as $opd)
                                        @if($opd->name != 'pengadu' && $opd->name != 'Inspektorat Kabupaten Gunung Mas')
                                            <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row mt-3" id="bodyRows">
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
            
            
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    $('#searchTerm').on('input', function () {
        var searchTerm = $(this).val();
        $.ajax({
            url: '/search-pengadu', // Ganti dengan URL yang sesuai dengan endpoint pencarian
            method: 'GET',
            data: { searchTerm: searchTerm },
            success: function (data) {
                var results = data.results;
                var tableBody = $('#bodyRows');
                tableBody.empty();

                if (results.length > 0) {
                    $.each(results, function (index, result) {
                        var formattedDate = result.created_at ? new Date(result.created_at).toLocaleDateString('en-GB', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric'
                        }) : '';

                        var row = '<div class="col-md-10 offset-md-1"><div class="list-group"><div class="list-group-item mb-3"><div class="row"><div class="col-auto">';
                        
                        // Tampilkan gambar jika tersedia, jika tidak tampilkan teks "No Picture"
                        if (result.first_image) {
                            row += '<img class="img-fluid" src="{{ asset('storage/') }}' + result.first_image + '" alt="Photo" style="max-height: 200px;">';
                        } else {
                            row += '<h4>No <br>Picture</h4>';
                        }

                        row += '</div><div class="col px-4">';
                        row += '<div class="float-right">' + formattedDate + '</div>';
                        row += '<h3>Nama Pelapor : ' + (result.anonim === 'Y' && result.id_user_fk !== '{{ auth()->user()->id }}' ? 'Anonim' : result.user.name) + '</h3>';
                        row += '<p class="mb-2 fw-bold">Kategori : ' + result.category.name + '</p>';
                        row += '<p class="mb-2 fw-bold">Lokasi Kejadian : ' + result.lokasi_kejadian + '</p>';
                        row += '<p class="mb-2 fw-bold">OPD Tujuan : ' + result.opd.name + '</p>';
                        // isi_laporan diubah menjadi string sebelum substring
                        row += '<p class="mb-0 fw-bold">Isi Laporan : ' + String(result.isi_laporan).substring(0, 50) + '</p>';
                        row += '<button type="button" class="btn bg-gradient-info mr-2 mt-2"><i class="fas fa-eye"></i> <a href="/detailpengaduan/' + result.id + '" style="text-decoration: none; color:white;">Detail</a></button>';
                        row += '</div></div></div></div></div>';

                        tableBody.append(row);
                    });
                } else {
                    var noData = '<div class="col-md-10 offset-md-1"><div class="list-group-item mb-3"><div class="row"><div class="col text-center">No Data</div></div></div></div>';
                    tableBody.append(noData);
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
});
</script>


@endsection