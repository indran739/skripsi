@extends('layouts.main_pengadu')   
@section('container')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<div class="row mt-2 mb-2">
    <div class="col-sm-6 mb-3">
        <h1 class="ml-3">Form Pengaduan</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/berandapengadu">Beranda</a></li>
            <li class="breadcrumb-item active">Form Pengaduan</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->

<div class="col-md-12">

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Laporan Pengaduan Berhasil dikirim!</strong> <br>Anda dapat Menunggu Validasi dan Tindak Lanjut dari Admin Instansi.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Laporan Pengaduan Gagal dikirim!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Form Pengaduan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            <div class="row">
                    <form  method="post" action="/store" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10" >
                                    <select class="form-control select2" style="width: 30%;" name="id_category_fk" required>
                                        <option selected="selected">Pilih Kategori Pengaduan</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('id_category_fk') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_category_fk')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Isi Laporan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('isi_laporan') is-invalid @enderror" rows="3" placeholder=""  style="width: 100%;" name="isi_laporan" value="{{ old('isi_laporan') }}" required></textarea>
                                @error('isi_laporan')
                                <div class="invalid-feedback">
                                    {{ $message }}  
                                </div> 
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Kecamatan</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" required autocomplete="id_kecamatan_fk" style="width: 30%;" name="id_kecamatan_fk">
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
                            <label for="" class="col-sm-2 col-form-label">Kelurahan/Desa</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2 @error('id_desa_fk') is-invalid @enderror" required autocomplete="id_desa_fk" style="width: 30%;" name="id_desa_fk">
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
                            <label for="" class="col-sm-2 col-form-label">Lokasi Detail</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="" name="lokasi_kejadian"  style="width: 100%;" required value="{{ old('lokasi_kejadian') }}">
                                </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Titik MAP</label>
                                <div class="col-sm-9">
                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">
                                    <div id="map" style="width: 530px; height: 398px;"></div>
                                </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Tanggal Kejadian</label>
                            <div class="col-sm-10">
                                <div class="input-group date" style="width: 30%;" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="tanggal_kejadian"   required data-target="#reservationdate"/>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">OPD Tujuan</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" style="width: 30%;" name="id_opd_fk" required>
                                        <option selected="selected">Pilih OPD Tujuan</option>
                                        @foreach($opds as $opd)
                                            @if($opd->name != 'pengadu' && $opd->name != 'Inspektorat Kabupaten Gunung Mas')
                                                <option value="{{ $opd->id }}" {{ old('id_opd_fk') == $opd->id ? 'selected' : '' }}>
                                                    {{ $opd->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('id_opd_fk')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                        </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Lampiran</label>
                                <div class="col-sm-10">
                                    <div class="custom-file" style="width: 15%;">
                                        <input type="file" class="custom-file-input" id="customFile" name="lampiran">
                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Foto 1</label>
                                <div class="col-sm-10">
                                    <div class="custom-file" style="width: 15%;">
                                        <input type="file" class="custom-file-input" id="customFile" name="first_image">
                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Foto 2</label>
                                <div class="col-sm-10">
                                    <div class="custom-file" style="width: 15%;">
                                        <input type="file" class="custom-file-input" id="customFile" name="sec_image">
                                        <label class="custom-file-label" for="customFile">Choose File</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Anonim</label>
                                <div class="col-sm-10 mt-1">
                                    <div class="form-group clearfix">
                                        <div class="icheck-dark d-inline">
                                            <input type="checkbox" id="checkboxPrimary1" name="anonim" value="Y">
                                            <label for="checkboxPrimary1"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-start">
                            <button type="submit" style="width:100px;" class="btn btn-success">Submit</button>  
                        </div>
                        <!-- /.card-footer -->
                    </form>
            </div>
             
            </div>
            <!-- /.card -->
</div>

<script>
        var map = L.map('map').setView([-1.101826, 113.866382], 15);
        var marker;
        var popup = L.popup();

        function onMapClick(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Mengisi nilai input fields tersembunyi dengan latitude dan longitude
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Hapus marker yang ada (jika ada)
            if (marker) {
                map.removeLayer(marker);
            }

            // Tambahkan marker baru di lokasi yang diklik
            marker = L.marker([lat, lng]).addTo(map);

            // Menggunakan Nominatim untuk mendapatkan alamat dari koordinat
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    var address = data.display_name;

                    popup
                        .setLatLng(e.latlng)
                        .setContent("Alamat: " + address + "<br>" + "<br>" + " Latitude: " + lat + "<br>" + " Longitude: " + lng)
                        .openOn(map);
                });
        }

        map.on('click', onMapClick);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
    </script>
@endsection