<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nurse Calling</title>
    <meta name="developer" content="x1901">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
@endif
</head>

<body>
    <div id="app">
        @yield('content')
    </div>
</body>

</html>
<style>

    body {
    background-image: url('../../img/1.jpg'); /* Ganti dengan path gambar rumah sakit */
    background-size: cover;
    background-position: center;
    opacity: 0.9; /* Atur tingkat transparansi agar gambar samar-samar */
}

.grid {
    position: relative; /* Pastikan konten grid tetap muncul di atas background */
}

.bg-white {
    background-color: rgba(255, 255, 255, 0.9); /* Tambahkan transparansi pada konten */
}

</style>
