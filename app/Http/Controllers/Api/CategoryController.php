<?php

// app/Http/Controllers/Api/CategoryController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource; // <-- Import resource
use Illuminate\Support\Facades\Validator; // <-- Import Validator

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua kategori, mungkin dengan pagination jika datanya banyak
        $categories = Category::latest()->paginate(10); // Contoh: 10 per halaman, urut terbaru
        // return CategoryResource::collection($categories); // Gunakan collection untuk list
        // Jika ingin output pagination yang lebih lengkap:
        return response()->json([
            'data' => CategoryResource::collection($categories),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ],
            'links' => [
                'first' => $categories->url(1),
                'last' => $categories->url($categories->lastPage()),
                'prev' => $categories->previousPageUrl(),
                'next' => $categories->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Unprocessable Entity
        }

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json(new CategoryResource($category), 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) // Route model binding
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category) // Route model binding
    {
        $validator = Validator::make($request->all(), [
            // Unique rule di-ignore untuk ID category saat ini
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category) // Route model binding
    {
        // Handle jika kategori memiliki makanan terkait (opsional, tergantung kebijakan)
        // if ($category->foods()->count() > 0) {
        //     return response()->json(['error' => 'Category cannot be deleted because it has associated foods.'], 409); // Conflict
        // }

        $category->delete();

        return response()->json(null, 204); // 204 No Content
    }
}