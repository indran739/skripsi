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
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                            <div class="input-group input-group-lg">
                                <input type="search" id="searchTerm" class="form-control form-control-lg" placeholder="Cari berdasarkan isi laporan...">
                            </div>
                        <div class="row mt-3">
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Filter By Kategori:</label>
                                    <select class="form-control select2" id="categoryFilter" style="width: 100%;" name="id_category_fk" id="id_category_fk" required>
                                        <option selected="selected">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Filter By OPD:</label>
                                    <select class="form-control filter select2 mr-2" id="opdFilter" style="width: 100%;" name="id_opd_fk" id="id_opd_fk" required>
                                        <option selected="selected">Pilih OPD</option>
                                    @foreach($opds as $opd)
                                        @if($opd->name != 'pengadu' && $opd->name != 'Inspektorat Kabupaten Gunung Mas')
                                            <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group" style="margin-top:32px;">
                                    <button class="btn bg-gradient-info ">
                                        <a href="/berandapengadu"  style="text-decoration: none; color:white;"><i class="fas fa-reset"></i>Reset</a> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <!-- <div class="float-right">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d F Y, H:i') }}</div> -->
                                        <dl class="row">
                                            <dt class="col-sm-2 mb-1 pl-0">Kategori</dt>
                                            <dd class="col-sm-10 mb-1"><span>:</span> {{ $laporan->category->name }}</dd>
                                            
                                            <dt class="col-sm-2 mb-1 pl-0">OPD Tujuan</dt>
                                            <dd class="col-sm-10 mb-1"><span>:</span> {{ $laporan->opd->name }}</dd>
                                                                                        
                                            <dt class="col-sm-2 pl-0">Detail Lokasi</dt>
                                            <dd class="col-sm-10"><span>:</span> {{ $laporan->lokasi_kejadian }}</dd>

                                            <dt class="col-sm-2 mb-1 pl-0">Tanggal Lapor</dt>
                                            <dd class="col-sm-10 mb-1"><span>:</span> {{ \Carbon\Carbon::parse($laporan->tanggal_lapor)->format('d F Y, H:i') }}</dd>
                                            
                                            <dt class="col-sm-2 pl-0">Isi Laporan</dt>
                                            <dd class="col-sm-10"><span>:</span> {{ $laporan->isi_laporan }}</dd>
                                        </dl>
                                        <button type="button"  class="btn bg-gradient-info mr-2" data-toggle="" data-target="">
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
            url: '/search-pengadu',
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

                        var row = '<div class="col-md-10 offset-md-1">' +
                            '<div class="list-group">' +
                            '<div class="list-group-item mb-3">' +
                            '<div class="row">' +
                            '<div class="col-auto">';

                        row += result.first_image ? '<img class="img-fluid" src="{{ asset('storage/') }}' + result.first_image + '" alt="Photo" style="max-height: 200px;">' : '<h4>No <br>Picture</h4>';

                        row += '</div>' +
                            '<div class="col px-4">' +
                            '<div>' +
                            '<dl class="row">' +
                            '<dt class="col-sm-2 mb-1 pl-0">Kategori</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + result.category.name + '</dd>' +
                            '<dt class="col-sm-2 mb-1 pl-0">OPD Tujuan</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + result.opd.name + '</dd>' +
                            '<dt class="col-sm-2 pl-0">Detail Lokasi</dt>' +
                            '<dd class="col-sm-10"><span>:</span> ' + result.lokasi_kejadian + '</dd>' +
                            '<dt class="col-sm-2 mb-1 pl-0">Tanggal Lapor</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + formattedDate + '</dd>' +
                            '<dt class="col-sm-2 pl-0">Isi Laporan</dt>' +
                            '<dd class="col-sm-10"><span>:</span> ' + String(result.isi_laporan).substring(0, 50) + '</dd>' +
                            '</dl>' +
                            '<button type="button" class="btn bg-gradient-info mr-2">' +
                            '<i class="fas fa-eye"></i> <a href="/detailpengaduan/' + result.id + '" style="text-decoration: none; color:white;">Detail</a>' +
                            '</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        tableBody.append(row);

                    });
                } else {
                    var noData = `
                        <div class="col-md-10 offset-md-1">
                            <div class="list-group-item mb-3">
                                <div class="row">
                                    <div class="col text-center">No Data</div>
                                </div>
                            </div>
                        </div>
                    `;
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


<script>
$(document).ready(function () {
    $('#opdFilter').on('change', function () {
        var selectedOpd = $(this).val();
        $.ajax({
            url: '/search-pengadu', // Ganti dengan URL yang sesuai dengan endpoint pencarian
            method: 'GET',
            data: { opd: selectedOpd }, // Kirim data kategori yang dipilih
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

                        var row = '<div class="col-md-10 offset-md-1">' +
                            '<div class="list-group">' +
                            '<div class="list-group-item mb-3">' +
                            '<div class="row">' +
                            '<div class="col-auto">';

                        row += result.first_image ? '<img class="img-fluid" src="{{ asset('storage/') }}' + result.first_image + '" alt="Photo" style="max-height: 200px;">' : '<h4>No <br>Picture</h4>';

                        row += '</div>' +
                            '<div class="col px-4">' +
                            '<div>' +
                            '<dl class="row">' +
                            '<dt class="col-sm-2 mb-1 pl-0">Kategori</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + result.category.name + '</dd>' +
                            '<dt class="col-sm-2 mb-1 pl-0">OPD Tujuan</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + result.opd.name + '</dd>' +
                            '<dt class="col-sm-2 pl-0">Detail Lokasi</dt>' +
                            '<dd class="col-sm-10"><span>:</span> ' + result.lokasi_kejadian + '</dd>' +
                            '<dt class="col-sm-2 mb-1 pl-0">Tanggal Lapor</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + formattedDate + '</dd>' +
                            '<dt class="col-sm-2 pl-0">Isi Laporan</dt>' +
                            '<dd class="col-sm-10"><span>:</span> ' + String(result.isi_laporan).substring(0, 50) + '</dd>' +
                            '</dl>' +
                            '<button type="button" class="btn bg-gradient-info mr-2">' +
                            '<i class="fas fa-eye"></i> <a href="/detailpengaduan/' + result.id + '" style="text-decoration: none; color:white;">Detail</a>' +
                            '</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        tableBody.append(row);

                    });
                } else {
                    var noData = `
                        <div class="col-md-10 offset-md-1">
                            <div class="list-group-item mb-3">
                                <div class="row">
                                    <div class="col text-center">No Data</div>
                                </div>
                            </div>
                        </div>
                    `;
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

<script>
$(document).ready(function () {
    $('#categoryFilter').on('change', function () {
        var selectedCategory = $(this).val();
        $.ajax({
            url: '/search-pengadu', // Ganti dengan URL yang sesuai dengan endpoint pencarian
            method: 'GET',
            data: { category: selectedCategory }, // Kirim data kategori yang dipilih
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

                        var row = '<div class="col-md-10 offset-md-1">' +
                            '<div class="list-group">' +
                            '<div class="list-group-item mb-3">' +
                            '<div class="row">' +
                            '<div class="col-auto">';

                        row += result.first_image ? '<img class="img-fluid" src="{{ asset('storage/') }}' + result.first_image + '" alt="Photo" style="max-height: 200px;">' : '<h4>No <br>Picture</h4>';

                        row += '</div>' +
                            '<div class="col px-4">' +
                            '<div>' +
                            '<dl class="row">' +
                            '<dt class="col-sm-2 mb-1 pl-0">Kategori</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + result.category.name + '</dd>' +
                            '<dt class="col-sm-2 mb-1 pl-0">OPD Tujuan</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + result.opd.name + '</dd>' +
                            '<dt class="col-sm-2 pl-0">Detail Lokasi</dt>' +
                            '<dd class="col-sm-10"><span>:</span> ' + result.lokasi_kejadian + '</dd>' +
                            '<dt class="col-sm-2 mb-1 pl-0">Tanggal Lapor</dt>' +
                            '<dd class="col-sm-10 mb-1"><span>:</span> ' + formattedDate + '</dd>' +
                            '<dt class="col-sm-2 pl-0">Isi Laporan</dt>' +
                            '<dd class="col-sm-10"><span>:</span> ' + String(result.isi_laporan).substring(0, 50) + '</dd>' +
                            '</dl>' +
                            '<button type="button" class="btn bg-gradient-info mr-2">' +
                            '<i class="fas fa-eye"></i> <a href="/detailpengaduan/' + result.id + '" style="text-decoration: none; color:white;">Detail</a>' +
                            '</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        tableBody.append(row);

                    });
                } else {
                    var noData = `
                        <div class="col-md-10 offset-md-1">
                            <div class="list-group-item mb-3">
                                <div class="row">
                                    <div class="col text-center">No Data</div>
                                </div>
                            </div>
                        </div>
                    `;
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