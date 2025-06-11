<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DietaryRestriction;
use Illuminate\Http\Request;
use App\Http\Resources\DietaryRestrictionResource;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Validation\Rule; // Import Rule

class DietaryRestrictionController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/dietary-restrictions
     */
    public function index()
    {
        $dietaryRestrictions = DietaryRestriction::latest()->paginate(10); // Tambahkan pagination
        // return DietaryRestrictionResource::collection($dietaryRestrictions);
        // Atau respons pagination lengkap:
        return response()->json([
            'data' => DietaryRestrictionResource::collection($dietaryRestrictions),
            'meta' => [
                'current_page' => $dietaryRestrictions->currentPage(),
                'last_page' => $dietaryRestrictions->lastPage(),
                'per_page' => $dietaryRestrictions->perPage(),
                'total' => $dietaryRestrictions->total(),
            ],
            'links' => [
                'first' => $dietaryRestrictions->url(1),
                'last' => $dietaryRestrictions->url($dietaryRestrictions->lastPage()),
                'prev' => $dietaryRestrictions->previousPageUrl(),
                'next' => $dietaryRestrictions->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/dietary-restrictions
     * Memerlukan autentikasi
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:dietary_restrictions,name',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dietaryRestriction = DietaryRestriction::create($request->all());

        return response()->json(new DietaryRestrictionResource($dietaryRestriction), 201); // 201 Created
    }

    /**
     * Display the specified resource.
     * GET /api/dietary-restrictions/{dietaryRestriction}
     */
    public function show(DietaryRestriction $dietaryRestriction) // Route model binding
    {
        return new DietaryRestrictionResource($dietaryRestriction);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/dietary-restrictions/{dietaryRestriction}
     * Memerlukan autentikasi
     */
    public function update(Request $request, DietaryRestriction $dietaryRestriction) // Route model binding
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('dietary_restrictions')->ignore($dietaryRestriction->id)],
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dietaryRestriction->update($request->all());

        return new DietaryRestrictionResource($dietaryRestriction);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/dietary-restrictions/{dietaryRestriction}
     * Memerlukan autentikasi
     */
    public function destroy(DietaryRestriction $dietaryRestriction) // Route model binding
    {
        // Pertimbangkan penanganan jika DietaryRestriction ini masih berelasi dengan Foods
        // if ($dietaryRestriction->foods()->exists()) {
        //     return response()->json(['error' => 'Dietary restriction cannot be deleted because it is associated with foods.'], 409); // Conflict
        // }

        $dietaryRestriction->delete();

        return response()->json(null, 204); // 204 No Content
    }
}