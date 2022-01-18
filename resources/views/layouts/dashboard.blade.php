<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

@yield('title')

<!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('bootstrap/dist/css/dashboard.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('flatpickr/css/flatpickr.min.css') }}">

    {{-- alpine js --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('css')
    <style>
        .nav {
            padding-right: 0 !important;
        }

        /* Dropdown Button */
        .dropbtn {
            background-color: transparent;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        /* Dropdown button on hover & focus */
        .dropbtn:hover,
        .dropbtn:focus {
            background-color: transparent;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #ddd
        }

        /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
        .show {
            display: block;
        }

    </style>

</head>

<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-main">
    <div class="container">
        <div class="flex-grow-1 d-flex justify-content-between align-items-center">
            <div class="navbar-brand">
                <img src="{{url('assets/images/logo.png')}}" alt="waslni">
            </div>
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('message.index') }}" class="p-2">
                        <span class="text-light" data-feather="mail"></span>
                    </a>
                    @if (auth()->user()->user_role == 'passenger')
                        <a href="{{ route('notification_view') }}" class="p-2"><span class="text-light"
                                                                                     data-feather="bell"></span>
                            @if (session()->get('noti_count') > 0)
                                <div class="badge alert-success">
                                    {{ session()->get('noti_count') }}
                                </div>
                            @endif
                        </a>
                    @endif

                    @if (auth()->user()->user_role == 'driver')
                        <a href="{{ route('notification_view') }}" class="p-2"><span class="text-light"
                                                                                     data-feather="bell"></span>
                            @if (session()->get('noti_count') > 0)
                                <div class="badge alert-success">
                                    {{ session()->get('noti_count') }}
                                </div>
                            @endif
                        </a>
                    @endif

                    <a href="{{ route('profile.index') }}" class="p-2">
                        <span class="text-light" data-feather="user" alt=""></span>
                    </a>

                </div>
                <ul class="navbar-nav px-3">
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="{{ route('logout') }}">خروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid g-0">
    <div class="row g-0">
        <div class="col-md-3">
            {{-- admin --}}
            @if (auth()->user()->user_role == 'admin')
                @include('includes.nav.admin')
            @endif

            {{-- driver --}}
            @if (auth()->user()->user_role == 'driver')
                @include('includes.nav.driver')
            @endif

            {{-- passenger --}}
            @if (auth()->user()->user_role == 'passenger')
                @include('includes.nav.passenger')
            @endif
        </div>

        <main role="main" class="col-md-9 pt-86">
            <div class="container content">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('bootstrap/dist/js/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('flatpickr/js/flatpickr.min.js') }}"></script>
<!-- Icons -->
<script src="{{ asset('bootstrap/dist/js/feather.min.js') }}"></script>
<script>
    feather.replace()
</script>
<script>
    /* When the user clicks on the button,
                                                                                                                    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

@yield('script')
</body>

</html>
