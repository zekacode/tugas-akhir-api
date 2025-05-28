<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DietaryRestriction;
use Illuminate\Http\Request;
use App\Http\Resources\DietaryRestrictionResource;

class DietaryRestrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dietaryRestrictions = DietaryRestriction::all();
        return DietaryRestrictionResource::collection($dietaryRestrictions);
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
    public function show(DietaryRestriction $dietaryRestriction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DietaryRestriction $dietaryRestriction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DietaryRestriction $dietaryRestriction)
    {
        //
    }
}
