<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- <link href="https://fonts.cdnfonts.com/css/alander" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/futura-md-bt" rel="stylesheet"> --}}
    <link href="//db.onlinewebfonts.com/c/a2f52fd2257ee7ab605c7b34b72cf70a?family=Alander" rel="stylesheet" type="text/css"/>
    <link href="//db.onlinewebfonts.com/c/e55e9079ee863276569c8a68d776ef04?family=Futura+Md+BT" rel="stylesheet" type="text/css"/>
    <!-- Index -->
    <link rel="stylesheet" href="{{ url('css/index.css') }}">
    <!-- Fontawesome-->
    <script src="https://kit.fontawesome.com/d003a54dde.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <title>@yield('title')</title>
</head>
<body>
<nav class="unselectable navbar p-1 pt-0">
    <div class="row container-fluid pt-1">
        <a class="navbar ps-4" href="/home" style="max-width: 15%;">
            <img src="{{url('storage/reztya_logo.png')}}" data-toggle="tooltip" title="Home" style="max-width: 80%;">
        </a>
        @auth
            @if(auth()->user()->user_role_id == 1)
                <div class="col-1 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/view-services">
                        Perawatan
                    </a>
                </div>
                <div class="col-1 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/view-products">
                        Produk
                    </a>
                </div>
                <div class="col-4 mt-2">
                    <div class="row align-items-start">
                        <div class="font-futura-reztya text-reztya dropdown">
                            <p class="fs-6 dropdown-toggle" type="button" id="dropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Kelola
                            </p>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                <li><a class="button-outline-reztya dropdown-item" href="/manage-services">Kelola Perawatan</a></li>
                                <li><a class="button-outline-reztya dropdown-item" href="/manage-schedules">Kelola Jadwal</a></li>
                                <li><a class="button-outline-reztya dropdown-item" href="/manage-products">Kelola Produk</a></li>
                                <li><a class="button-outline-reztya dropdown-item" href="/manage-categories">Kelola Kategori</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-1 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/view-services">
                        Perawatan
                    </a>
                </div>
                <div class="col-1 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/view-products">
                        Produk
                    </a>
                </div>
                <div class="col-4 mb-2">
                    <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/about-us">
                        Tentang Kami
                    </a>
                </div>
            @endif
        @else
            <div class="col-1 mb-2">
                <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/view-services">
                    Perawatan
                </a>
            </div>
            <div class="col-1 mb-2">
                <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/view-products">
                    Produk
                </a>
            </div>
            <div class="col-4 mb-2">
                <a class="text-reztya font-futura-reztya fs-6 text-decoration-none" href="/about-us">
                    Tentang Kami
                </a>
            </div>
        @endauth
            <div class="col-1 mb-2 ms-4 @guest d-none @endguest @auth @if(auth()->user()->user_role_id == 1) d-none @endif @endauth" style="margin-right: -5%;">
                <a href="/cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="#00A54F" class="bi bi-cart3 img-fluid" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                </a>
            </div>
        @auth
            <div class="col-2 mt-2">
                <div class="row align-items-start">
                    <div class="font-futura-reztya text-reztya dropdown">
                        <p class="fs-6 dropdown-toggle" type="button" id="dropdownToggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, {{auth()->user()->username}}
                        </p>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li><a class="button-outline-reztya dropdown-item" href="/view-profile/{{auth()->user()->username}}">Lihat Profil</a></li>
                            <li><a class="button-outline-reztya dropdown-item" href="/active-order">Lihat Pesanan Aktif</a></li>
                            <li><a class="button-outline-reztya dropdown-item" href="/history-order">Lihat Riwayat Pesanan</a></li>
                            @if(auth()->user()->user_role_id == 1)
                                <li><a class="button-outline-reztya dropdown-item" href="/view-users">Ban / Unban Akun</a></li>
                            @endif
                            <li>
                                <form method="POST" action="/signout">
                                    @csrf
                                    <button type="submit" class="button-outline-reztya dropdown-item font-futura-reztya">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="col-1 mb-2 ms-4">
                <a class="font-futura-reztya text-reztya pe-4 fs-6 text-decoration-none" href="/signin">
                    Masuk
                </a>
            </div>
            <div class="col-1 mb-2">
                <a class="font-futura-reztya text-reztya fs-6 text-decoration-none" href="/signup">
                    Daftar
                </a>
            </div>
        @endauth
    </div>
</nav>
<div class="container m5-4">@yield('container')</div>
<footer class="unselectable footer fixed-bottom pb-1 bg-white">
    <div class="container text-center pt-1">
        <a class="text-decoration-none text-reztya footer-text" href="/home" data-toggle="tooltip" title="Home">
            © 2022 Reztya Medika Clinic. All rights reserved.
        </a>
    </div>
</footer>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
