<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeatherCondition;
use Illuminate\Http\Request;
use App\Http\Resources\WeatherConditionResource;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Validation\Rule; // Import Rule

class WeatherConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/weather-conditions
     */
    public function index()
    {
        $weatherConditions = WeatherCondition::latest()->paginate(10); // Tambahkan pagination
        // return WeatherConditionResource::collection($weatherConditions);
        // Atau respons pagination lengkap:
        return response()->json([
            'data' => WeatherConditionResource::collection($weatherConditions),
            'meta' => [
                'current_page' => $weatherConditions->currentPage(),
                'last_page' => $weatherConditions->lastPage(),
                'per_page' => $weatherConditions->perPage(),
                'total' => $weatherConditions->total(),
            ],
            'links' => [
                'first' => $weatherConditions->url(1),
                'last' => $weatherConditions->url($weatherConditions->lastPage()),
                'prev' => $weatherConditions->previousPageUrl(),
                'next' => $weatherConditions->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/weather-conditions
     * Memerlukan autentikasi
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:weather_conditions,name',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $weatherCondition = WeatherCondition::create($request->all());

        return response()->json(new WeatherConditionResource($weatherCondition), 201); // 201 Created
    }

    /**
     * Display the specified resource.
     * GET /api/weather-conditions/{weatherCondition}
     */
    public function show(WeatherCondition $weatherCondition) // Route model binding
    {
        return new WeatherConditionResource($weatherCondition);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/weather-conditions/{weatherCondition}
     * Memerlukan autentikasi
     */
    public function update(Request $request, WeatherCondition $weatherCondition) // Route model binding
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('weather_conditions')->ignore($weatherCondition->id)],
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $weatherCondition->update($request->all());

        return new WeatherConditionResource($weatherCondition);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/weather-conditions/{weatherCondition}
     * Memerlukan autentikasi
     */
    public function destroy(WeatherCondition $weatherCondition) // Route model binding
    {
        // Pertimbangkan penanganan jika WeatherCondition ini masih berelasi dengan Foods
        // if ($weatherCondition->foods()->exists()) {
        //     return response()->json(['error' => 'Weather condition cannot be deleted because it is associated with foods.'], 409); // Conflict
        // }

        $weatherCondition->delete();

        return response()->json(null, 204); // 204 No Content
    }
}