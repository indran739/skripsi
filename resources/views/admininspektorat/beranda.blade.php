<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ini halaman beranda admin inspektorat</h1>
    <h3> {{ auth()->user()->name }}  </h3>
        <form action="/logout" method="post">
            @csrf
            <button type="submit" class="dropdown-item"><i class=""></i> Logout</button>
        </form>
                    <p>ID: {{ $data->id }}</p>
                  <p>Nama: {{ $data->lokasi_kejadian }}</p>
</body>
</html>