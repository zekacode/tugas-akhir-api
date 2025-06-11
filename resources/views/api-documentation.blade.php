@extends('layouts.app')

@section('title', 'Dokumentasi API Dapur Gaib')

@push('styles')
<style>
    .endpoint-section { margin-bottom: 2.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #eee; }
    .endpoint-section:last-child { border-bottom: none; margin-bottom: 0; }
    .endpoint-title { font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem; }
    .endpoint-title .badge { font-size: 0.9rem; vertical-align: middle; }
    .endpoint-url { font-family: 'Courier New', Courier, monospace; background-color: #e9ecef; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.9em; word-break: break-all; }
    .section-subtitle { font-weight: 600; margin-top: 1rem; margin-bottom: 0.5rem; }
    pre { background-color: #282c34; color: #abb2bf; padding: 1em; border-radius: 0.3rem; overflow-x: auto; font-size: 0.85em; }
    table th, table td { vertical-align: middle; }
    .table>:not(caption)>*>* { padding: .6rem .6rem; }
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

                        <!-- ======================= AUTHENTICATION (Sudah Lengkap) ======================= -->
                        <section id="auth" class="endpoint-section">
                            <h2 class="mb-3">Autentikasi</h2>
                            <p>Beberapa endpoint memerlukan autentikasi menggunakan JWT (JSON Web Token). Anda harus mengirimkan token di header <code>Authorization</code> dengan format <code>Bearer <token></code>.</p>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Registrasi Pengguna</h3>
                                <p class="endpoint-url">/auth/register</p>
                                <p>Mendaftarkan pengguna baru.</p>
                                <h5 class="section-subtitle">Request Body: <code>application/x-www-form-urlencoded</code> atau <code>application/json</code></h5>
                                <table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Wajib?</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>name</code></td><td>string</td><td>Ya</td><td>Nama lengkap pengguna.</td></tr><tr><td><code>email</code></td><td>string (email)</td><td>Ya</td><td>Alamat email pengguna (harus unik).</td></tr><tr><td><code>password</code></td><td>string</td><td>Ya</td><td>Kata sandi pengguna (minimal 6 karakter).</td></tr><tr><td><code>password_confirmation</code></td><td>string</td><td>Ya</td><td>Konfirmasi kata sandi (harus sama dengan password).</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (201 Created):</h5><pre><code class="language-json">{
"message": "User successfully registered",
"user": {"name": "Nama User", "email": "user@example.com", /* ... */ "id": 1},
"access_token": "eyJhbGciOiJIUzI1NiI...", "token_type": "bearer", "expires_in": 3600
}</code></pre>
                                <h5 class="section-subtitle">Contoh Respons Error (422 Unprocessable Entity):</h5><pre><code class="language-json">{ "errors": { "email": ["The email has already been taken."] } }</code></pre>
                            </div>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Login Pengguna</h3>
                                <p class="endpoint-url">/auth/login</p>
                                <p>Login untuk pengguna yang sudah terdaftar dan mendapatkan token JWT.</p>
                                <h5 class="section-subtitle">Request Body: <code>application/x-www-form-urlencoded</code> atau <code>application/json</code></h5>
                                <table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Wajib?</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>email</code></td><td>string (email)</td><td>Ya</td><td>Alamat email pengguna.</td></tr><tr><td><code>password</code></td><td>string</td><td>Ya</td><td>Kata sandi pengguna.</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "access_token": "eyJhbGciOiJIUzI1NiI...", "token_type": "bearer", "expires_in": 3600 }</code></pre>
                                <h5 class="section-subtitle">Contoh Respons Error (401 Unauthorized):</h5><pre><code class="language-json">{ "error": "Unauthorized: Invalid credentials" }</code></pre>
                            </div>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> Detail Pengguna (Me)</h3>
                                <p class="endpoint-url">/auth/me</p>
                                <p>Mendapatkan detail pengguna yang sedang terautentikasi. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "id": 1, "name": "Nama User", "email": "user@example.com", /* ... */ }</code></pre>
                            </div>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Logout Pengguna</h3>
                                <p class="endpoint-url">/auth/logout</p>
                                <p>Logout pengguna dan menginvalidasi token JWT saat ini. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "message": "Successfully logged out" }</code></pre>
                            </div>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-primary me-2">POST</span> Refresh Token</h3>
                                <p class="endpoint-url">/auth/refresh</p>
                                <p>Memperbarui token JWT. <strong>Memerlukan Token JWT (token lama).</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token_lama></code></li></ul>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "access_token": "eyJhbG...", "token_type": "bearer", "expires_in": 3600 }</code></pre>
                            </div>
                        </section>
                        <!-- ======================= END AUTHENTICATION ======================= -->

                        <hr class="my-4">

                        <!-- ======================= CATEGORIES (Kategori Utama - Sudah Lengkap) ======================= -->
                        <section id="categories" class="endpoint-section">
                            <h2 class="mb-3">Manajemen Kategori Utama Makanan</h2>
                            {{-- ... (Kode Dokumentasi Categories Anda yang sudah ada di sini, sudah lengkap) ... --}}
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> List Kategori Utama</h3>
                                <p class="endpoint-url">/categories</p>
                                <p>Mengambil daftar semua kategori utama makanan (misal: Sarapan, Minuman) dengan pagination.</p>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
    "data": [ /* ...array of category objects... */ ],
    "links": { /* ...pagination links... */ },
    "meta": { /* ...pagination meta... */ }
}</code></pre>
                            </div>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Buat Kategori Utama Baru</h3>
                                <p class="endpoint-url">/categories</p>
                                <p>Membuat kategori utama makanan baru. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Request Body: <code>application/json</code></h5>
                                <table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Wajib?</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>name</code></td><td>string</td><td>Ya</td><td>Nama kategori (unik).</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (201 Created):</h5><pre><code class="language-json">{ "data": { "id": 3, "name": "Cemilan", /* ... */ } }</code></pre>
                            </div>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> Detail Kategori Utama</h3>
                                <p class="endpoint-url">/categories/{category_id}</p>
                                <p>Mengambil detail satu kategori utama makanan berdasarkan ID.</p>
                                <h5 class="section-subtitle">Path Parameters:</h5><table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>category_id</code></td><td>integer</td><td>ID dari kategori utama.</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "data": { "id": 1, "name": "Sarapan", /* ... */ } }</code></pre>
                            </div>
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-warning me-2">PUT/PATCH</span> Update Kategori Utama</h3>
                                <p class="endpoint-url">/categories/{category_id}</p>
                                <p>Memperbarui kategori utama yang sudah ada. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Path Parameters:</h5><table class="table table-sm table-bordered"><tbody><tr><td><code>category_id</code></td><td>integer</td><td>ID kategori yang akan diupdate.</td></tr></tbody></table>
                                <h5 class="section-subtitle">Request Body: <code>application/json</code></h5><table class="table table-sm table-bordered"><tbody><tr><td><code>name</code></td><td>string</td><td>Ya</td><td>Nama baru kategori (unik).</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "data": { "id": 1, "name": "Sarapan Pagi", /* ... */ } }</code></pre>
                            </div>
                             <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-danger me-2">DELETE</span> Hapus Kategori Utama</h3>
                                <p class="endpoint-url">/categories/{category_id}</p>
                                <p>Menghapus kategori utama. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Path Parameters:</h5><table class="table table-sm table-bordered"><tbody><tr><td><code>category_id</code></td><td>integer</td><td>ID kategori yang akan dihapus.</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (204 No Content):</h5><p>Tidak ada body respons.</p>
                            </div>
                        </section>
                        <!-- ======================= END CATEGORIES ======================= -->

                        <hr class="my-4">

                        <!-- ======================= FOODS (Melengkapi) ======================= -->
                        <section id="foods" class="endpoint-section">
                            <h2 class="mb-3">Manajemen Makanan & Rekomendasi</h2>
                            {{-- Oracle Pick dan GET /foods sudah ada --}}
                            <div class="endpoint-item mb-4"> {{-- Copy dari Oracle Pick, sudah ada --}}
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> Rekomendasi Makanan (Oracle Pick)</h3>
                                <p class="endpoint-url">/foods/oracle-pick</p>
                                <p>Mendapatkan satu rekomendasi makanan acak. Bisa difilter berdasarkan berbagai kriteria.</p>
                                <h5 class="section-subtitle">Query Parameters (Opsional):</h5>
                                <table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>category_id</code></td><td>integer</td><td>Filter ID Kategori Utama.</td></tr><tr><td><code>mood_ids[]</code></td><td>array int</td><td>Filter ID Mood.</td></tr><tr><td><code>occasion_ids[]</code></td><td>array int</td><td>Filter ID Acara.</td></tr><tr><td><code>weather_condition_ids[]</code></td><td>array int</td><td>Filter ID Kondisi Cuaca.</td></tr><tr><td><code>dietary_restriction_ids[]</code></td><td>array int</td><td>Filter ID Batasan Diet.</td></tr><tr><td><code>cuisine_type_ids[]</code></td><td>array int</td><td>Filter ID Jenis Masakan.</td></tr></tbody></table>
                                <p>Contoh: <code>/foods/oracle-pick?category_id=1&mood_ids[]=1</code></p>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "data": { "id": 5, "name": "Nasi Goreng Jawa", /* ...beserta relasi... */ } }</code></pre>
                                <h5 class="section-subtitle">Contoh Respons Error (404 Not Found):</h5><pre><code class="language-json">{ "message": "No food found for your criteria." }</code></pre>
                            </div>
                            <div class="endpoint-item mb-4"> {{-- Copy dari GET /foods, sudah ada --}}
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> List Makanan</h3>
                                <p class="endpoint-url">/foods</p>
                                <p>Mengambil daftar semua makanan dengan pagination dan filter.</p>
                                <h5 class="section-subtitle">Query Parameters (Opsional):</h5>
                                <table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>page</code></td><td>integer</td><td>Nomor halaman.</td></tr><tr><td><code>search</code></td><td>string</td><td>Mencari nama makanan.</td></tr><tr><td><code>category_id</code></td><td>integer</td><td>Filter ID Kategori Utama.</td></tr><tr><td><code>mood_ids[]</code></td><td>array int</td><td>Filter ID Mood.</td></tr> {{-- ... tambahkan filter lain --}} </tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5><pre><code class="language-json">{ "data": [ { "id": 5, "name": "Nasi Goreng Jawa", /*...*/ } ], "links": { /*...*/ }, "meta": { /*...*/ } }</code></pre>
                            </div>

                            {{-- BARU: GET /foods/{id} --}}
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-info me-2">GET</span> Detail Makanan</h3>
                                <p class="endpoint-url">/foods/{food_id}</p>
                                <p>Mengambil detail satu makanan/minuman berdasarkan ID.</p>
                                <h5 class="section-subtitle">Path Parameters:</h5>
                                <table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>food_id</code></td><td>integer</td><td>ID dari makanan/minuman.</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
    "data": {
        "id": 5,
        "name": "Nasi Goreng Jawa",
        "description": "Nasi goreng klasik...",
        "category": { "id": 1, "name": "Sarapan", /* ... */ },
        "moods": [ { "id": 1, "name": "Senang", /* ... */ } ],
        // ... relasi lainnya
    }
}</code></pre>
                                <h5 class="section-subtitle">Contoh Respons Error (404 Not Found):</h5>
                                <pre><code class="language-json">{ "message": "Food not found." }</code></pre>
                            </div>

                            <div class="endpoint-item mb-4"> {{-- Copy dari POST /foods, sudah ada --}}
                                <h3 class="endpoint-title"><span class="badge bg-success me-2">POST</span> Buat Makanan Baru</h3>
                                <p class="endpoint-url">/foods</p>
                                <p>Membuat data makanan baru. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Request Body: <code>application/json</code></h5>
                                <table class="table table-sm table-bordered"><thead><tr><th>Parameter</th><th>Tipe</th><th>Wajib?</th><th>Deskripsi</th></tr></thead><tbody><tr><td><code>name</code></td><td>string</td><td>Ya</td><td>Nama makanan (unik).</td></tr><tr><td><code>description</code></td><td>string</td><td>Tidak</td><td>Deskripsi.</td></tr><tr><td><code>category_id</code></td><td>integer</td><td>Ya</td><td>ID Kategori Utama.</td></tr><tr><td><code>mood_ids</code></td><td>array int</td><td>Tidak</td><td>Array ID Moods.</td></tr><tr><td><code>occasion_ids</code></td><td>array int</td><td>Tidak</td><td>Array ID Occasions.</td></tr><tr><td><code>weather_condition_ids</code></td><td>array int</td><td>Tidak</td><td>Array ID Weather Conditions.</td></tr><tr><td><code>dietary_restriction_ids</code></td><td>array int</td><td>Tidak</td><td>Array ID Dietary Restrictions.</td></tr><tr><td><code>cuisine_type_ids</code></td><td>array int</td><td>Tidak</td><td>Array ID Cuisine Types.</td></tr> {{-- ... prep_time, cook_time, image_url, recipe_link_or_summary --}}</tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (201 Created):</h5><pre><code class="language-json">{ "data": { "id": 10, "name": "Mie Ayam Bakso", /* ...beserta relasi... */ } }</code></pre>
                            </div>

                            {{-- BARU: PUT /foods/{id} --}}
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-warning me-2">PUT/PATCH</span> Update Makanan</h3>
                                <p class="endpoint-url">/foods/{food_id}</p>
                                <p>Memperbarui data makanan yang sudah ada. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Path Parameters:</h5><table class="table table-sm table-bordered"><tbody><tr><td><code>food_id</code></td><td>integer</td><td>ID makanan yang akan diupdate.</td></tr></tbody></table>
                                <h5 class="section-subtitle">Request Body: <code>application/json</code></h5>
                                <p>Sama seperti POST /foods, semua field opsional kecuali yang ingin diubah.</p>
                                <h5 class="section-subtitle">Contoh Respons Sukses (200 OK):</h5>
                                <pre><code class="language-json">{
    "data": {
        "id": 5,
        "name": "Nasi Goreng Spesial Jawa",
        // ... (data makanan terupdate beserta relasi)
    }
}</code></pre>
                            </div>

                            {{-- BARU: DELETE /foods/{id} --}}
                            <div class="endpoint-item mb-4">
                                <h3 class="endpoint-title"><span class="badge bg-danger me-2">DELETE</span> Hapus Makanan</h3>
                                <p class="endpoint-url">/foods/{food_id}</p>
                                <p>Menghapus data makanan. <strong>Memerlukan Token JWT.</strong></p>
                                <h5 class="section-subtitle">Headers:</h5><ul><li><code>Authorization: Bearer <token></code></li></ul>
                                <h5 class="section-subtitle">Path Parameters:</h5><table class="table table-sm table-bordered"><tbody><tr><td><code>food_id</code></td><td>integer</td><td>ID makanan yang akan dihapus.</td></tr></tbody></table>
                                <h5 class="section-subtitle">Contoh Respons Sukses (204 No Content):</h5>
                                <p>Tidak ada body respons.</p>
                            </div>
                        </section>
                        <!-- ======================= END FOODS ======================= -->

                        <hr class="my-4">

                        <!-- ======================= OTHER CATEGORIES ======================= -->
                        <section id="other-categories" class="endpoint-section">
                            <h2 class="mb-3">Manajemen Kategori Pendukung</h2>
                            <p>Endpoint untuk mengelola data master kategori pendukung. Operasi Create, Update, Delete umumnya memerlukan autentikasi.</p>

                            {{-- MOODS --}}
                            <div class="endpoint-item mb-4">
                                <h4 class="endpoint-title text-secondary">Moods</h4>
                                <div class="ps-3">
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/moods</code> - List semua moods (dengan pagination).</p>
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/moods/{mood_id}</code> - Detail satu mood.</p>
                                    <p><span class="badge bg-success me-1">POST</span> <code class="endpoint-url">/moods</code> - Buat mood baru (Body: <code>{"name": "Nama Mood", "description": "..."}</code>). <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-warning me-1">PUT</span> <code class="endpoint-url">/moods/{mood_id}</code> - Update mood. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-danger me-1">DELETE</span> <code class="endpoint-url">/moods/{mood_id}</code> - Hapus mood. <strong>Auth Req.</strong></p>
                                </div>
                            </div>

                            {{-- OCCASIONS --}}
                            <div class="endpoint-item mb-4">
                                <h4 class="endpoint-title text-secondary">Occasions (Acara)</h4>
                                <div class="ps-3">
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/occasions</code> - List semua acara.</p>
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/occasions/{occasion_id}</code> - Detail satu acara.</p>
                                    <p><span class="badge bg-success me-1">POST</span> <code class="endpoint-url">/occasions</code> - Buat acara baru. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-warning me-1">PUT</span> <code class="endpoint-url">/occasions/{occasion_id}</code> - Update acara. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-danger me-1">DELETE</span> <code class="endpoint-url">/occasions/{occasion_id}</code> - Hapus acara. <strong>Auth Req.</strong></p>
                                </div>
                            </div>

                            {{-- WEATHER CONDITIONS --}}
                            <div class="endpoint-item mb-4">
                                <h4 class="endpoint-title text-secondary">Weather Conditions (Kondisi Cuaca)</h4>
                                <div class="ps-3">
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/weather-conditions</code> - List semua kondisi cuaca.</p>
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/weather-conditions/{weather_id}</code> - Detail satu kondisi cuaca.</p>
                                    <p><span class="badge bg-success me-1">POST</span> <code class="endpoint-url">/weather-conditions</code> - Buat kondisi cuaca baru. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-warning me-1">PUT</span> <code class="endpoint-url">/weather-conditions/{weather_id}</code> - Update kondisi cuaca. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-danger me-1">DELETE</span> <code class="endpoint-url">/weather-conditions/{weather_id}</code> - Hapus kondisi cuaca. <strong>Auth Req.</strong></p>
                                </div>
                            </div>

                            {{-- DIETARY RESTRICTIONS --}}
                            <div class="endpoint-item mb-4">
                                <h4 class="endpoint-title text-secondary">Dietary Restrictions (Batasan Diet)</h4>
                                <div class="ps-3">
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/dietary-restrictions</code> - List semua batasan diet.</p>
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/dietary-restrictions/{dietary_id}</code> - Detail satu batasan diet.</p>
                                    <p><span class="badge bg-success me-1">POST</span> <code class="endpoint-url">/dietary-restrictions</code> - Buat batasan diet baru. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-warning me-1">PUT</span> <code class="endpoint-url">/dietary-restrictions/{dietary_id}</code> - Update batasan diet. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-danger me-1">DELETE</span> <code class="endpoint-url">/dietary-restrictions/{dietary_id}</code> - Hapus batasan diet. <strong>Auth Req.</strong></p>
                                </div>
                            </div>

                            {{-- CUISINE TYPES --}}
                            <div class="endpoint-item mb-4">
                                <h4 class="endpoint-title text-secondary">Cuisine Types (Jenis Masakan)</h4>
                                <div class="ps-3">
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/cuisine-types</code> - List semua jenis masakan.</p>
                                    <p><span class="badge bg-info me-1">GET</span> <code class="endpoint-url">/cuisine-types/{cuisine_id}</code> - Detail satu jenis masakan.</p>
                                    <p><span class="badge bg-success me-1">POST</span> <code class="endpoint-url">/cuisine-types</code> - Buat jenis masakan baru. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-warning me-1">PUT</span> <code class="endpoint-url">/cuisine-types/{cuisine_id}</code> - Update jenis masakan. <strong>Auth Req.</strong></p>
                                    <p><span class="badge bg-danger me-1">DELETE</span> <code class="endpoint-url">/cuisine-types/{cuisine_id}</code> - Hapus jenis masakan. <strong>Auth Req.</strong></p>
                                </div>
                            </div>

                        </section>
                        <!-- ======================= END OTHER CATEGORIES ======================= -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Tidak ada JavaScript spesifik yang dibutuhkan untuk halaman dokumentasi statis ini --}}
@endpush