<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dapur Gaib') }} - @yield('title')</title> {{-- Ubah default title --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> {{-- Tambah font Poppins --}}


    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Poppins', 'Nunito', sans-serif; /* Gunakan Poppins sebagai font utama */
            background-color: #f8f9fa; /* Warna background body sedikit abu-abu */
        }
        .navbar-custom {
            background-color: #0d6efd; /* Warna biru primer Bootstrap */
            /* Atau coba: background: linear-gradient(to right, #6dd5ed, #2193b0); */
            /* Atau: background-color: #343a40; untuk dark navbar */
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #ffffff; /* Teks putih */
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link:focus {
            color: #e9ecef; /* Warna hover sedikit lebih redup */
        }
        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-custom .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem; /* Perbesar brand */
        }
        .main-content-area {
            min-height: calc(100vh - 56px - 56px); /* 56px navbar, 56px footer (jika ada) */
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
    </style>

    @stack('styles') <!-- Untuk CSS spesifik per halaman -->
</head>
<body>
    <div id="app">
        {{-- Navbar baru dengan class navbar-custom dan navbar-dark (jika background gelap) --}}
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm"> {{-- Ganti navbar-light bg-white menjadi navbar-custom --}}
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-egg-fried me-2 align-text-bottom" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        <path d="M13.997 5.17a5 5 0 0 0-8.101-4.09A5 5 0 0 0 1.27 6.176a5 5 0 0 0 4.276 8.021 5 5 0 0 0 8.101-4.09A5 5 0 0 0 13.997 5.17zm-4.605-1.4A3.001 3.001 0 0 1 8 2.024a3.001 3.001 0 0 1 3.406 2.734.03.03 0 0 0 .04.028.038.038 0 0 0 .046.003.053.053 0 0 0 .02-.003.053.053 0 0 0 .012-.01A3.001 3.001 0 0 1 8 5.063a3.001 3.001 0 0 1-2.982-2.733.049.049 0 0 0-.004-.03.05.05 0 0 0-.012-.01A2.99 2.99 0 0 1 5 4.718a3.001 3.001 0 0 1 4.392-2.948z"/>
                    </svg>
                    Dapur Gaib
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Buka navigasi') }}"> {{-- Ganti teks --}}
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
                        <!-- Tambahkan link lain di sini jika perlu -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="loginStatus" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle me-1 align-middle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                                {{ __('Autentikasi') }} {{-- Ganti teks Login API --}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 main-content-area"> {{-- Tambah class main-content-area --}}
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> {{-- Tambah modal-dialog-centered --}}
            <div class="modal-content">
                <div class="modal-header bg-primary text-white"> {{-- Header modal biru --}}
                    <h5 class="modal-title" id="loginModalLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right me-2 align-middle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                        </svg>
                        Login ke Dapur Gaib
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> {{-- Tombol close putih --}}
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="loginEmail" placeholder="nama@contoh.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="loginPassword" placeholder="Kata Sandi Anda" required>
                        </div>
                        <div class="d-grid"> {{-- Tombol login full width --}}
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                        <div id="loginError" class="alert alert-danger mt-3" style="display:none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    @stack('scripts')

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginErrorDiv = document.getElementById('loginError');
            const loginStatusLink = document.getElementById('loginStatus');
            const apiUrl = '{{ url("/api") }}';

            const userIconSVG = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill me-1 align-middle" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>`;
            const loginIconSVG = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle me-1 align-middle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>`;


            function updateLoginStatus() {
                const token = localStorage.getItem('api_token');
                // console.log('updateLoginStatus called. Token:', token);
                if (token) {
                    fetch(`${apiUrl}/auth/me`, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    })
                    .then(response => {
                        // console.log('/me response status:', response.status);
                        if (!response.ok) {
                            localStorage.removeItem('api_token');
                            throw new Error('Invalid token or user not found, status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // console.log('/me response data:', data);
                        if (data && data.name) {
                            const logoutAnchor = document.createElement('a');
                            logoutAnchor.href = "#";
                            logoutAnchor.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right me-1 align-middle" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/></svg>Logout`;
                            logoutAnchor.classList.add('nav-link'); // Tambah class agar style sama
                            logoutAnchor.addEventListener('click', function(e) {
                                e.preventDefault();
                                handleLogout();
                            });

                            loginStatusLink.innerHTML = `${userIconSVG} ${data.name} (`;
                            loginStatusLink.appendChild(logoutAnchor);
                            loginStatusLink.append(")");
                            loginStatusLink.classList.remove('btn', 'btn-outline-primary'); // Hapus styling tombol jika ada
                            loginStatusLink.removeAttribute('data-bs-toggle');
                            loginStatusLink.removeAttribute('data-bs-target');
                            loginStatusLink.onclick = null;

                            window.loggedInUser = data.name;
                            // console.log('Dispatching authStatusChanged: loggedIn=true, userName=', data.name);
                            document.dispatchEvent(new CustomEvent('authStatusChanged', { detail: { loggedIn: true, userName: data.name } }));
                        } else {
                            localStorage.removeItem('api_token');
                            resetLoginLink();
                        }
                    })
                    .catch((error) => {
                        // console.error('/me fetch error or invalid token:', error);
                        localStorage.removeItem('api_token');
                        resetLoginLink();
                    });
                } else {
                    // console.log('No token found, resetting login link.');
                    resetLoginLink();
                }
            }

            function resetLoginLink() {
                loginStatusLink.innerHTML = `${loginIconSVG} Autentikasi`;
                loginStatusLink.classList.add('nav-link'); // Pastikan tetap nav-link
                // loginStatusLink.classList.add('btn', 'btn-outline-primary', 'ms-2'); // Contoh styling tombol
                loginStatusLink.setAttribute('data-bs-toggle', 'modal');
                loginStatusLink.setAttribute('data-bs-target', '#loginModal');
                loginStatusLink.onclick = null;
                window.loggedInUser = null;
                // console.log('Dispatching authStatusChanged from resetLoginLink: loggedIn=false');
                document.dispatchEvent(new CustomEvent('authStatusChanged', { detail: { loggedIn: false } }));
            }

            async function handleLogout() {
                // ... (fungsi handleLogout tetap sama) ...
                const token = localStorage.getItem('api_token');
                if (token) {
                    try {
                        await fetch(`${apiUrl}/auth/logout`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${token}`
                            }
                        });
                    } catch (error) {
                        console.error('Logout API error:', error);
                    } finally {
                        localStorage.removeItem('api_token');
                        updateLoginStatus();
                    }
                }
            }

            if (loginForm) {
                // ... (event listener loginForm tetap sama) ...
                 loginForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    loginErrorDiv.textContent = '';
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
                            loginErrorDiv.textContent = data.error || (data.errors ? Object.values(data.errors).flat().join(' ') : data.message) || 'Login failed.';
                            loginErrorDiv.style.display = 'block';
                        } else {
                            localStorage.setItem('api_token', data.access_token);
                            var loginModalEl = document.getElementById('loginModal');
                            var modal = bootstrap.Modal.getInstance(loginModalEl);
                            if(modal) {
                                modal.hide();
                            } else {
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
            updateLoginStatus();
        });
    </script>
    @endpush

</body>
</html>