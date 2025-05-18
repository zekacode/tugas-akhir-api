
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FoodsController;
use App\Http\Controllers\Api\MoodController;

// routes/web.php
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================================================
// ==            DEFINISI ROUTE API DI SINI        ==
// ==================================================
Route::prefix('api')->group(function () { // Semua route API akan memiliki prefix /api

    // Mood Routes
    Route::get('moods', [MoodController::class, 'index']);

    // Auth Routes (Publik untuk API, tidak perlu CSRF, tidak perlu session state)
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        // Routes di bawah ini memerlukan token JWT yang valid
        // Middleware 'auth:api' akan memastikan ini
        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::get('me', [AuthController::class, 'me']);
        });
    });

    // Category Routes
    // Endpoint publik untuk melihat kategori
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    // Endpoint terproteksi JWT untuk mengelola kategori
    Route::middleware('auth:api')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']); // Bisa juga Route::patch
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

    // Route untuk halaman Oracle Pick
    Route::get('/oracle-pick', function () {
        return view('oracle-pick');
    })->name('oracle.pick.view');
});