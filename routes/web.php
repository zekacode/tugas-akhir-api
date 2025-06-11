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
    Route::apiResource('categories', CategoryController::class)
        ->middleware('auth:api', ['except' => ['index', 'show']]);

    // Food Routes
    Route::get('foods/oracle-pick', [FoodsController::class, 'oraclePick'])->name('foods.oraclePick');
    

    // Definisi manual untuk FoodsController (seperti yang sudah ada, ini sudah baik)
    Route::get('foods', [FoodsController::class, 'index']);
    Route::get('foods/{food}', [FoodsController::class, 'show'])->name('foods.show'); // Menambahkan name agar konsisten
    Route::middleware('auth:api')->group(function () {
        Route::post('foods', [FoodsController::class, 'store']);
        Route::put('foods/{food}', [FoodsController::class, 'update'])->name('foods.update');
        Route::delete('foods/{food}', [FoodsController::class, 'destroy'])->name('foods.destroy');
    });


    // === KATEGORI PENDUKUNG MENGGUNAKAN apiResource ===

    // Mood Routes
    Route::apiResource('moods', MoodController::class)
        ->middleware('auth:api', ['except' => ['index', 'show']]);

    // Occasion Routes
    Route::apiResource('occasions', OccasionController::class)
        ->middleware('auth:api', ['except' => ['index', 'show']]);

    // WeatherCondition Routes
    Route::apiResource('weather-conditions', WeatherConditionController::class)
        ->middleware('auth:api', ['except' => ['index', 'show']]);

    // DietaryRestriction Routes
    Route::apiResource('dietary-restrictions', DietaryRestrictionController::class)
        ->middleware('auth:api', ['except' => ['index', 'show']]);

    // CuisineType Routes
    Route::apiResource('cuisine-types', CuisineTypeController::class)
        ->middleware('auth:api', ['except' => ['index', 'show']]);

});