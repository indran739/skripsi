<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-color: white; /* Warna latar belakang halaman */
        }

        .header {
            background-color: white; /* Warna header */
            color: black;
            width: 100%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo img {
            height: 90px;
            width: 75px;
        }

        .header h2,
        .header h3 {
            margin: 2px;
        }

        .info {
            width: 100%;
        }

        .info p {
            margin: 0px;
        }

        .title {
            margin-top:20px;
            width: 100%;
        }
        
        .title h2 {
            margin: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        div.border {

        width: 100%; /* Misalnya, elemen akan memiliki lebar 90% dari lebar parent */
        margin: 0 auto; /* 0 atas dan bawah, auto pada kiri dan kanan untuk membuat elemen berada di tengah */
        display: flex;
        justify-content: center; /* Mengatur konten menjadi di tengah secara horizontal */
        align-items: center; /* Mengatur konten menjadi di tengah secara vertikal */
        border: 2px solid black;

        }


    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="gumas.jpg" alt="Logo">
        </div>
        <h2>PEMERINTAH KABUPATEN GUNUNG MAS</h2>
        <h3>INSPEKTORAT KABUPATEN GUNUNG MAS</h3>
    </div>
    <div class="info">
        <p>Jalan Pangeran Diponegoro Nomor 02 Kuala Kurun 74511.</p>
        <p>Telp/Fax (0537) 3032846</p>
        <p>Email: inspektorat@gunungmaskab.go.id Website: www.inspektorat.gunungmaskab.go.id</p>
    </div>
    <div class="border"></div>
    <div class="title">
        <h2>Laporan Kinerja OPD</h2>
    </div>
    <table>
        <thead>
            <tr> 
                <th style="width: 50px;">No</th>
                <th style="width: 150px;text-align: center;">Nama OPD</th>
                <th style="width: 150px;text-align: center;">Total Pengaduan <br>Belum ditindak</th>
                <th style="width: 150px;text-align: center;">Total Pengaduan <br>Sedang ditindak</th>
                <th style="width: 150px;text-align: center;">Total Pengaduan <br>Selesai</th>
                <th style="width: 150px;text-align: center;">Rata-rata waktu penyelesaian <br>(Jam)</th>
                <th style="width: 150px;text-align: center;">Rata-rata waktu respon <br>(Jam)</th>
                
            </tr>
        </thead>
        <tbody>
            @php $count = 1 @endphp
            @if(count($opdAverages) > 0)
            @foreach($opdAverages as $index => $opdAverage)
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $opdAverage['opd_name'] }}</td>
                <td style="text-align: right;">{{ $opdAverage['count_laporan_belum'] }}</td>
                <td style="text-align: right;">{{ $opdAverage['count_laporan_ditindak'] }}</td>
                <td style="text-align: right;">{{ $opdAverage['count_laporan_selesai'] }}</td>
                <td style="text-align: right;">{{ $opdAverage['average_duration'] }}</td>
                <td style="text-align: right;">{{ $opdAverage['rataRataWaktuRespon'] }}</td>
            </tr>
            @endforeach
            @else
            <tr> <td colspan="8" style="text-align: center;">No Data</td> </tr>
            @endif
        </tbody>
    </table>
</body>

</html>
