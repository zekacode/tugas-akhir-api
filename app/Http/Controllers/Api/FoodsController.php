<?php

// app/Http/Controllers/Api/FoodsController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Foods; 
use App\Models\Category; 
use App\Models\Mood;
use App\Models\Occasion;
use App\Models\WeatherCondition;
use App\Models\DietaryRestriction;
use App\Models\CuisineType;
use Illuminate\Http\Request;
use App\Http\Resources\FoodsResource; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; 

class FoodsController extends Controller
{
    // Relasi yang akan di-eager load secara default
    protected $relationsToLoad = [
        'category', 'moods', 'occasions',
        'weatherConditions', 'dietaryRestrictions', 'cuisineTypes'
    ];

    public function index(Request $request)
    {
        $query = Foods::with($this->relationsToLoad);

        // Filtering by category_id
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        // Searching by name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Helper function untuk filter many-to-many
        $applyManyToManyFilter = function ($query, $relationName, $requestKey, $tableName) {
            if ($request->has($requestKey) && !empty($request->input($requestKey))) {
                $ids = is_array($request->input($requestKey)) ? $request->input($requestKey) : [$request->input($requestKey)];
                $validIds = array_filter($ids, 'is_numeric'); // Pastikan hanya angka
                if (!empty($validIds)) {
                    // Jika ingin makanan yang memiliki SEMUA ID yang dipilih (AND)
                    // foreach ($validIds as $id) {
                    //     $query->whereHas($relationName, function ($q) use ($id, $tableName) {
                    //         $q->where($tableName.'.id', $id);
                    //     });
                    // }
                    // Jika ingin makanan yang memiliki SALAH SATU ID yang dipilih (OR)
                    $query->whereHas($relationName, function ($q) use ($validIds, $tableName) {
                        $q->whereIn($tableName.'.id', $validIds);
                    });
                }
            }
        };

        $applyManyToManyFilter($query, 'moods', 'mood_ids', 'moods'); // parameter 'mood_ids'
        $applyManyToManyFilter($query, 'occasions', 'occasion_ids', 'occasions');
        $applyManyToManyFilter($query, 'weatherConditions', 'weather_condition_ids', 'weather_conditions');
        $applyManyToManyFilter($query, 'dietaryRestrictions', 'dietary_restriction_ids', 'dietary_restrictions');
        $applyManyToManyFilter($query, 'cuisineTypes', 'cuisine_type_ids', 'cuisine_types');

        $foodsData = $query->latest()->paginate(10)->withQueryString();

        return response()->json([
            'data' => FoodsResource::collection($foodsData),
            'meta' => [ /* ... pagination meta ... */ ],
            'links' => [ /* ... pagination links ... */ ],
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
            'mood_ids' => 'nullable|array',
            'mood_ids.*' => ['integer', Rule::exists('moods', 'id')],
            'occasion_ids' => 'nullable|array',
            'occasion_ids.*' => ['integer', Rule::exists('occasions', 'id')],
            'weather_condition_ids' => 'nullable|array',
            'weather_condition_ids.*' => ['integer', Rule::exists('weather_conditions', 'id')],
            'dietary_restriction_ids' => 'nullable|array',
            'dietary_restriction_ids.*' => ['integer', Rule::exists('dietary_restrictions', 'id')],
            'cuisine_type_ids' => 'nullable|array',
            'cuisine_type_ids.*' => ['integer', Rule::exists('cuisine_types', 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Gunakan DB Transaction untuk memastikan konsistensi data
        // DB::beginTransaction();
        // try {
            $foodItemData = $request->except([
                'mood_ids', 'occasion_ids', 'weather_condition_ids',
                'dietary_restriction_ids', 'cuisine_type_ids'
            ]);
            $foodItem = Foods::create($foodItemData);

            // Sync relasi
            if ($request->has('mood_ids')) $foodItem->moods()->sync($request->input('mood_ids'));
            if ($request->has('occasion_ids')) $foodItem->occasions()->sync($request->input('occasion_ids'));
            if ($request->has('weather_condition_ids')) $foodItem->weatherConditions()->sync($request->input('weather_condition_ids'));
            if ($request->has('dietary_restriction_ids')) $foodItem->dietaryRestrictions()->sync($request->input('dietary_restriction_ids'));
            if ($request->has('cuisine_type_ids')) $foodItem->cuisineTypes()->sync($request->input('cuisine_type_ids'));

        //     DB::commit();
            return response()->json(new FoodsResource($foodItem->load($this->relationsToLoad)), 201);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['message' => 'Failed to create food item.', 'error' => $e->getMessage()], 500);
        // }
    }

    public function show(Foods $food) // Sesuaikan type-hint
    {
        return new FoodsResource($food->load($this->relationsToLoad));
    }

    public function update(Request $request, Foods $food) // Sesuaikan type-hint
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:foods,name,' . $food->id, // Sesuaikan nama tabel
            'description' => 'nullable|string',
            // ... (validasi lain sama seperti store) ...
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'mood_ids' => 'nullable|array',
            'mood_ids.*' => ['integer', Rule::exists('moods', 'id')],
            'occasion_ids' => 'nullable|array',
            'occasion_ids.*' => ['integer', Rule::exists('occasions', 'id')],
            'weather_condition_ids' => 'nullable|array',
            'weather_condition_ids.*' => ['integer', Rule::exists('weather_conditions', 'id')],
            'dietary_restriction_ids' => 'nullable|array',
            'dietary_restriction_ids.*' => ['integer', Rule::exists('dietary_restrictions', 'id')],
            'cuisine_type_ids' => 'nullable|array',
            'cuisine_type_ids.*' => ['integer', Rule::exists('cuisine_types', 'id')],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // DB::beginTransaction();
        // try {
            $foodItemData = $request->except([
                'mood_ids', 'occasion_ids', 'weather_condition_ids',
                'dietary_restriction_ids', 'cuisine_type_ids'
            ]);
            $food->update($foodItemData);

            // Helper function untuk sync atau detach
            $syncOrDetach = function ($relationName, $requestKey) use ($request, $food) {
                if ($request->has($requestKey)) {
                    $food->{$relationName}()->sync($request->input($requestKey, [])); // [] jika key ada tapi kosong
                } else {
                }
            };

            $syncOrDetach('moods', 'mood_ids');
            $syncOrDetach('occasions', 'occasion_ids');
            $syncOrDetach('weatherConditions', 'weather_condition_ids');
            $syncOrDetach('dietaryRestrictions', 'dietary_restriction_ids');
            $syncOrDetach('cuisineTypes', 'cuisine_type_ids');

        //     DB::commit();
            return new FoodsResource($food->load($this->relationsToLoad));
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['message' => 'Failed to update food item.', 'error' => $e->getMessage()], 500);
        // }
    }

    public function destroy(Foods $food) { /* ... (tetap sama) ... */ }

    public function oraclePick(Request $request)
    {
        $query = Foods::with($this->relationsToLoad);

        // Validasi dan filter untuk setiap kategori
        $validateAndApplyFilter = function ($query, $requestKey, $relationName, $tableName, $modelClass) use ($request) {
            if ($request->has($requestKey) && !empty($request->input($requestKey))) {
                $ids = is_array($request->input($requestKey)) ? $request->input($requestKey) : [$request->input($requestKey)];
                $validator = Validator::make([$requestKey => $ids], [
                    $requestKey => 'array',
                    $requestKey.'.*' => ['integer', Rule::exists($tableName, 'id')],
                ]);
                if ($validator->fails()) {
                    // Mungkin throw exception atau return error response
                    // Untuk oracle pick, kita bisa abaikan filter jika tidak valid, atau return error
                    // return response()->json(['errors' => $validator->errors()], 422); // Opsi 1: Return error
                    return null; // Opsi 2: Abaikan filter ini (atau set flag error)
                }
                $query->whereHas($relationName, function ($q) use ($ids, $tableName) {
                     $q->whereIn($tableName.'.id', $ids); // Mengambil makanan yang memiliki SALAH SATU ID yang dipilih
                });
            }
            return $query; // Kembalikan query agar bisa di-chain
        };

        if ($request->has('category_id')) { // Filter category_id (one-to-many)
            $validator = Validator::make($request->all(), ['category_id' => ['integer', Rule::exists('categories', 'id')]]);
            if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
            $query->where('category_id', $request->category_id);
        }

        $query = $validateAndApplyFilter($query, 'mood_ids', 'moods', 'moods', Mood::class) ?? $query;
        $query = $validateAndApplyFilter($query, 'occasion_ids', 'occasions', 'occasions', Occasion::class) ?? $query;
        $query = $validateAndApplyFilter($query, 'weather_condition_ids', 'weather_conditions', 'weather_conditions', WeatherCondition::class) ?? $query;
        $query = $validateAndApplyFilter($query, 'dietary_restriction_ids', 'dietary_restrictions', 'dietary_restrictions', DietaryRestriction::class) ?? $query;
        $query = $validateAndApplyFilter($query, 'cuisine_type_ids', 'cuisine_types', 'cuisine_types', CuisineType::class) ?? $query;


        $randomFood = $query->inRandomOrder()->first();

        if (!$randomFood) {
            return response()->json(['message' => 'No food found for your criteria.'], 404);
        }

        return new FoodsResource($randomFood);
    }
}