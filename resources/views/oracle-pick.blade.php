@extends('layouts.app')

@section('title', 'Pilihan Gaib Dapur')

@push('styles')
<style>
    .filter-section .form-label {
        font-weight: 500;
        margin-bottom: 0.3rem;
        font-size: 0.9rem;
    }
    .filter-section .form-select {
        font-size: 0.9rem;
    }
    .result-card {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    .result-card .card-title { /* Target ID #foodName */
        color: #0d6efd; /* Biru primer Bootstrap */
        font-weight: bold;
    }
    #getSuggestionBtn {
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }
    #getSuggestionBtn:hover {
        transform: translateY(-2px);
    }
    .badge.bg-secondary { /* Mengubah warna default badge secondary */
        background-color: #5c6ac4 !important;
    }
    #suggestionResult h4 { /* Styling untuk judul "Dapur Gaib Menyarankan" */
        font-weight: bold;
        color: #333;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-magic me-2 align-middle" viewBox="0 0 16 16">
                        <path d="M9.5 2.672a.5.5 0 1 0 1 0V.843a.5.5 0 0 0-1 0v1.829Zm4.5.035A.5.5 0 0 0 13.293 2L12 3.293a.5.5 0 1 0 .707.707L14 2.707ZM7.293 4A.5.5 0 1 0 8 3.293L6.707 2A.5.5 0 0 0 6 2.707L7.293 4Zm-.646 10.697a.5.5 0 0 0 .708 0l.5-.5a.5.5 0 0 0-.708-.707l-.5.5a.5.5 0 0 0 0 .707ZM8.5 16a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 0-1 0V15.5a.5.5 0 0 0 .5.5ZM11.5 14.672a.5.5 0 1 0 1 0V12.843a.5.5 0 0 0-1 0v1.829Zm-7.793-1.177a.5.5 0 0 0 .707 0l1.293-1.293a.5.5 0 0 0-.707-.707L2.707 14a.5.5 0 0 0 0 .707Z"/>
                        <path d="M12.5 7.465a5.45 5.45 0 1 1-1.43-1.408L11.454 7.5A.5.5 0 0 1 11 8a.5.5 0 0 1-.464-.718l.885-2.078a3.5 3.5 0 1 0-4.55 4.55L4.718 11.464A.5.5 0 0 1 4 11.5a.5.5 0 0 1-.454-.282L2.66 9.14A5.45 5.45 0 1 1 12.5 7.465Zm-4.19-.622.006-.006.006-.005a1.5 1.5 0 1 0-2.115-2.116l-.006.005-.005.006-.006.005a1.5 1.5 0 0 0 2.116 2.116Zm-2.12-2.12a.5.5 0 0 1 .708 0l1.29 1.29a.5.5 0 0 1 0 .708l-1.29 1.29a.5.5 0 1 1-.708-.708l1.29-1.29a.5.5 0 0 1 0-.708l-1.29-1.29a.5.5 0 0 1 .708 0Z"/>
                    </svg> {{ __('Mau Makan Apa Hari Ini?') }}</h4>
                </div>

                <div class="card-body p-4">
                    <p class="text-muted mb-4 text-center">Pilih kriteria di bawah ini untuk membantu Dapur Gaib menemukan pilihan terbaik untukmu!</p>
                    <div class="filter-section">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="categoryFilter" class="form-label">Kategori Utama:</label>
                                <select class="form-select" id="categoryFilter">
                                    <option value="">-- Semua Kategori Utama --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="moodFilter" class="form-label">Suasana Hati (Mood):</label>
                                <select class="form-select" id="moodFilter">
                                    <option value="">-- Mood Apapun --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="occasionFilter" class="form-label">Acara:</label>
                                <select class="form-select" id="occasionFilter">
                                    <option value="">-- Acara Apapun --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="weatherFilter" class="form-label">Cuaca:</label>
                                <select class="form-select" id="weatherFilter">
                                    <option value="">-- Cuaca Apapun --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="dietaryFilter" class="form-label">Batasan Diet:</label>
                                <select class="form-select" id="dietaryFilter">
                                    <option value="">-- Kebutuhan Diet Apapun --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cuisineFilter" class="form-label">Jenis Masakan:</label>
                                <select class="form-select" id="cuisineFilter">
                                    <option value="">-- Jenis Masakan Apapun --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button id="getSuggestionBtn" class="btn btn-primary btn-lg mb-3 px-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-stars me-2 align-middle" viewBox="0 0 16 16"><path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z"/></svg>
                            Tanya Dapur Gaib!
                        </button>
                    </div>

                    <div id="suggestionResult" class="mt-4" style="display: none;">
                        <hr class="my-4">
                        <h4 class="text-center mb-3">✨ Dapur Gaib Menyarankan ✨</h4>
                        <div class="card result-card">
                            <div class="card-body">
                                <h3 class="card-title text-center mb-3" id="foodName"></h3>
                                <p class="card-text text-muted text-center" id="foodDescription"></p>
                                <hr>
                                <p class="card-text mb-1"><small class="text-muted" id="foodMainCategory"></small></p>
                                <div id="foodAdditionalCategories" class="mb-2">
                                    {{-- Badge kategori tambahan akan diisi oleh JavaScript --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="loadingIndicator" style="display: none;" class="text-center mt-4">
                        <p>Sedang bertanya pada Dapur Gaib...</p>
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Memuat...</span>
                        </div>
                    </div>
                    <div id="errorResult" class="alert alert-danger mt-4" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const getSuggestionBtn = document.getElementById('getSuggestionBtn');
        const suggestionResultDiv = document.getElementById('suggestionResult');
        const foodNameEl = document.getElementById('foodName');
        const foodDescriptionEl = document.getElementById('foodDescription');
        const foodMainCategoryEl = document.getElementById('foodMainCategory');
        const foodAdditionalCategoriesEl = document.getElementById('foodAdditionalCategories');
        const errorResultDiv = document.getElementById('errorResult');
        const loadingIndicator = document.getElementById('loadingIndicator');

        const categoryFilterSelect = document.getElementById('categoryFilter');
        const moodFilterSelect = document.getElementById('moodFilter');
        const occasionFilterSelect = document.getElementById('occasionFilter');
        const weatherFilterSelect = document.getElementById('weatherFilter');
        const dietaryFilterSelect = document.getElementById('dietaryFilter');
        const cuisineFilterSelect = document.getElementById('cuisineFilter');

        const apiUrl = '{{ url("/api") }}';

        // Tidak ada lagi currentUserName atau event 'authStatusChanged' di sini

        async function loadOptionsToSelect(selectElement, endpoint) {
            try {
                const response = await fetch(`${apiUrl}/${endpoint}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) {
                    console.error(`Gagal memuat ${endpoint}. Status: ${response.status}`);
                    throw new Error(`Gagal memuat ${endpoint}`);
                }
                let result = await response.json();
                let items = Array.isArray(result) ? result : (result.data || []);
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            } catch (error) {
                console.error(`Error memuat ${endpoint}:`, error);
            }
        }

        async function fetchSuggestion() {
            loadingIndicator.style.display = 'block';
            suggestionResultDiv.style.display = 'none';
            errorResultDiv.style.display = 'none';
            getSuggestionBtn.disabled = true;

            const params = new URLSearchParams();
            if (categoryFilterSelect.value) params.append('category_id', categoryFilterSelect.value);
            if (moodFilterSelect.value) params.append('mood_ids[]', moodFilterSelect.value); // Mengirim sebagai array
            if (occasionFilterSelect.value) params.append('occasion_ids[]', occasionFilterSelect.value);
            if (weatherFilterSelect.value) params.append('weather_condition_ids[]', weatherFilterSelect.value);
            if (dietaryFilterSelect.value) params.append('dietary_restriction_ids[]', dietaryFilterSelect.value);
            if (cuisineFilterSelect.value) params.append('cuisine_type_ids[]', cuisineFilterSelect.value);

            const queryString = params.toString();
            const oraclePickUrl = `${apiUrl}/foods/oracle-pick${queryString ? '?' + queryString : ''}`;
            // console.log('Mengambil saran dari URL:', oraclePickUrl);

            try {
                const response = await fetch(oraclePickUrl, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                const food = data.data;

                foodNameEl.textContent = food.name;
                foodDescriptionEl.textContent = food.description || 'Deskripsi tidak tersedia.';
                foodMainCategoryEl.textContent = food.category ? `Kategori Utama: ${food.category.name}` : 'Kategori: Tidak ditentukan';

                foodAdditionalCategoriesEl.innerHTML = '';
                const createBadgeList = (title, items) => {
                    if (items && items.length > 0) {
                        let listHtml = `<p class="mb-1"><strong>${title}:</strong> `;
                        items.forEach((item, index) => {
                            listHtml += `<span class="badge bg-secondary me-1">${item.name}</span>`;
                        });
                        listHtml += `</p>`;
                        foodAdditionalCategoriesEl.innerHTML += listHtml;
                    }
                };

                createBadgeList('Suasana Hati (Moods)', food.moods);
                createBadgeList('Acara', food.occasions);
                createBadgeList('Cocok untuk Cuaca', food.weather_conditions);
                createBadgeList('Info Diet', food.dietary_restrictions);
                createBadgeList('Jenis Masakan', food.cuisine_types);

                suggestionResultDiv.style.display = 'block';

            } catch (error) {
                console.error('Error mengambil saran:', error);
                errorResultDiv.textContent = 'Dapur Gaib sedang sibuk atau tidak menemukan saran. Coba lagi. (' + error.message + ')';
                errorResultDiv.style.display = 'block';
            } finally {
                loadingIndicator.style.display = 'none';
                getSuggestionBtn.disabled = false;
            }
        }

        getSuggestionBtn.addEventListener('click', fetchSuggestion);

        loadOptionsToSelect(categoryFilterSelect, 'categories');
        loadOptionsToSelect(moodFilterSelect, 'moods');
        loadOptionsToSelect(occasionFilterSelect, 'occasions');
        loadOptionsToSelect(weatherFilterSelect, 'weather-conditions');
        loadOptionsToSelect(dietaryFilterSelect, 'dietary-restrictions');
        loadOptionsToSelect(cuisineFilterSelect, 'cuisine-types');
    });
</script>
@endpush