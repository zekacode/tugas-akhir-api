@extends('layouts.app')

@section('title', 'Dokumentasi API Dapur Gaib')

@push('styles')
<style>
    .endpoint-section {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    .endpoint-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .endpoint-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .endpoint-title .badge { /* Untuk method HTTP */
        font-size: 0.9rem;
        vertical-align: middle;
    }
    .endpoint-url {
        font-family: 'Courier New', Courier, monospace;
        background-color: #e9ecef;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.9em;
        word-break: break-all;
    }
    .section-subtitle {
        font-weight: 600;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }
    pre {
        background-color: #282c34; /* Warna gelap untuk blok kode */
        color: #abb2bf;
        padding: 1em;
        border-radius: 0.3rem;
        overflow-x: auto;
        font-size: 0.85em;
    }
    table th, table td {
        vertical-align: middle;
    }
    .table>:not(caption)>*>* { /* Bootstrap 5 table padding fix */
        padding: .6rem .6rem;
    }
</style>
@endpush

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-code-fill me-2" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.646 7.646a.5.5 0 1 1 .708.708L6.707 9l.647.646a.5.5 0 0 1-.708.708l-1-1a.5.5 0 0 1 0-.708l1-1zm2.708 0 1 1a.5.5 0 0 1 0 .708l-1 1a.5.5 0 0 1-.708-.708L8.293 9l-.647-.646a.5.5 0 1 1 .708-.708z"/>
                            </svg>
                            Dokumentasi API Dapur Gaib
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <p class="lead">Selamat datang di dokumentasi API Dapur Gaib. API ini memungkinkan Anda untuk berinteraksi dengan data makanan, kategori, dan mendapatkan rekomendasi makanan.</p>
                        <p>Base URL untuk semua endpoint API adalah: <code>{{ url('/api') }}</code></p>

                        <hr class="my-4">

                        <!-- ======================= AUTHENTICATION ======================= -->
                        <section id="auth" class="endpoint-section">
                            <h2 class="mb-3">Autentikasi</h2>
                            <p>Beberapa endpoint memerlukan autentikasi menggunakan JWT (JSON Web Token). Anda harus mengirimkan token di header <code>Authorization</code> dengan format <code>Bearer <token></code>.</p>

                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Registrasi Pengguna</h3>
                                <p class="endpoint-url">/auth/register</p>
                                <p>Mendaftarkan pengguna baru.</p>
                                <h5 class="section-subtitle">Request Body: <code>application/x-www-form-urlencoded</code> atau <code>application/json</code></h5>
                                <table class="table table-sm table-bordered">
                                    <thead><tr><th>Parameter</th><th>Tipe</th><th>Wajib?</th><th>Deskripsi</th></tr></thead>
                                    <tbody>
                                        <tr><td><code>name</code></td><td>string</td><td>Ya</td><td>Nama lengkap pengguna.</td></tr>
                                        <tr><td><code>email</code></td><td>string (email)</td><td>Ya</td><td>Alamat email pengguna (harus unik).</td></tr>
                                        <tr><td><code>password</code></td><td>string</td><td>Ya</td><td>Kata sandi pengguna (minimal 6 karakter).</td></tr>
                                        <tr><td><code>password_confirmation</code></td><td>string</td><td>Ya</td><td>Konfirmasi kata sandi (harus sama dengan password).</td></tr>
                                    </tbody>
                                </table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (201 Created):</h5>
                                <pre><code class="language-json">{
"message": "User successfully registered",
"user": {
    "name": "Nama User",
    "email": "user@example.com",
    "updated_at": "2023-10-27T12:00:00.000000Z",
    "created_at": "2023-10-27T12:00:00.000000Z",
    "id": 1
},
"access_token": "eyJhbGciOiJIUzI1NiI...",
"token_type": "bearer",
"expires_in": 3600
}</code></pre>
                                <h5 class="section-subtitle">Contoh Respons Error (422 Unprocessable Entity):</h5>
                                <pre><code class="language-json">{
"errors": {
"email": [
"The email has already been taken."
]
}
}</code></pre>
                            </div>

                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Login Pengguna</h3>
                                <p class="endpoint-url">/auth/login</p>
                                <p>Login untuk pengguna yang sudah terdaftar dan mendapatkan token JWT.</p>
                                <h5 class="section-subtitle">Request Body: <code>application/x-www-form-urlencoded</code> atau <code>application/json</code></h5>
                                <table class="table table-sm table-bordered">
                                    <thead><tr><th>Parameter</th><th>Tipe</th><th>Wajib?</th><th>Deskripsi</th></tr></thead>
                                    <tbody>
                                        <tr><td><code>email</code></td><td>string (email)</td><td>Ya</td><td>Alamat email pengguna.</td></tr>
                                        <tr><td><code>password</code></td><td>string</td><td>Ya</td><td>Kata sandi pengguna.</td></tr>
                                    </tbody>
                                </table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
"access_token": "eyJhbGciOiJIUzI1NiI...",
"token_type": "bearer",
"expires_in": 3600
}</code></pre>
                                <h5 class="section-subtitle">Contoh Respons Error (401 Unauthorized):</h5>
                                <pre><code class="language-json">{
"error": "Unauthorized: Invalid credentials"
}</code></pre>
                            </div>

                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> Detail Pengguna (Me)</h3>
                                <p class="endpoint-url">/auth/me</p>
                                <p>Mendapatkan detail pengguna yang sedang terautentikasi. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5>
                                <ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
"id": 1,
"name": "Nama User",
"email": "user@example.com",
"email_verified_at": null,
"created_at": "2023-10-27T12:00:00.000000Z",
"updated_at": "2023-10-27T12:00:00.000000Z"
}</code></pre>
                            </div>

                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Logout Pengguna</h3>
                                <p class="endpoint-url">/auth/logout</p>
                                <p>Logout pengguna dan menginvalidasi token JWT saat ini. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5>
                                <ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
"message": "Successfully logged out"
}</code></pre>
                            </div>
                        </section>
                        <!-- ======================= END AUTHENTICATION ======================= -->

                        <hr class="my-4">

                        <!-- ======================= CATEGORIES ======================= -->
                        <section id="categories" class="endpoint-section">
                            <h2 class="mb-3">Manajemen Kategori Makanan Utama</h2>

                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> List Kategori Utama</h3>
                                <p class="endpoint-url">/categories</p>
                                <p>Mengambil daftar semua kategori utama makanan (misal: Sarapan, Minuman).</p>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
"data": [
    {
        "id": 1,
        "name": "Sarapan",
        "created_at": "2023-10-27T00:00:00.000000Z",
        "updated_at": "2023-10-27T00:00:00.000000Z"
    },
    {
        "id": 2,
        "name": "Makan Siang",
        // ...
    }
],
"meta": { // Jika Anda menggunakan pagination
    "current_page": 1,
    // ...
},
"links": { // Jika Anda menggunakan pagination
    "first": "...",
    // ...
}
}</code></pre>
                            </div>
                            {{-- Tambahkan dokumentasi untuk GET /categories/{id}, POST, PUT, DELETE categories --}}
                            {{-- Polanya sama seperti di atas --}}
                        </section>
                        <!-- ======================= END CATEGORIES ======================= -->

                        <hr class="my-4">

                        <!-- ======================= FOODS ======================= -->
                        <section id="foods" class="endpoint-section">
                            <h2 class="mb-3">Manajemen Makanan & Rekomendasi</h2>

                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> Rekomendasi Makanan (Oracle Pick)</h3>
                                <p class="endpoint-url">/foods/oracle-pick</p>
                                <p>Mendapatkan satu rekomendasi makanan acak. Bisa difilter berdasarkan berbagai kriteria.</p>
                                <h5 class="section-subtitle">Query Parameters (Opsional):</h5>
                                <table class="table table-sm table-bordered">
                                    <thead><tr><th>Parameter</th><th>Tipe</th><th>Deskripsi</th></tr></thead>
                                    <tbody>
                                        <tr><td><code>category_id</code></td><td>integer</td><td>Filter berdasarkan ID Kategori Utama.</td></tr>
                                        <tr><td><code>mood_ids[]</code></td><td>array of integers</td><td>Filter berdasarkan satu atau lebih ID Mood.</td></tr>
                                        <tr><td><code>occasion_ids[]</code></td><td>array of integers</td><td>Filter berdasarkan satu atau lebih ID Acara.</td></tr>
                                        <tr><td><code>weather_condition_ids[]</code></td><td>array of integers</td><td>Filter berdasarkan satu atau lebih ID Kondisi Cuaca.</td></tr>
                                        <tr><td><code>dietary_restriction_ids[]</code></td><td>array of integers</td><td>Filter berdasarkan satu atau lebih ID Batasan Diet.</td></tr>
                                        <tr><td><code>cuisine_type_ids[]</code></td><td>array of integers</td><td>Filter berdasarkan satu atau lebih ID Jenis Masakan.</td></tr>
                                    </tbody>
                                </table>
                                <p>Contoh Penggunaan Filter: <code>/foods/oracle-pick?category_id=1&mood_ids[]=1&mood_ids[]=5</code></p>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
"data": {
    "id": 5,
    "name": "Nasi Goreng Jawa",
    "description": "Nasi goreng klasik...",
    "category": { "id": 1, "name": "Sarapan", ... },
    "moods": [ { "id": 1, "name": "Senang", ... } ],
    "occasions": [ { "id": 2, "name": "Sarapan Cepat", ... } ],
    // ... relasi lainnya
    "created_at": "...",
    "updated_at": "..."
}
}</code></pre>
                                <h5 class="section-subtitle">Contoh Respons Error (404 Not Found - jika tidak ada makanan sesuai kriteria):</h5>
                                <pre><code class="language-json">{
"message": "No food found for your criteria."
}</code></pre>
                            </div>
                            {{-- Tambahkan dokumentasi untuk GET /foods, GET /foods/{id}, POST, PUT, DELETE foods --}}
                        </section>
                        <!-- ======================= END FOODS ======================= -->

                        {{-- Tambahkan dokumentasi untuk GET /occasions --}}
                        {{-- Tambahkan dokumentasi untuk GET /weather-conditions --}}
                        {{-- Tambahkan dokumentasi untuk GET /dietary-restrictions --}}
                        {{-- Tambahkan dokumentasi untuk GET /cuisine-types --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Tidak ada JavaScript spesifik yang dibutuhkan untuk halaman dokumentasi statis ini,
     kecuali jika Anda ingin menambahkan fitur seperti copy-to-clipboard untuk blok kode. --}}
@endpush
