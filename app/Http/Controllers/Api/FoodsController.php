<?php

// app/Http/Controllers/Api/FoodsController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Foods; 
use App\Models\Mood;
use Illuminate\Http\Request;
use App\Http\Resources\FoodsResource; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FoodsController extends Controller 
{
    public function index(Request $request)
    {
        $query = Foods::with('category', 'moods'); 

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Opsional: Filter berdasarkan mood_id jika dikirim sebagai array atau tunggal
        if ($request->has('mood_id')) {
            $moodId = $request->mood_id;
            $query->whereHas('moods', function ($q) use ($moodId) {
                if (is_array($moodId)) {
                    $q->whereIn('moods.id', $moodId); // Jika mood_id adalah array
                } else {
                    $q->where('moods.id', $moodId); // Jika mood_id tunggal
                }
            });
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
            'name' => 'required|string|max:255|unique:foods,name', // Sesuaikan nama tabel
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'recipe_link_or_summary' => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'cook_time_minutes' => 'nullable|integer|min:0',
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'mood_ids' => 'nullable|array', // Moods akan dikirim sebagai array ID
            'mood_ids.*' => ['integer', Rule::exists('moods', 'id')] // Validasi setiap ID dalam array mood_ids
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $foodItem = Foods::create($request->except('mood_ids'));

        // Asosiasikan dengan mood jika ada
        if ($request->has('mood_ids')) {
            $foodItem->moods()->sync($request->input('mood_ids'));
        }

        return response()->json(new FoodsResource($foodItem->load(['category', 'moods'])), 201);
    }

    public function show(Foods $food) 
    {
        // Eager load category dan moods
        return new FoodsResource($food->load(['category', 'moods']));
    }

    public function update(Request $request, Foods $food) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:foods,name,' . $food->id, // Sesuaikan nama tabel
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'recipe_link_or_summary' => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'cook_time_minutes' => 'nullable|integer|min:0',
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'mood_ids' => 'nullable|array',
            'mood_ids.*' => ['integer', Rule::exists('moods', 'id')]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $food->update($request->except('mood_ids'));

        // Sinkronkan relasi moods (bisa juga attach/detach jika logikanya beda)
        // sync() akan menghapus relasi lama dan menambahkan yang baru dari array
        if ($request->has('mood_ids')) {
            $food->moods()->sync($request->input('mood_ids'));
        } else {
            // Jika tidak ada mood_ids dikirim, hapus semua relasi mood yang ada
            $food->moods()->detach();
        }

        return new FoodsResource($food->load(['category', 'moods']));
    }

    public function destroy(Foods $food) 
    {
        // Relasi di tabel pivot (food_mood) akan otomatis terhapus karena onDelete('cascade')
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
        $query = Foods::with('category', 'moods'); // Eager load category

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

        if ($request->has('mood_id') && !empty($request->mood_id)) {
            $moodValidator = Validator::make($request->all(), [
                'mood_id' => ['integer', Rule::exists('moods', 'id')],
            ]);
            if ($moodValidator->fails()) {
                return response()->json(['errors' => $moodValidator->errors()], 422);
            }
            // Filter makanan yang memiliki mood_id tertentu
            $query->whereHas('moods', function ($q) use ($request) {
                $q->where('moods.id', $request->mood_id);
            });
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