<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (url()->current() == route('login'))
        <meta name="description"
            content="BersamaHidup - Masuk dengan akun yang sudah didaftarkan untuk mengajukan galangan. Ayo terus bantu siapapun demi kebaikan bersama">
    @else
        <meta name="description"
            content="BersamaHidup - Daftar akunmu di sini sekarang juga. Mari memulai kebaikan dengan membuka galangan kepada mereka yang membutuhkan.">
    @endif
    <title>
        BersamaHidup - {{ url()->current() == route('login') ? 'Masuk' : 'Daftar' }}
    </title>

    @if (env('APP_ENV') == 'production')
        <link rel="stylesheet" href="/css/app.css">
        <script src="/js/app.js"></script>
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}"></script>
    @endif
</head>

<body class="bg-secondary bg-opacity-30">
    <x-app-navbar />
    <div class="h-navbar"></div>

    <div class="my-7">
        <h1 class="fst-italic text-center text-primary mb-3">BersamaHidup</h1>
        <div class="mx-auto w-100 mw-sm card rounded-3 shadow">
            <div class="card-body">
                <h2 class="card-title fs-3 text-center mb-4">@yield('title')</h2>

                @yield('form')
            </div>
        </div>
    </div>

    {{-- <div class="vh-100 d-flex justify-content-center py-7">
        <div class="w-100 mw-sm card rounded-3 shadow">
            <div class="card-body">
                <h1 class="card-title fs-3 text-center">Daftar</h1>
            </div>
        </div>
    </div> --}}


</body>

</html>
