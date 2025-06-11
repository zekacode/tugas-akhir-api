<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dapur Gaib') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Poppins', 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #0d6efd;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #ffffff;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link:focus {
            color: #e9ecef;
        }
        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-custom .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .main-content-area {
            min-height: calc(100vh - 56px); /* Hanya tinggi navbar, tanpa footer */
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-egg-fried me-2 align-text-bottom" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        <path d="M13.997 5.17a5 5 0 0 0-8.101-4.09A5 5 0 0 0 1.27 6.176a5 5 0 0 0 4.276 8.021 5 5 0 0 0 8.101-4.09A5 5 0 0 0 13.997 5.17zm-4.605-1.4A3.001 3.001 0 0 1 8 2.024a3.001 3.001 0 0 1 3.406 2.734.03.03 0 0 0 .04.028.038.038 0 0 0 .046.003.053.053 0 0 0 .02-.003.053.053 0 0 0 .012-.01A3.001 3.001 0 0 1 8 5.063a3.001 3.001 0 0 1-2.982-2.733.049.049 0 0 0-.004-.03.05.05 0 0 0-.012-.01A2.99 2.99 0 0 1 5 4.718a3.001 3.001 0 0 1 4.392-2.948z"/>
                    </svg>
                    Dapur Gaib
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Buka navigasi') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('oracle.pick.view') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-magic me-1 align-middle" viewBox="0 0 16 16">
                                    <path d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.646 10.697a.5.5 0 0 0 .708 0l.5-.5a.5.5 0 0 0-.708-.707l-.5.5a.5.5 0 0 0 0 .707ZM8.5 16a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 0-1 0V15.5a.5.5 0 0 0 .5.5ZM11.5 14.672a.5.5 0 1 0 1 0V12.843a.5.5 0 0 0-1 0v1.829Zm-7.793-1.177a.5.5 0 0 0 .707 0l1.293-1.293a.5.5 0 0 0-.707-.707L2.707 14a.5.5 0 0 0 0 .707Z"/>
                                    <path d="M12.5 7.465a5.45 5.45 0 1 1-1.43-1.408L11.454 7.5A.5.5 0 0 1 11 8a.5.5 0 0 1-.464-.718l.885-2.078a3.5 3.5 0 1 0-4.55 4.55L4.718 11.464A.5.5 0 0 1 4 11.5a.5.5 0 0 1-.454-.282L2.66 9.14A5.45 5.45 0 1 1 12.5 7.465Zm-4.19-.622.006-.006.006-.005a1.5 1.5 0 1 0-2.115-2.116l-.006.005-.005.006-.006.005a1.5 1.5 0 0 0 2.116 2.116Zm-2.12-2.12a.5.5 0 0 1 .708 0l1.29 1.29a.5.5 0 0 1 0 .708l-1.29 1.29a.5.5 0 1 1-.708-.708l1.29-1.29a.5.5 0 0 1 0-.708l-1.29-1.29a.5.5 0 0 1 .708 0Z"/>
                                </svg>
                                Masuk Dapur Gaib
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('api.documentation') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book-half me-1 align-middle" viewBox="0 0 16 16">
                                    <path d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388 1.17.953.713 1.364 1.763.999 2.938C15.507 7.249 14.135 9.25 12.354 10.994V13.5a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V11a.5.5 0 0 1 .468-.5.506.506 0 0 0 .436-.45L8.5 2.687zM8 3.25a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zM8 4.75a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zM8 6.25a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M4.176 2.033C2.641 1.49 1.07 1.49 0 2.033v11.234C1.072 12.79 2.641 12.79 4.176 13.333V2.033zM3.674 12.49C2.437 12.106 1.255 12.03 0 12.234V2.78C1.238 2.4 2.437 2.325 3.674 2.71v9.78z"/>
                                </svg>
                                Dokumentasi API
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar - KOSONG karena tidak ada login -->
                    <ul class="navbar-nav ms-auto">
                        {{-- Tidak ada item di sini lagi --}}
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 main-content-area">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS Bundle (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    @stack('scripts') {{-- JavaScript spesifik per halaman akan tetap ada di sini (misal untuk oracle-pick.blade.php) --}}

    {{-- BLOK @push('scripts') UNTUK LOGIN API DIHAPUS --}}

</body>
</html>