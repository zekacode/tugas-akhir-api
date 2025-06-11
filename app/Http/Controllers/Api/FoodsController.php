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
use Illuminate\Support\Facades\Log; // Untuk logging error jika menggunakan try-catch

class FoodsController extends Controller
{
    protected $relationsToLoad = [
        'category', 'moods', 'occasions',
        'weatherConditions', 'dietaryRestrictions', 'cuisineTypes'
    ];

    public function index(Request $request)
    {
        $query = Foods::with($this->relationsToLoad);

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $applyManyToManyFilter = function ($query, $relationName, $requestKey, $tableName) use ($request) { // Tambahkan use ($request)
            if ($request->has($requestKey) && !empty($request->input($requestKey))) {
                $ids = is_array($request->input($requestKey)) ? $request->input($requestKey) : [$request->input($requestKey)];
                $validIds = array_filter($ids, 'is_numeric');
                if (!empty($validIds)) {
                    $query->whereHas($relationName, function ($q) use ($validIds, $tableName) {
                        $q->whereIn($tableName.'.id', $validIds);
                    });
                }
            }
        };

        $applyManyToManyFilter($query, 'moods', 'mood_ids', 'moods');
        $applyManyToManyFilter($query, 'occasions', 'occasion_ids', 'occasions');
        $applyManyToManyFilter($query, 'weatherConditions', 'weather_condition_ids', 'weather_conditions'); // <-- DIPERBAIKI
        $applyManyToManyFilter($query, 'dietaryRestrictions', 'dietary_restriction_ids', 'dietary_restrictions'); // <-- DIPERBAIKI
        $applyManyToManyFilter($query, 'cuisineTypes', 'cuisine_type_ids', 'cuisine_types'); // <-- DIPERBAIKI

        $foodsData = $query->latest()->paginate(10)->withQueryString();

        // return FoodsResource::collection($foodsData); // Opsi respons sederhana
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
            'weather_condition_ids.*' => ['integer', Rule::exists('weather_conditions', 'id')], // <-- DIPERBAIKI
            'dietary_restriction_ids' => 'nullable|array',
            'dietary_restriction_ids.*' => ['integer', Rule::exists('dietary_restrictions', 'id')], // <-- DIPERBAIKI
            'cuisine_type_ids' => 'nullable|array',
            'cuisine_type_ids.*' => ['integer', Rule::exists('cuisine_types', 'id')], // <-- DIPERBAIKI
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $foodItemData = $request->except([
                'mood_ids', 'occasion_ids', 'weather_condition_ids',
                'dietary_restriction_ids', 'cuisine_type_ids'
            ]);
            $foodItem = Foods::create($foodItemData);

            if ($request->has('mood_ids')) $foodItem->moods()->sync($request->input('mood_ids'));
            if ($request->has('occasion_ids')) $foodItem->occasions()->sync($request->input('occasion_ids'));
            if ($request->has('weather_condition_ids')) $foodItem->weatherConditions()->sync($request->input('weather_condition_ids'));
            if ($request->has('dietary_restriction_ids')) $foodItem->dietaryRestrictions()->sync($request->input('dietary_restriction_ids'));
            if ($request->has('cuisine_type_ids')) $foodItem->cuisineTypes()->sync($request->input('cuisine_type_ids'));

            DB::commit();
            return response()->json(new FoodsResource($foodItem->load($this->relationsToLoad)), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create food item: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create food item. Please try again.'], 500);
        }
    }

    public function show(Foods $food)
    {
        return new FoodsResource($food->load($this->relationsToLoad));
    }

    public function update(Request $request, Foods $food)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('foods')->ignore($food->id)],
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
            'weather_condition_ids.*' => ['integer', Rule::exists('weather_conditions', 'id')], // <-- DIPERBAIKI
            'dietary_restriction_ids' => 'nullable|array',
            'dietary_restriction_ids.*' => ['integer', Rule::exists('dietary_restrictions', 'id')], // <-- DIPERBAIKI
            'cuisine_type_ids' => 'nullable|array',
            'cuisine_type_ids.*' => ['integer', Rule::exists('cuisine_types', 'id')], // <-- DIPERBAIKI
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $foodItemData = $request->except([
                'mood_ids', 'occasion_ids', 'weather_condition_ids',
                'dietary_restriction_ids', 'cuisine_type_ids'
            ]);
            $food->update($foodItemData);

            $syncOrDetach = function ($relationName, $requestKey) use ($request, $food) {
                if ($request->has($requestKey)) {
                    $food->{$relationName}()->sync($request->input($requestKey, []));
                }
                 // Anda bisa tambahkan logika detach jika key tidak ada, sesuai kebutuhan
                 // else { $food->{$relationName}()->detach(); }
            };

            $syncOrDetach('moods', 'mood_ids');
            $syncOrDetach('occasions', 'occasion_ids');
            $syncOrDetach('weatherConditions', 'weather_condition_ids');
            $syncOrDetach('dietaryRestrictions', 'dietary_restriction_ids');
            $syncOrDetach('cuisineTypes', 'cuisine_type_ids');

            DB::commit();
            return new FoodsResource($food->load($this->relationsToLoad));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update food item: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update food item. Please try again.'], 500);
        }
    }

    public function destroy(Foods $food)
    {
        DB::beginTransaction();
        try {
            // Relasi many-to-many akan di-detach otomatis jika ada foreign key onDelete('cascade') di tabel pivot
            // atau bisa di-detach manual sebelum delete jika perlu
            // $food->moods()->detach(); // Contoh
            $food->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete food item: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete food item. Please try again.'], 500);
        }
    }

    public function oraclePick(Request $request)
    {
        $query = Foods::with($this->relationsToLoad);

        $validateAndApplyFilter = function ($query, $requestKey, $relationName, $tableName) use ($request) { // Hapus $modelClass, tidak terpakai di sini
            if ($request->has($requestKey) && !empty($request->input($requestKey))) {
                $ids = is_array($request->input($requestKey)) ? $request->input($requestKey) : [$request->input($requestKey)];
                $validator = Validator::make([$requestKey => $ids], [
                    $requestKey => 'array',
                    $requestKey.'.*' => ['integer', Rule::exists($tableName, 'id')],
                ]);
                if ($validator->fails()) {
                    // Mengembalikan null agar bisa di-chain dengan ?? $query, tapi log errornya
                    Log::warning("Invalid filter ID for {$requestKey}: " . json_encode($ids) . " Errors: " . json_encode($validator->errors()->all()));
                    return null;
                }
                if (!empty($ids)) { // Pastikan $ids tidak kosong setelah validasi (meskipun Rule::exists sudah handle)
                    $query->whereHas($relationName, function ($q) use ($ids, $tableName) {
                        $q->whereIn($tableName.'.id', $ids);
                    });
                }
            }
            return $query;
        };

        if ($request->has('category_id') && !empty($request->category_id)) {
            $validator = Validator::make($request->all(), ['category_id' => ['integer', Rule::exists('categories', 'id')]]);
            if ($validator->fails()) {
                 Log::warning("Invalid category_id for oraclePick: " . $request->category_id . " Errors: " . json_encode($validator->errors()->all()));
                // Tidak return error, biarkan query berlanjut tanpa filter kategori ini
            } else {
                $query->where('category_id', $request->category_id);
            }
        }

        $query = $validateAndApplyFilter($query, 'mood_ids', 'moods', 'moods') ?? $query;
        $query = $validateAndApplyFilter($query, 'occasion_ids', 'occasions', 'occasions') ?? $query;
        $query = $validateAndApplyFilter($query, 'weather_condition_ids', 'weather_conditions', 'weather_conditions') ?? $query; // <-- DIPERBAIKI
        $query = $validateAndApplyFilter($query, 'dietary_restriction_ids', 'dietary_restrictions', 'dietary_restrictions') ?? $query; // <-- DIPERBAIKI
        $query = $validateAndApplyFilter($query, 'cuisine_type_ids', 'cuisine_types', 'cuisine_types') ?? $query; // <-- DIPERBAIKI


        $randomFood = $query->inRandomOrder()->first();

        if (!$randomFood) {
            return response()->json(['message' => 'No food found for your criteria.'], 404);
        }

        return new FoodsResource($randomFood);
    }
}