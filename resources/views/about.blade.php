@extends('layouts.main_sec')   
@section('container')
<div class="container">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <h1 class="mt-4">Tentang Kami</h1>
    <div class="row">
        <div class="col-sm-7">
            <div id="map" style="width: 650px; height: 398px;"></div>
        </div>
        <div class="col-sm-5">
        <div class="card text-dark bg-light mb-3" style="max-width: 23rem;">
            <div class="card-header fw-bold">Kontak</div>
            <div class="card-body">
                <ol class="list-group list-group">
                    <li class="list-group-item bg-light">Email : inspektorat.kab.gumas@gmail.com</li>
                    <li class="list-group-item bg-light">Tlp / Fax : (0537) 3032783</li>
                    <li class="list-group-item bg-light">Kode Post : 74511</li>
                </ol>
            </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<script>
        var map = L.map('map').setView([-1.101826, 113.866382], 15);

        // Tambahkan layer peta satelit dari Mapbox
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaW5kcmFuNzM5IiwiYSI6ImNsb3R6MTlvaTBnMmgycG9jOWt1dTNhOWMifQ.0i0mle_OpuhkSMCJzoqDRQ', {
            attribution: '© OpenStreetMap contributors, © Mapbox',
            id: 'mapbox/satellite-v9',
            accessToken: 'YOUR_MAPBOX_ACCESS_TOKEN'
        }).addTo(map);

        // Koordinat titik untuk marker
        var markerCoords = [-1.12412755, 113.85758];

        // Buat marker pada titik tersebut
        var marker = L.marker(markerCoords).addTo(map);

        // Popup untuk marker (akan diperbarui setelah mendapatkan alamat)
        updatePopupWithAddress(marker, markerCoords);

        // Memusatkan peta ke titik marker
        map.setView(markerCoords, 30);

        // Fungsi untuk mendapatkan alamat dari koordinat
        function updatePopupWithAddress(marker, coords) {
            // Menggunakan Nominatim untuk mendapatkan alamat
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${coords[0]}&lon=${coords[1]}`)
                .then(response => response.json())
                .then(data => {
                    var address = data.display_name;
                    // Perbarui popup marker dengan alamat lengkap
                    marker.bindPopup("<b>Kantor Inspektorat Kabupaten Gunung Mas</b><br><a href='https://maps.app.goo.gl/BNaAoqnro2vrGnjx8'>Buka Map</a><br>Koordinat: " + coords.join(', ') + "<br>Alamat: " +"VVG5+83C, Jl. Letjend Soeprapto, Tampang Tumbang Anjir, "+ address).openPopup();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection