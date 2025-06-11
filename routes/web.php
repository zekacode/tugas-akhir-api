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
})->name('oracle.pick.view'); // <-- DIPINDAHKAN KE LUAR GRUP API

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('api')->group(function () {
    // Mood Routes
    Route::get('moods', [MoodController::class, 'index']);

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

    // Category Routes
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::middleware('auth:api')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });

    // Food Routes
    Route::get('foods/oracle-pick', [FoodsController::class, 'oraclePick'])->name('foods.oraclePick'); // Ini adalah endpoint API, jadi tetap di sini
    Route::get('foods', [FoodsController::class, 'index']);
    Route::get('foods/{food}', [FoodsController::class, 'show'])->name('foods.show');
    Route::middleware('auth:api')->group(function () {
        Route::post('foods', [FoodsController::class, 'store']);
        Route::put('foods/{food}', [FoodsController::class, 'update'])->name('foods.update');
        Route::delete('foods/{food}', [FoodsController::class, 'destroy'])->name('foods.destroy');
    });

    // Occasion Routes
    Route::get('occasions', [OccasionController::class, 'index']);

     // WeatherCondition Routes
    Route::get('weather-conditions', [WeatherConditionController::class, 'index']);

    // DietaryRestriction Routes
    Route::get('dietary-restrictions', [DietaryRestrictionController::class, 'index']);

    // CuisineType Routes
    Route::get('cuisine-types', [CuisineTypeController::class, 'index']);
});