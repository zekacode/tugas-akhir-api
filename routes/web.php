// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;

// Route web standar Anda (jika ada)
Route::get('/', function () {
    return view('welcome');
});

// ==================================================
// ==            DEFINISI ROUTE API DI SINI        ==
// ==================================================
Route::prefix('api')->group(function () { // Semua route API akan memiliki prefix /api

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
});