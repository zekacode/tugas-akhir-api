<?php

// app/Http/Controllers/Api/AuthController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Hapus use Illuminate\Support\Facades\Auth; jika tidak digunakan lagi secara langsung
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException; // Import exception
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class AuthController extends Controller
{
    // Constructor bisa dikosongkan atau dihapus karena middleware diatur di route
    // public function __construct()
    // {
    // }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized: Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ], 201);
    }

    public function me() // Tidak perlu Request $request jika route sudah diproteksi middleware auth:api
    {
        try {
            // Middleware 'auth:api' seharusnya sudah memastikan token valid dan user ada
            // Jadi, auth('api')->user() juga bisa dipertimbangkan di sini.
            // Namun, parseToken()->authenticate() lebih eksplisit untuk JWT.
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token has expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token is invalid'], 401);
        } catch (JWTException $e) {
            // Ini terjadi jika token tidak ada atau ada masalah saat parsing,
            // tapi middleware auth:api seharusnya sudah menangani token absent.
            return response()->json(['message' => 'Token is absent or unprocessable'], 401);
        }

        return response()->json($user);
    }

    public function logout() // Tidak perlu Request $request jika token diambil dari parseToken()
    {
        try {
            JWTAuth::parseToken()->invalidate(true); // Invalidate the token and add to blacklist
            return response()->json(['message' => 'Successfully logged out']);
        } catch (TokenExpiredException $e) {
            // Jika token sudah expired, anggap saja sudah logout
            return response()->json(['message' => 'Token already expired, considered logged out.'], 200);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token is invalid.'], 401);
        } catch (JWTException $e) {
            // Token tidak ada atau tidak bisa di-parse, anggap sudah logout atau error
            return response()->json(['message' => 'Token is absent or unprocessable, cannot logout.'], 401);
        }
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return $this->respondWithToken($newToken);
        } catch (TokenExpiredException $e) {
            // Jika token refresh juga sudah expired atau token lama tidak bisa di-refresh
            return response()->json(['message' => 'Token cannot be refreshed, it may have expired blacklist window'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Token is invalid, cannot refresh.'], 401);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token is absent or unprocessable, cannot refresh.'], 401);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            // Opsional: Kembalikan juga data user saat login jika diinginkan
            // 'user' => auth('api')->user() // Pastikan ini dipanggil setelah token berhasil dibuat/di-attempt
        ]);
    }
}