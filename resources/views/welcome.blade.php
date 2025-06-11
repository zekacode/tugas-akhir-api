@extends('layouts.app')

@section('title', 'Selamat Datang')

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(to right, #6dd5ed, #2193b0); /* Gradien biru yang lembut */
        color: white;
        padding: 6rem 1rem;
        margin-bottom: 2rem;
        border-radius: .75rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }
    .hero-section h1 {
        font-size: 2.8rem; /* Ukuran font lebih besar */
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .hero-section .lead {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    .btn-custom-blue {
        background-color: #007bff; /* Biru primer Bootstrap */
        border-color: #007bff;
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }
    .btn-custom-blue:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: translateY(-2px);
    }
    .features-section {
        padding: 2rem 0;
    }
    .feature-icon {
        font-size: 3rem;
        color: #007bff; /* Warna ikon biru */
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="hero-section text-center">
    <div class="container">
        <h1>Selamat Datang di <span style="font-style: italic;">Dapur Gaib</span>!</h1>
        <p class="lead">Bingung mau makan apa hari ini atau untuk acara spesial? Biarkan Dapur Gaib memberikan inspirasi dan rekomendasi terbaik untukmu!</p>
        <a href="{{ route('oracle.pick.view') }}" class="btn btn-light btn-lg btn-custom-blue text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-magic me-2" viewBox="0 0 16 16">
                <path d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.646 10.697a.5.5 0 0 0 .708 0l.5-.5a.5.5 0 0 0-.708-.707l-.5.5a.5.5 0 0 0 0 .707ZM8.5 16a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 0-1 0V15.5a.5.5 0 0 0 .5.5ZM11.5 14.672a.5.5 0 1 0 1 0V12.843a.5.5 0 0 0-1 0v1.829Zm-7.793-1.177a.5.5 0 0 0 .707 0l1.293-1.293a.5.5 0 0 0-.707-.707L2.707 14a.5.5 0 0 0 0 .707Z"/>
                <path d="M12.5 7.465a5.45 5.45 0 1 1-1.43-1.408L11.454 7.5A.5.5 0 0 1 11 8a.5.5 0 0 1-.464-.718l.885-2.078a3.5 3.5 0 1 0-4.55 4.55L4.718 11.464A.5.5 0 0 1 4 11.5a.5.5 0 0 1-.454-.282L2.66 9.14A5.45 5.45 0 1 1 12.5 7.465Zm-4.19-.622.006-.006.006-.005a1.5 1.5 0 1 0-2.115-2.116l-.006.005-.005.006-.006.005a1.5 1.5 0 0 0 2.116 2.116Zm-2.12-2.12a.5.5 0 0 1 .708 0l1.29 1.29a.5.5 0 0 1 0 .708l-1.29 1.29a.5.5 0 1 1-.708-.708l1.29-1.29a.5.5 0 0 1 0-.708l-1.29-1.29a.5.5 0 0 1 .708 0Z"/>
            </svg>
            Tanya Dapur Gaib Sekarang!
        </a>
    </div>
</div>

<div class="container features-section">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-shuffle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 3.5A.5.5 0 0 1 .5 3H1c2.202 0 3.827 1.24 4.874 2.418.49.552.865 1.102 1.126 1.532.26-.43.636-.98 1.126-1.532C9.173 4.24 10.798 3 13 3h.5a.5.5 0 0 1 0 1H13c-1.798 0-3.173 1.01-4.126 2.082A9.624 9.624 0 0 0 7.556 8a9.624 9.624 0 0 0 1.317 1.918C9.828 10.99 11.202 12 13 12h.5a.5.5 0 0 1 0 1H13c-2.202 0-3.827-1.24-4.874-2.418A10.595 10.595 0 0 1 7 9.05c-.26.43-.636.98-1.126 1.532C4.827 11.76 3.202 13 1 13H.5a.5.5 0 0 1 0-1H1c1.798 0 3.173-1.01 4.126-2.082A9.624 9.624 0 0 0 6.444 8a9.624 9.624 0 0 0-1.317-1.918C4.172 5.01 2.798 4 1 4H.5a.5.5 0 0 1-.5-.5z"/>
                    <path d="M13 5.466V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192zm0 9V9.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192z"/>
                </svg>
            </div>
            <h3>Rekomendasi Acak</h3>
            <p>Dapatkan kejutan rekomendasi makanan atau minuman saat Anda benar-benar tidak tahu harus memilih apa.</p>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                </svg>
            </div>
            <h3>Filter Lengkap</h3>
            <p>Sesuaikan pencarian berdasarkan kategori, suasana hati, acara, cuaca, batasan diet, hingga jenis masakan.</p>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                    <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.303.49-.59.79-.86C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                </svg>
            </div>
            <h3>Personalisasi (Segera Hadir)</h3>
            <p>Simpan favoritmu, lihat riwayat pilihan, dan dapatkan rekomendasi yang semakin sesuai dengan seleramu.</p>
        </div>
    </div>
</div>
@endsection