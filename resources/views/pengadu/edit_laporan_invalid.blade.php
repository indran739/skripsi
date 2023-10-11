@extends('layouts.main_pengadu')   
@section('container')
<div class="row mt-2 mb-2">
    <div class="col-sm-6 mb-3">
        <h1 class="ml-3">Form Edit Pengaduan</h1>
                <div class="callout callout-info ml-3">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    Pastikan anda mengisi form pengaduan dengan baik dan benar sesuai dengan tanggapan dari Admin.
                </div>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/berandapengadu">Beranda</a></li>
            <li class="breadcrumb-item active">Form Edit Pengaduan</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->

<div class="col-md-6 ml-3">
@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal update</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- Horizontal Form --> 
<div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Form Edit Pengaduan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="/editlaporaninvalid/{{ $laporan->id }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 70%;" name="id_category_fk" required>
                            @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($laporan->id_category_fk == $category->id) selected @endif>
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
                    <label for="" class="col-sm-3 col-form-label">Isi Laporan</label>
                    <div class="col-sm-9">
                        <textarea class="form-control @error('isi_laporan') is-invalid @enderror" rows="3" placeholder="" name="isi_laporan" value="" required>{{ $laporan->isi_laporan }}</textarea>
                        @error('isi_laporan')
                        <div class="invalid-feedback">
                            {{ $message }}  
                        </div> 
                        @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Lokasi Detail</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="" name="lokasi_kejadian" required value="{{ $laporan->lokasi_kejadian }}">
                        </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Titik MAP</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <div id="map" data-latitude="{{ $laporan->latitude }}" data-longitude="{{ $laporan->longitude }}" style="width: 530px; height: 398px;"></div>

                        </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tanggal Kejadian</label>
                    <div class="col-sm-9">
                        <div class="input-group date" style="width: 35%;" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="tanggal_kejadian"   value="{{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d/m/Y') }}" required data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                  </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">OPD Tujuan</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" style="width: 70%;" name="id_opd_fk" required>
                                @foreach($opds as $opd)
                                    @if($opd->name != 'pengadu')
                                        <option value="{{ $opd->id }}" @if($laporan->id_opd_fk == $opd->id) selected @endif>
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
                        <label for="" class="col-sm-3 col-form-label">Lampiran</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 70%;">
                                <input type="file" class="custom-file-input" id="customFile" name="lampiran">
                                <label class="custom-file-label" for="customFile">{{ pathinfo($laporan->lampiran, PATHINFO_BASENAME) }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foto 1</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 70%;">
                                <input type="file" class="custom-file-input" id="customFile" name="first_image">
                                @if(pathinfo($laporan->first_image, PATHINFO_BASENAME))
                                <label class="custom-file-label" for="customFile">foto_1.jpg</label>
                                @else
                                <label class="custom-file-label" for="customFile"> - </label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Foto 2</label>
                        <div class="col-sm-9">
                            <div class="custom-file" style="width: 70%;">
                                <input type="file" class="custom-file-input" id="customFile" name="sec_image">
                                @if(pathinfo($laporan->sec_image, PATHINFO_BASENAME))
                                <label class="custom-file-label" for="customFile">foto_2.jpg</label>
                                @else
                                <label class="custom-file-label" for="customFile"> - </label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Anonim</label>
                        <div class="col-sm-9 mt-1">
                            <div class="form-group clearfix">
                                <div class="icheck-dark d-inline">
                                    @if($laporan->anonim == 'Y')
                                    <input type="checkbox" id="checkboxPrimary1" name="anonim" value="Y" checked>
                                    @else
                                    <input type="checkbox" id="checkboxPrimary1" name="anonim" value="Y">
                                    @endif
                                    <label for="checkboxPrimary1"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <button class="btn btn-info float-right"><a href="/berandapengadu" style="color:white;">Kembali</a></button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
</div>

<script>

        var latitude = document.getElementById('map').getAttribute('data-latitude');
        var longitude = document.getElementById('map').getAttribute('data-longitude');
        var map = L.map('map').setView([latitude, longitude], 15);
        var marker = L.marker([latitude, longitude]).addTo(map);
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