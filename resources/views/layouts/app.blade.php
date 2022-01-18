<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf8mb4_general_ci">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>صفحة وصلني</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
    @livewireStyles
</head>

<body>
<div class="p-5 rounded">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-main">
        <div class="container">
            <a class="navbar-brand" href="waslni">
                <img src="{{url('assets/images/logo.png')}}" alt="waslni">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarCollapse" style="">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('login') }}">تسجيل الدخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">انشاء حساب</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item">
                            @csrf
                            <a class="nav-link" href="{{ route('logout') }}">خروج</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">حسابي</a>
                        </li>

                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="content">
    @yield('content')
</div>

@livewireScripts
<script src="{{ asset('bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
