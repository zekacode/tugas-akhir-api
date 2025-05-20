<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WeatherCondition;
use Illuminate\Http\Request;
use App\Http\Resources\WeatherConditionResource;

class WeatherConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weatherConditions = WeatherCondition::all();
        return WeatherConditionResource::collection($weatherConditions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WeatherCondition $weatherCondition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WeatherCondition $weatherCondition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WeatherCondition $weatherCondition)
    {
        //
    }
}
