<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CuisineType;
use Illuminate\Http\Request;

class CuisineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuisineTypes = CuisineType::all();
        return CuisineTypeResource::collection($cuisineTypes);
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
    public function show(CuisineType $cuisineType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CuisineType $cuisineType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CuisineType $cuisineType)
    {
        //
    }
}
