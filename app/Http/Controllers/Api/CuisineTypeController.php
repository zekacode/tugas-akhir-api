<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CuisineType;
use Illuminate\Http\Request;
use App\Http\Resources\CuisineTypeResource;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Validation\Rule; // Import Rule

class CuisineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/cuisine-types
     */
    public function index()
    {
        // Bisa ditambahkan pagination jika datanya banyak
        $cuisineTypes = CuisineType::latest()->paginate(10);
        // return CuisineTypeResource::collection($cuisineTypes);
        // Atau respons pagination lengkap:
        return response()->json([
            'data' => CuisineTypeResource::collection($cuisineTypes),
            'meta' => [
                'current_page' => $cuisineTypes->currentPage(),
                'last_page' => $cuisineTypes->lastPage(),
                'per_page' => $cuisineTypes->perPage(),
                'total' => $cuisineTypes->total(),
            ],
            'links' => [
                'first' => $cuisineTypes->url(1),
                'last' => $cuisineTypes->url($cuisineTypes->lastPage()),
                'prev' => $cuisineTypes->previousPageUrl(),
                'next' => $cuisineTypes->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/cuisine-types
     * Memerlukan autentikasi
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cuisine_types,name',
            'description' => 'nullable|string|max:255',
            'country_of_origin' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cuisineType = CuisineType::create($request->all());

        return response()->json(new CuisineTypeResource($cuisineType), 201); // 201 Created
    }

    /**
     * Display the specified resource.
     * GET /api/cuisine-types/{cuisineType}
     */
    public function show(CuisineType $cuisineType) // Route model binding
    {
        return new CuisineTypeResource($cuisineType);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/cuisine-types/{cuisineType}
     * Memerlukan autentikasi
     */
    public function update(Request $request, CuisineType $cuisineType) // Route model binding
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('cuisine_types')->ignore($cuisineType->id)],
            'description' => 'nullable|string|max:255',
            'country_of_origin' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cuisineType->update($request->all());

        return new CuisineTypeResource($cuisineType);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/cuisine-types/{cuisineType}
     * Memerlukan autentikasi
     */
    public function destroy(CuisineType $cuisineType) // Route model binding
    {
        // Pertimbangkan penanganan jika CuisineType ini masih berelasi dengan Foods
        // if ($cuisineType->foods()->exists()) {
        //     return response()->json(['error' => 'Cuisine type cannot be deleted because it is associated with foods.'], 409); // Conflict
        // }

        $cuisineType->delete();

        return response()->json(null, 204); // 204 No Content
    }
}