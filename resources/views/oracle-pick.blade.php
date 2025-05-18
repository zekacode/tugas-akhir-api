@extends('layouts.app')

@section('title', 'Oracle Pick')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('What Should I Eat?') }}</div>

            <div class="card-body text-center">
                <div class="mb-3">
                    <label for="categoryFilter" class="form-label">Filter by Category (Optional):</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="">-- All Categories --</option>
                        <!-- Opsi kategori akan diisi oleh JavaScript -->
                    </select>
                </div>

                <button id="getSuggestionBtn" class="btn btn-primary btn-lg mb-3">Ask the Oracle!</button>

                <div id="suggestionResult" class="mt-4" style="display: none;">
                    <h4>The Oracle Suggests:</h4>
                    <div class="card">
                        <img id="foodImage" src="" class="card-img-top" alt="Food Image" style="max-height: 300px; object-fit: cover; display:none;">
                        <div class="card-body">
                            <h5 class="card-title" id="foodName"></h5>
                            <p class="card-text" id="foodDescription"></p>
                            <p class="card-text"><small class="text-muted" id="foodCategory"></small></p>
                            <a id="foodRecipeLink" href="#" target="_blank" class="btn btn-info" style="display:none;">View Recipe/Summary</a>
                        
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
        const getSuggestionBtn = document.getElementById('getSuggestionBtn');
        const suggestionResultDiv = document.getElementById('suggestionResult');
        const foodNameEl = document.getElementById('foodName');
        const foodDescriptionEl = document.getElementById('foodDescription');
        const foodImageEl = document.getElementById('foodImage');
        const foodCategoryEl = document.getElementById('foodCategory');
        const foodRecipeLinkEl = document.getElementById('foodRecipeLink');
        const errorResultDiv = document.getElementById('errorResult');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const categoryFilterSelect = document.getElementById('categoryFilter');

        const apiUrl = '{{ url("/api") }}'; // Base URL API Anda

        // Fungsi untuk mengambil dan menampilkan saran makanan
        async function fetchSuggestion() {
            loadingIndicator.style.display = 'block';
            suggestionResultDiv.style.display = 'none';
            errorResultDiv.style.display = 'none';
            getSuggestionBtn.disabled = true;

            let oraclePickUrl = `${apiUrl}/foods/oracle-pick`;
            const selectedCategoryId = categoryFilterSelect.value;
            if (selectedCategoryId) {
                oraclePickUrl += `?category_id=${selectedCategoryId}`;
            }

            try {
                const response = await fetch(oraclePickUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                const food = data.data; // Karena kita menggunakan FoodResource

                foodNameEl.textContent = food.name;
                foodDescriptionEl.textContent = food.description || 'No description available.';
                foodCategoryEl.textContent = food.category ? `Category: ${food.category.name}` : 'Category: Not specified';

                if (food.image_url) {
                    foodImageEl.src = food.image_url;
                    foodImageEl.style.display = 'block';
                } else {
                    foodImageEl.style.display = 'none';
                }
                
                if (food.recipe_link_or_summary) {
                    foodRecipeLinkEl.href = food.recipe_link_or_summary; // Asumsi ini link, sesuaikan jika ini summary
                    foodRecipeLinkEl.textContent = food.recipe_link_or_summary.startsWith('http') ? 'View Recipe' : 'View Summary';
                    foodRecipeLinkEl.style.display = 'inline-block';
                } else {
                    foodRecipeLinkEl.style.display = 'none';
                }

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

        // Fungsi untuk memuat kategori ke dropdown
        async function loadCategories() {
            try {
                const response = await fetch(`${apiUrl}/categories`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (!response.ok) throw new Error('Failed to load categories');
                const result = await response.json(); // Mengambil data dari properti 'data'
                const categories = result.data;


                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categoryFilterSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading categories:', error);
                // Mungkin tampilkan pesan error ke pengguna
            }
        }

        getSuggestionBtn.addEventListener('click', fetchSuggestion);
        loadCategories(); // Panggil fungsi untuk memuat kategori saat halaman dimuat
    });
</script>
@endpush