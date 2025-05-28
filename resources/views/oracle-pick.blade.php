@extends('layouts.app')

@section('title', 'Oracle Pick')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('What Should I Eat?') }}</div>

            <div class="card-body text-center">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="categoryFilter" class="form-label">Filter by Main Category:</label>
                        <select class="form-select" id="categoryFilter">
                            <option value="">-- All Main Categories --</option>
                            <!-- Opsi diisi JS -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="moodFilter" class="form-label">Filter by Mood:</label>
                        <select class="form-select" id="moodFilter">
                            <option value="">-- Any Mood --</option>
                            <!-- Opsi diisi JS -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="occasionFilter" class="form-label">Filter by Occasion:</label>
                        <select class="form-select" id="occasionFilter">
                            <option value="">-- Any Occasion --</option>
                            <!-- Opsi diisi JS -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="weatherFilter" class="form-label">Filter by Weather:</label>
                        <select class="form-select" id="weatherFilter">
                            <option value="">-- Any Weather --</option>
                            <!-- Opsi diisi JS -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="dietaryFilter" class="form-label">Filter by Dietary Restriction:</label>
                        <select class="form-select" id="dietaryFilter">
                            <option value="">-- Any Dietary Needs --</option>
                            <!-- Opsi diisi JS -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="cuisineFilter" class="form-label">Filter by Cuisine Type:</label>
                        <select class="form-select" id="cuisineFilter">
                            <option value="">-- Any Cuisine Type --</option>
                            <!-- Opsi diisi JS -->
                        </select>
                    </div>
                </div>

                <button id="getSuggestionBtn" class="btn btn-primary btn-lg mb-3">Ask the Oracle!</button>

                <div id="suggestionResult" class="mt-4" style="display: none;">
                    <h4>The Oracle Suggests:</h4>
                    <div class="card">
                        {{-- Elemen Gambar Dihapus/Dikomentari --}}
                        {{-- <img id="foodImage" src="" class="card-img-top" alt="Food Image" style="max-height: 300px; object-fit: cover; display:none;"> --}}
                        
                        <div class="card-body">
                            <h5 class="card-title" id="foodName"></h5>
                            <p class="card-text" id="foodDescription"></p>
                            <p class="card-text"><small class="text-muted" id="foodMainCategory"></small></p>
                            <div id="foodAdditionalCategories" class="mb-2">
                                <!-- Detail kategori tambahan akan ditampilkan di sini -->
                            </div>
                            
                            {{-- Tombol View Recipe/Summary Dihapus/Dikomentari --}}
                            {{-- <a id="foodRecipeLink" href="#" target="_blank" class="btn btn-info" style="display:none;">View Recipe/Summary</a> --}}
                        </div>
                    </div>
                </div>
                <div id="loadingIndicator" style="display: none;">
                    <p>Asking the Oracle...</p>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="errorResult" class="alert alert-danger mt-3" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Variabel Elemen DOM ---
        const getSuggestionBtn = document.getElementById('getSuggestionBtn');
        const suggestionResultDiv = document.getElementById('suggestionResult');
        const foodNameEl = document.getElementById('foodName');
        const foodDescriptionEl = document.getElementById('foodDescription');
        // const foodImageEl = document.getElementById('foodImage'); // Dihapus/Dikomentari
        const foodMainCategoryEl = document.getElementById('foodMainCategory');
        const foodAdditionalCategoriesEl = document.getElementById('foodAdditionalCategories');
        // const foodRecipeLinkEl = document.getElementById('foodRecipeLink'); // Dihapus/Dikomentari
        const errorResultDiv = document.getElementById('errorResult');
        const loadingIndicator = document.getElementById('loadingIndicator');

        // Filter Selects
        const categoryFilterSelect = document.getElementById('categoryFilter');
        const moodFilterSelect = document.getElementById('moodFilter');
        const occasionFilterSelect = document.getElementById('occasionFilter');
        const weatherFilterSelect = document.getElementById('weatherFilter');
        const dietaryFilterSelect = document.getElementById('dietaryFilter');
        const cuisineFilterSelect = document.getElementById('cuisineFilter');

        const apiUrl = '{{ url("/api") }}';

        // --- Fungsi Helper untuk Memuat Opsi ke Select ---
        async function loadOptionsToSelect(selectElement, endpoint, placeholder) {
            try {
                const response = await fetch(`${apiUrl}/${endpoint}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error(`Failed to load ${endpoint}`);
                
                let result = await response.json();
                let items = Array.isArray(result) ? result : (result.data || []); 

                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            } catch (error) {
                console.error(`Error loading ${endpoint}:`, error);
            }
        }

        // --- Fungsi untuk Mengambil dan Menampilkan Saran Makanan ---
        async function fetchSuggestion() {
            loadingIndicator.style.display = 'block';
            suggestionResultDiv.style.display = 'none';
            errorResultDiv.style.display = 'none';
            getSuggestionBtn.disabled = true;

            const params = new URLSearchParams();
            if (categoryFilterSelect.value) params.append('category_id', categoryFilterSelect.value);
            if (moodFilterSelect.value) params.append('mood_ids[]', moodFilterSelect.value);
            if (occasionFilterSelect.value) params.append('occasion_ids[]', occasionFilterSelect.value);
            if (weatherFilterSelect.value) params.append('weather_condition_ids[]', weatherFilterSelect.value);
            if (dietaryFilterSelect.value) params.append('dietary_restriction_ids[]', dietaryFilterSelect.value);
            if (cuisineFilterSelect.value) params.append('cuisine_type_ids[]', cuisineFilterSelect.value);

            const queryString = params.toString();
            const oraclePickUrl = `${apiUrl}/foods/oracle-pick${queryString ? '?' + queryString : ''}`;

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
                foodDescriptionEl.textContent = food.description || 'No description available.';
                foodMainCategoryEl.textContent = food.category ? `Main Category: ${food.category.name}` : 'Category: Not specified';

                // Kode untuk gambar dihapus/dikomentari
                /*
                if (food.image_url) {
                    foodImageEl.src = food.image_url;
                    foodImageEl.style.display = 'block';
                } else {
                    foodImageEl.style.display = 'none';
                }
                */
                
                // Kode untuk link resep dihapus/dikomentari
                /*
                if (food.recipe_link_or_summary) {
                    foodRecipeLinkEl.href = food.recipe_link_or_summary;
                    foodRecipeLinkEl.textContent = food.recipe_link_or_summary.startsWith('http') ? 'View Recipe' : 'View Summary';
                    foodRecipeLinkEl.style.display = 'inline-block';
                } else {
                    foodRecipeLinkEl.style.display = 'none';
                }
                */

                // Menampilkan kategori tambahan
                foodAdditionalCategoriesEl.innerHTML = ''; // Bersihkan dulu
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

                createBadgeList('Moods', food.moods);
                createBadgeList('Occasions', food.occasions);
                createBadgeList('Suits Weather', food.weather_conditions);
                createBadgeList('Dietary Info', food.dietary_restrictions);
                createBadgeList('Cuisine Types', food.cuisine_types);

                suggestionResultDiv.style.display = 'block';

            } catch (error) {
                console.error('Error fetching suggestion:', error);
                errorResultDiv.textContent = 'Oracle is busy or could not find a suggestion. Please try again. (' + error.message + ')';
                errorResultDiv.style.display = 'block';
            } finally {
                loadingIndicator.style.display = 'none';
                getSuggestionBtn.disabled = false;
            }
        }

        // --- Event Listeners & Inisialisasi ---
        getSuggestionBtn.addEventListener('click', fetchSuggestion);

        // Memuat semua opsi filter saat halaman dimuat
        loadOptionsToSelect(categoryFilterSelect, 'categories', '-- All Main Categories --');
        loadOptionsToSelect(moodFilterSelect, 'moods', '-- Any Mood --');
        loadOptionsToSelect(occasionFilterSelect, 'occasions', '-- Any Occasion --');
        loadOptionsToSelect(weatherFilterSelect, 'weather-conditions', '-- Any Weather --');
        loadOptionsToSelect(dietaryFilterSelect, 'dietary-restrictions', '-- Any Dietary Needs --');
        loadOptionsToSelect(cuisineFilterSelect, 'cuisine-types', '-- Any Cuisine Type --');
    });
</script>
@endpush