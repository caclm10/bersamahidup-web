<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', '')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BersamaHidup')</title>

    @if (env('APP_ENV') == 'production')
        <link rel="stylesheet" href="/css/app.css">
        <script src="/js/app.js"></script>
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}"></script>
    @endif
</head>

<body class="min-vh-100 d-flex flex-column">
    <div class="position-fixed top-0 bottom-0 start-0 end-0 bg-white bg-opacity-25" id="fullLoadingBox"
        style="z-index: 9999; display: none;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <x-app-navbar />

    {{-- Hero --}}
    @if (isset($useHero) && $useHero)
        <div class="vh-100 bg-primary text-white position-relative d-flex mb-5">
            <img src="/img/hero.jpg" alt="Hero Image" class="position-absolute top-0 left-0 w-100 h-100">

            <div class="my-auto flex-grow-1 position-relative">
                <div class="container d-flex justify-content-between align-items-center">
                    <div style="max-width:600px; text-align:justify">
                        <h2 class="mb-4" style="max-width:400px">Beramal Mudah Melalui BersamaHidup</h2>

                        <p class="text-light mb-4">
                            Temukan cara lebih praktis untuk ber’amal tanpa batas jarak yang lebih mudah di zaman
                            digital sekarang di manapun dan kapanpun. Untuk hidup saling membantu dan mengasihi.
                        </p>

                        <div class="row g-3">
                            <div class="col-12 col-lg d-grid">
                                <a href="{{ route('campaigns.create') }}"
                                    class="btn rounded-pill me-0 me-lg-3 px-4 shadow " id="heroAjukanDonasi">Ajukan
                                    Galangan</a>
                            </div>
                            <div class="col-12 col-lg d-grid">
                                <button id="donasi-disini" class="btn btn-lg btn-primary rounded-pill px-4 shadow"
                                    style="font-size:16px;">Donasi di
                                    sini</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center d-none d-md-block">
                        <img src="/img/Logo.png" alt="logo" style="width:350px; height:350px;">
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="h-navbar"></div>
        @yield('top')
        <div class="mb-5"></div>
    @endif
    {{-- End of Hero --}}

    <main class="mb-8 container">
        @yield('content')
    </main>


    <footer class="flex-grow-1 d-flex flex-column justify-content-end">
        <div class="container mb-3">
            <div style="max-width:370px; text-align:justify">
                <h4 class="text-primary fw-2">BersamaHidup <img src="/img/Logo.png" alt="logo"
                        style="width:32px; height:32px;"></h4>
                <p>
                    BersamaHidup adalah sebuah situs web yang mana dibuat untuk meng-inspirasi semua orang untuk saling
                    membantu ber-amal di mana pun dan kapan pun tanpa memikirkan susah nya jarak yang dapat di tempuh.
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-center mb-2">
            <svg viewBox="1.001 122.032 32 32" width="32" height="32" class="me-5">
                <defs>
                    <radialGradient id="c" cx="158.429" cy="578.088" r="65" gradientUnits="userSpaceOnUse"
                        gradientTransform="matrix(0, -0.487903, 0.453778, 0, -252.823074, 233.794252)" xlink:href="#a">
                    </radialGradient>
                    <linearGradient id="a">
                        <stop offset="0" stop-color="#fd5"></stop>
                        <stop offset="0.1" stop-color="#fd5"></stop>
                        <stop offset="0.5" stop-color="#ff543e"></stop>
                        <stop offset="1" stop-color="#c837ab"></stop>
                    </linearGradient>
                    <radialGradient id="d" cx="147.694" cy="473.455" r="65" gradientUnits="userSpaceOnUse"
                        gradientTransform="matrix(0.042807, 0.21385, -0.881468, 0.176548, 406.654846, 9.166199)"
                        xlink:href="#b"></radialGradient>
                    <linearGradient id="b">
                        <stop offset="0" stop-color="#3771c8"></stop>
                        <stop stop-color="#3771c8" offset="0.128"></stop>
                        <stop offset="1" stop-color="#60f" stop-opacity="0"></stop>
                    </linearGradient>
                </defs>
                <path fill="url(#c)"
                    d="M 17.004 122.032 C 10.325 122.032 8.372 122.039 7.994 122.071 C 6.622 122.186 5.768 122.4 4.84 122.864 C 4.124 123.218 3.559 123.633 3.002 124.211 C 1.986 125.265 1.371 126.562 1.149 128.102 C 1.039 128.852 1.008 129.002 1.002 132.825 C 0.999 134.1 1.002 135.776 1.002 138.027 C 1.002 144.704 1.008 146.655 1.043 147.033 C 1.152 148.369 1.361 149.205 1.805 150.124 C 2.649 151.881 4.268 153.203 6.171 153.696 C 6.831 153.864 7.559 153.957 8.497 154.003 C 8.891 154.021 12.932 154.032 16.97 154.032 C 21.011 154.032 25.052 154.028 25.44 154.007 C 26.521 153.957 27.15 153.871 27.847 153.693 C 29.763 153.196 31.35 151.896 32.213 150.116 C 32.647 149.22 32.869 148.348 32.969 147.083 C 32.991 146.808 33.001 142.41 33.001 138.023 C 33.001 133.632 32.988 129.242 32.969 128.966 C 32.866 127.684 32.647 126.819 32.197 125.905 C 31.832 125.158 31.422 124.601 30.828 124.029 C 29.772 123.018 28.475 122.4 26.934 122.178 C 26.187 122.071 26.037 122.039 22.211 122.032 L 17.004 122.032 Z"
                    style=""></path>
                <path fill="url(#d)"
                    d="M 17.004 122.032 C 10.325 122.032 8.372 122.039 7.994 122.071 C 6.622 122.186 5.768 122.4 4.84 122.864 C 4.124 123.218 3.559 123.633 3.002 124.211 C 1.986 125.265 1.371 126.562 1.149 128.102 C 1.039 128.852 1.008 129.002 1.002 132.825 C 0.999 134.1 1.002 135.776 1.002 138.027 C 1.002 144.704 1.008 146.655 1.043 147.033 C 1.152 148.369 1.361 149.205 1.805 150.124 C 2.649 151.881 4.268 153.203 6.171 153.696 C 6.831 153.864 7.559 153.957 8.497 154.003 C 8.891 154.021 12.932 154.032 16.97 154.032 C 21.011 154.032 25.052 154.028 25.44 154.007 C 26.521 153.957 27.15 153.871 27.847 153.693 C 29.763 153.196 31.35 151.896 32.213 150.116 C 32.647 149.22 32.869 148.348 32.969 147.083 C 32.991 146.808 33.001 142.41 33.001 138.023 C 33.001 133.632 32.988 129.242 32.969 128.966 C 32.866 127.684 32.647 126.819 32.197 125.905 C 31.832 125.158 31.422 124.601 30.828 124.029 C 29.772 123.018 28.475 122.4 26.934 122.178 C 26.187 122.071 26.037 122.039 22.211 122.032 L 17.004 122.032 Z"
                    style=""></path>
                <path fill="#fff"
                    d="M 16.998 126.219 C 13.791 126.219 13.388 126.23 12.129 126.291 C 10.869 126.348 10.01 126.544 9.259 126.837 C 8.484 127.141 7.825 127.545 7.169 128.202 C 6.512 128.856 6.106 129.517 5.806 130.292 C 5.512 131.046 5.312 131.903 5.256 133.161 C 5.199 134.422 5.184 134.826 5.184 138.034 C 5.184 141.242 5.199 141.646 5.256 142.903 C 5.312 144.161 5.512 145.022 5.806 145.772 C 6.106 146.551 6.509 147.208 7.165 147.866 C 7.822 148.523 8.481 148.927 9.259 149.23 C 10.01 149.52 10.869 149.72 12.126 149.777 C 13.385 149.834 13.788 149.848 16.995 149.848 C 20.205 149.848 20.605 149.834 21.868 149.777 C 23.124 149.72 23.984 149.52 24.734 149.23 C 25.512 148.927 26.168 148.523 26.825 147.866 C 27.484 147.208 27.887 146.551 28.19 145.772 C 28.481 145.022 28.678 144.161 28.737 142.907 C 28.794 141.646 28.809 141.242 28.809 138.034 C 28.809 134.826 28.794 134.422 28.737 133.161 C 28.678 131.903 28.481 131.046 28.19 130.295 C 27.887 129.517 27.484 128.856 26.825 128.202 C 26.168 127.545 25.512 127.141 24.734 126.837 C 23.98 126.544 23.121 126.348 21.864 126.291 C 20.605 126.23 20.205 126.219 16.995 126.219 Z M 15.939 128.348 C 16.254 128.348 16.604 128.348 16.998 128.348 C 20.152 128.348 20.527 128.359 21.771 128.416 C 22.924 128.466 23.549 128.659 23.965 128.824 C 24.515 129.034 24.909 129.292 25.321 129.706 C 25.737 130.12 25.99 130.513 26.206 131.064 C 26.368 131.482 26.559 132.107 26.612 133.257 C 26.668 134.504 26.681 134.879 26.681 138.03 C 26.681 141.185 26.668 141.56 26.612 142.803 C 26.559 143.957 26.368 144.582 26.206 144.997 C 25.99 145.547 25.737 145.944 25.321 146.354 C 24.909 146.769 24.515 147.026 23.965 147.24 C 23.549 147.401 22.924 147.594 21.771 147.644 C 20.527 147.701 20.152 147.716 16.998 147.716 C 13.845 147.716 13.469 147.701 12.226 147.644 C 11.072 147.594 10.447 147.401 10.031 147.24 C 9.478 147.023 9.088 146.769 8.672 146.354 C 8.259 145.94 8.003 145.547 7.787 144.997 C 7.628 144.582 7.434 143.954 7.381 142.803 C 7.325 141.556 7.312 141.185 7.312 138.027 C 7.312 134.872 7.325 134.5 7.381 133.254 C 7.434 132.103 7.628 131.478 7.787 131.06 C 8.003 130.51 8.259 130.117 8.672 129.702 C 9.088 129.288 9.478 129.031 10.031 128.816 C 10.447 128.656 11.072 128.463 12.226 128.409 C 13.313 128.363 13.735 128.348 15.939 128.345 Z M 23.302 130.31 C 22.521 130.31 21.886 130.942 21.886 131.728 C 21.886 132.511 22.521 133.143 23.302 133.143 C 24.087 133.143 24.721 132.511 24.721 131.728 C 24.721 130.942 24.087 130.31 23.302 130.31 Z M 16.998 131.964 C 13.648 131.964 10.932 134.683 10.932 138.034 C 10.932 141.385 13.648 144.1 16.998 144.1 C 20.349 144.1 23.062 141.385 23.062 138.034 C 23.062 134.683 20.349 131.964 16.998 131.964 Z M 16.998 134.093 C 19.173 134.093 20.936 135.858 20.936 138.034 C 20.936 140.21 19.173 141.971 16.998 141.971 C 14.823 141.971 13.06 140.21 13.06 138.034 C 13.06 135.858 14.823 134.093 16.998 134.093 Z"
                    style=""></path>
            </svg>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                <title>tiktok</title>
                <path
                    d="M16.708 0.027c1.745-0.027 3.48-0.011 5.213-0.027 0.105 2.041 0.839 4.12 2.333 5.563 1.491 1.479 3.6 2.156 5.652 2.385v5.369c-1.923-0.063-3.855-0.463-5.6-1.291-0.76-0.344-1.468-0.787-2.161-1.24-0.009 3.896 0.016 7.787-0.025 11.667-0.104 1.864-0.719 3.719-1.803 5.255-1.744 2.557-4.771 4.224-7.88 4.276-1.907 0.109-3.812-0.411-5.437-1.369-2.693-1.588-4.588-4.495-4.864-7.615-0.032-0.667-0.043-1.333-0.016-1.984 0.24-2.537 1.495-4.964 3.443-6.615 2.208-1.923 5.301-2.839 8.197-2.297 0.027 1.975-0.052 3.948-0.052 5.923-1.323-0.428-2.869-0.308-4.025 0.495-0.844 0.547-1.485 1.385-1.819 2.333-0.276 0.676-0.197 1.427-0.181 2.145 0.317 2.188 2.421 4.027 4.667 3.828 1.489-0.016 2.916-0.88 3.692-2.145 0.251-0.443 0.532-0.896 0.547-1.417 0.131-2.385 0.079-4.76 0.095-7.145 0.011-5.375-0.016-10.735 0.025-16.093z">
                </path>
            </svg>
        </div>
        <div class="bg-primary py-1 text-center text-white">
            © 2021 BersamaHidup.com | All Right Reserved
        </div>
    </footer>

    @stack('script')
</body>

</html>
