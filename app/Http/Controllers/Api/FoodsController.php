<?php

// app/Http/Controllers/Api/FoodsController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Foods; 
use Illuminate\Http\Request;
use App\Http\Resources\FoodsResource; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FoodsController extends Controller 
{
    public function index(Request $request)
    {
        $query = Foods::with('category'); 

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foodsData = $query->latest()->paginate(10)->withQueryString();

        return response()->json([
            'data' => FoodsResource::collection($foodsData), 
            'meta' => [
                'current_page' => $foodsData->currentPage(),
                'last_page' => $foodsData->lastPage(),
                'per_page' => $foodsData->perPage(),
                'total' => $foodsData->total(),
            ],
            'links' => [
                'first' => $foodsData->url(1),
                'last' => $foodsData->url($foodsData->lastPage()),
                'prev' => $foodsData->previousPageUrl(),
                'next' => $foodsData->nextPageUrl(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:foods,name', 
            'description' => 'nullable|string',
            // ... (validasi lain sama)
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $foodItem = Foods::create($request->all()); 

        return response()->json(new FoodsResource($foodItem->load('category')), 201);
    }

    public function show(Foods $food) 
    {
        return new FoodsResource($food->load('category'));
    }

    public function update(Request $request, Foods $food) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:foods,name,' . $food->id, 
            // ... (validasi lain sama)
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $food->update($request->all());

        return new FoodsResource($food->load('category'));
    }

    public function destroy(Foods $food) 
    {
        $food->delete();
        return response()->json(null, 204);
    }

    /**
     * Provide a random food suggestion.
     * Optionally filter by category_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function oraclePick(Request $request)
    {
        $query = Foods::with('category'); // Eager load category

        // Opsional: Filter berdasarkan category_id jika disediakan di query parameter
        if ($request->has('category_id') && !empty($request->category_id)) {
            $validator = Validator::make($request->all(), [
                'category_id' => ['integer', Rule::exists('categories', 'id')],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $query->where('category_id', $request->category_id);
        }

        // Ambil satu makanan secara acak
        $randomFood = $query->inRandomOrder()->first();

        if (!$randomFood) {
            // Jika tidak ada makanan yang cocok (misal filter kategori tidak menghasilkan apa-apa)
            return response()->json(['message' => 'No food found for your criteria.'], 404);
        }

        return new FoodsResource($randomFood);
    }
}