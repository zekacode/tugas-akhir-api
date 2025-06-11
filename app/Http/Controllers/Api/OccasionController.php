<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Occasion;
use Illuminate\Http\Request;
use App\Http\Resources\OccasionResource;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Validation\Rule; // Import Rule

class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/occasions
     */
    public function index()
    {
        $occasions = Occasion::latest()->paginate(10); // Tambahkan pagination
        // return OccasionResource::collection($occasions);
        // Atau respons pagination lengkap:
        return response()->json([
            'data' => OccasionResource::collection($occasions),
            'meta' => [
                'current_page' => $occasions->currentPage(),
                'last_page' => $occasions->lastPage(),
                'per_page' => $occasions->perPage(),
                'total' => $occasions->total(),
            ],
            'links' => [
                'first' => $occasions->url(1),
                'last' => $occasions->url($occasions->lastPage()),
                'prev' => $occasions->previousPageUrl(),
                'next' => $occasions->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/occasions
     * Memerlukan autentikasi
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:occasions,name',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $occasion = Occasion::create($request->all());

        return response()->json(new OccasionResource($occasion), 201); // 201 Created
    }

    /**
     * Display the specified resource.
     * GET /api/occasions/{occasion}
     */
    public function show(Occasion $occasion) // Route model binding
    {
        return new OccasionResource($occasion);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/occasions/{occasion}
     * Memerlukan autentikasi
     */
    public function update(Request $request, Occasion $occasion) // Route model binding
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('occasions')->ignore($occasion->id)],
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $occasion->update($request->all());

        return new OccasionResource($occasion);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/occasions/{occasion}
     * Memerlukan autentikasi
     */
    public function destroy(Occasion $occasion) // Route model binding
    {
        // Pertimbangkan penanganan jika Occasion ini masih berelasi dengan Foods
        // if ($occasion->foods()->exists()) {
        //     return response()->json(['error' => 'Occasion cannot be deleted because it is associated with foods.'], 409); // Conflict
        // }

        $occasion->delete();

        return response()->json(null, 204); // 204 No Content
    }
}