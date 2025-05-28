<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Culinary Oracle') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    @stack('styles') <!-- Untuk CSS spesifik per halaman -->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Dapur Gaib
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('oracle.pick.view') }}">Masuk Dapur Gaib</a>
                        </li>
                        <!-- Tambahkan link lain di sini jika perlu -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="loginStatus" data-bs-toggle="modal" data-bs-target="#loginModal">{{ __('Login API') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login ke API</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <div id="loginError" class="alert alert-danger mt-2" style="display:none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    {{-- Opsional: Definisikan apiUrl secara global jika ingin diakses oleh semua script yang di-push --}}
    {{-- <script> window.apiUrl = '{{ url("/api") }}'; </script> --}}

    @stack('scripts') <!-- JavaScript spesifik per halaman akan dimasukkan di sini -->

    {{-- Script untuk fungsionalitas login API, dimasukkan menggunakan @push --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginErrorDiv = document.getElementById('loginError');
            const loginStatusLink = document.getElementById('loginStatus');
            const apiUrl = '{{ url("/api") }}'; // Atau window.apiUrl jika didefinisikan global

            function updateLoginStatus() {
                const token = localStorage.getItem('api_token');
                if (token) {
                    fetch(`${apiUrl}/auth/me`, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    })
                    .then(response => {
                        if (!response.ok) { // Jika status bukan 2xx, token mungkin tidak valid
                            localStorage.removeItem('api_token');
                            throw new Error('Invalid token or user not found');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.name) {
                            loginStatusLink.innerHTML = `Logged in as: ${data.name} (Logout)`;
                            loginStatusLink.removeAttribute('data-bs-toggle');
                            loginStatusLink.removeAttribute('data-bs-target');
                            loginStatusLink.onclick = function(e) {
                                e.preventDefault();
                                handleLogout();
                            };
                        } else { // Seharusnya tidak terjadi jika response.ok tapi data.name tidak ada
                            localStorage.removeItem('api_token');
                            resetLoginLink();
                        }
                    })
                    .catch(() => { // Tangkap error dari fetch atau dari throw new Error
                        localStorage.removeItem('api_token');
                        resetLoginLink();
                    });
                } else {
                    resetLoginLink();
                }
            }

            function resetLoginLink() {
                loginStatusLink.innerHTML = 'Login API';
                loginStatusLink.setAttribute('data-bs-toggle', 'modal');
                loginStatusLink.setAttribute('data-bs-target', '#loginModal');
                loginStatusLink.onclick = null;
            }

            async function handleLogout() {
                const token = localStorage.getItem('api_token');
                if (token) {
                    try {
                        const response = await fetch(`${apiUrl}/auth/logout`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${token}`
                            }
                        });
                        // Tidak perlu cek response.ok secara ketat, logout seharusnya selalu berhasil jika token ada
                    } catch (error) {
                        console.error('Logout API error:', error);
                    } finally {
                        localStorage.removeItem('api_token');
                        updateLoginStatus(); // Akan memanggil resetLoginLink
                        // Opsional: Arahkan ke halaman utama atau refresh
                        // window.location.href = '{{ url("/") }}';
                    }
                }
            }

            if (loginForm) {
                loginForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    loginErrorDiv.textContent = ''; // Bersihkan error sebelumnya
                    loginErrorDiv.style.display = 'none';
                    const email = document.getElementById('loginEmail').value;
                    const password = document.getElementById('loginPassword').value;

                    try {
                        const response = await fetch(`${apiUrl}/auth/login`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ email, password })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            loginErrorDiv.textContent = data.error || (data.errors ? JSON.stringify(data.errors) : data.message) || 'Login failed.';
                            loginErrorDiv.style.display = 'block';
                        } else {
                            localStorage.setItem('api_token', data.access_token);
                            var loginModalEl = document.getElementById('loginModal');
                            var modal = bootstrap.Modal.getInstance(loginModalEl);
                            if(modal) {
                                modal.hide();
                            } else { // Fallback jika modal instance tidak ditemukan (jarang terjadi)
                                 loginModalEl.classList.remove('show');
                                 document.body.classList.remove('modal-open');
                                 const backdrop = document.querySelector('.modal-backdrop');
                                 if (backdrop) backdrop.remove();
                            }
                            updateLoginStatus();
                        }
                    } catch (error) {
                        console.error('Login form submission error:', error);
                        loginErrorDiv.textContent = 'An error occurred. Please try again.';
                        loginErrorDiv.style.display = 'block';
                    }
                });
            }
            // Panggil saat halaman dimuat untuk cek status login awal
            updateLoginStatus();
        });
    </script>
    @endpush

</body>
</html>