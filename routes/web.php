<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FoodsController;
use App\Http\Controllers\Api\MoodController;
use App\Http\Controllers\Api\OccasionController;
use App\Http\Controllers\Api\DietaryRestrictionController;
use App\Http\Controllers\Api\WeatherConditionController;
use App\Http\Controllers\Api\CuisineTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// === WEB ROUTES (UNTUK HALAMAN HTML / FRONTEND) ===
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route untuk halaman Dokumentasi API
Route::get('/api-documentation', function () {
    return view('api-documentation');
})->name('api.documentation');

// Route untuk halaman Oracle Pick (Frontend)
Route::get('/oracle-pick', function () {
    return view('oracle-pick');
})->name('oracle.pick.view');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('api')->group(function () {

    // Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::get('me', [AuthController::class, 'me']);
        });
    });

    // Category Routes (Kategori Utama Makanan)
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::middleware('auth:api')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });

    // Food Routes
    Route::get('foods/oracle-pick', [FoodsController::class, 'oraclePick'])->name('foods.oraclePick');
    Route::get('foods', [FoodsController::class, 'index']);
    Route::get('foods/{food}', [FoodsController::class, 'show'])->name('foods.show');
    Route::middleware('auth:api')->group(function () {
        Route::post('foods', [FoodsController::class, 'store']);
        Route::put('foods/{food}', [FoodsController::class, 'update'])->name('foods.update');
        Route::delete('foods/{food}', [FoodsController::class, 'destroy'])->name('foods.destroy');
    });


    // === KATEGORI PENDUKUNG DENGAN ROUTE MANUAL ===

    // Mood Routes
    Route::get('moods', [MoodController::class, 'index']);
    Route::get('moods/{mood}', [MoodController::class, 'show']); // Asumsi method show ada di MoodController
    Route::middleware('auth:api')->group(function () {
        Route::post('moods', [MoodController::class, 'store']);
        Route::put('moods/{mood}', [MoodController::class, 'update']);
        Route::delete('moods/{mood}', [MoodController::class, 'destroy']);
    });

    // Occasion Routes
    Route::get('occasions', [OccasionController::class, 'index']);
    Route::get('occasions/{occasion}', [OccasionController::class, 'show']);
    Route::middleware('auth:api')->group(function () {
        Route::post('occasions', [OccasionController::class, 'store']);
        Route::put('occasions/{occasion}', [OccasionController::class, 'update']);
        Route::delete('occasions/{occasion}', [OccasionController::class, 'destroy']);
    });

    // WeatherCondition Routes
    Route::get('weather-conditions', [WeatherConditionController::class, 'index']);
    Route::get('weather-conditions/{weatherCondition}', [WeatherConditionController::class, 'show']);
    Route::middleware('auth:api')->group(function () {
        Route::post('weather-conditions', [WeatherConditionController::class, 'store']);
        Route::put('weather-conditions/{weatherCondition}', [WeatherConditionController::class, 'update']);
        Route::delete('weather-conditions/{weatherCondition}', [WeatherConditionController::class, 'destroy']);
    });

    // DietaryRestriction Routes
    Route::get('dietary-restrictions', [DietaryRestrictionController::class, 'index']);
    Route::get('dietary-restrictions/{dietaryRestriction}', [DietaryRestrictionController::class, 'show']);
    Route::middleware('auth:api')->group(function () {
        Route::post('dietary-restrictions', [DietaryRestrictionController::class, 'store']);
        Route::put('dietary-restrictions/{dietaryRestriction}', [DietaryRestrictionController::class, 'update']);
        Route::delete('dietary-restrictions/{dietaryRestriction}', [DietaryRestrictionController::class, 'destroy']);
    });

    // CuisineType Routes
    Route::get('cuisine-types', [CuisineTypeController::class, 'index']);
    Route::get('cuisine-types/{cuisineType}', [CuisineTypeController::class, 'show']);
    Route::middleware('auth:api')->group(function () {
        Route::post('cuisine-types', [CuisineTypeController::class, 'store']);
        Route::put('cuisine-types/{cuisineType}', [CuisineTypeController::class, 'update']);
        Route::delete('cuisine-types/{cuisineType}', [CuisineTypeController::class, 'destroy']);
    });

});