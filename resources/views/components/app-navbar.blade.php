<div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-body">
        <nav class="h-100 d-flex flex-column justify-content-center">
            @guest
                <div class="mb-3">
                    <a href="/masuk" class="text-dark text-decoration-none">Masuk</a>
                </div>
                <div class="mb-3">
                    <a href="/daftar" class="text-dark text-decoration-none">Daftar</a>
                </div>
            @endguest

            @auth
                <form action="/keluar" method="post" id="logout" class="d-none">
                    @csrf
                </form>

                <div class="mb-3">
                    <a href="{{ route('my-campaigns') }}" class="text-dark text-decoration-none">Galangan Saya</a>
                </div>

                <div class="dropdown">
                    <span role="button" class="dropdown-toggle" id="userOptions" data-bs-toggle="dropdown"
                        aria-expanded="false">Hai, {{ auth()->user()->nama }}</span>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userOptions">
                        <li>
                            <a href="{{ route('profile') }}" class="dropdown-item">Profil Saya</a>
                        </li>
                        <li>
                            <button class="dropdown-item" form="logout">
                                Logout
                            </button>
                        </li>
                    </ul>
                </div>
            @endauth
        </nav>
    </div>
</div>

<header class="app-navbar shadow">
    <div class="container h-100 d-flex justify-content-between align-items-center text-white">
        <div class="d-flex align-items-center justify-content-between w-100 w-lg-auto">
            <h1 class="fs-4 mb-0 me-lg-3">

                <a @if (url()->current() != route('home')) href="{{ route('home') }}" @endif class="text-decoration-none text-white mt-1" style="cursor:pointer;">
                    <img src="/img/Logo.png" alt="" class="bg-white rounded-circle d-inline-block me-lg-2"
                        style="width: 35px; height: 34px;"> <span class="d-none d-lg-inline">BersamaHidup</span>
                </a>
            </h1>
            <div class="dropdown me-lg-3">
                <span role="button" class="dropdown-toggle" id="kategoriDonasi" data-bs-toggle="dropdown"
                    aria-expanded="false">Kategori Donasi</span>
                <ul class="dropdown-menu" aria-labelledby="kategoriDonasi">
                    @foreach ($categories as $category)
                        <li><a class="dropdown-item"
                                href="/campaigns?kategori={{ $category->slug }}">{{ $category->nama }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="d-lg-none">
                <i class="bi bi-list" style="font-size:2rem;" data-bs-toggle="offcanvas" role="button"
                    data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"></i>
            </div>
            <a href="{{ route('campaigns.create') }}" class="navbar-link d-none d-lg-block">Ajukan Galangan</a>
        </div>
        <div class="d-none d-lg-flex align-items-center">
            @guest
                <a href="{{ route('login') }}" class="me-3 navbar-link">Masuk</a>
                <a href="{{ route('register') }}" class="navbar-link">Daftar</a>
            @endguest

            @auth
                <form action="{{ route('logout') }}" method="post" id="logout" class="d-none">
                    @csrf
                </form>

                <a href="{{ route('my-campaigns') }}" class="me-3 navbar-link">Galangan Saya</a>
                <div class="dropdown">
                    <span role="button" class="dropdown-toggle" id="userOptions" data-bs-toggle="dropdown"
                        aria-expanded="false">Hai, {{ auth()->user()->nama }}</span>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userOptions">
                        <li>
                            <a href="{{ route('profile') }}" class="dropdown-item">Profil Saya</a>
                        </li>
                        <li>
                            <button class="dropdown-item" form="logout">
                                Logout
                            </button>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</header>
