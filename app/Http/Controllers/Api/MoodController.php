<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mood;
use App\Http\Resources\MoodResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator
use Illuminate\Validation\Rule; // Import Rule

class MoodController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/moods
     */
    public function index()
    {
        $moods = Mood::latest()->paginate(10); // Tambahkan pagination dan urutan terbaru
        // return MoodResource::collection($moods);
        // Atau respons pagination lengkap:
        return response()->json([
            'data' => MoodResource::collection($moods),
            'meta' => [
                'current_page' => $moods->currentPage(),
                'last_page' => $moods->lastPage(),
                'per_page' => $moods->perPage(),
                'total' => $moods->total(),
            ],
            'links' => [
                'first' => $moods->url(1),
                'last' => $moods->url($moods->lastPage()),
                'prev' => $moods->previousPageUrl(),
                'next' => $moods->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/moods
     * Memerlukan autentikasi
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:moods,name',
            'description' => 'nullable|string|max:255',
            'emoji_icon' => 'nullable|string|max:50', // Sesuaikan max length jika perlu
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mood = Mood::create($request->all());

        return response()->json(new MoodResource($mood), 201); // 201 Created
    }

    /**
     * Display the specified resource.
     * GET /api/moods/{mood}
     */
    public function show(Mood $mood) // Route model binding
    {
        return new MoodResource($mood);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/moods/{mood}
     * Memerlukan autentikasi
     */
    public function update(Request $request, Mood $mood) // Route model binding
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('moods')->ignore($mood->id)],
            'description' => 'nullable|string|max:255',
            'emoji_icon' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $mood->update($request->all());

        return new MoodResource($mood);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/moods/{mood}
     * Memerlukan autentikasi
     */
    public function destroy(Mood $mood) // Route model binding
    {
        // Pertimbangkan penanganan jika Mood ini masih berelasi dengan Foods
        // if ($mood->foods()->exists()) {
        //     return response()->json(['error' => 'Mood cannot be deleted because it is associated with foods.'], 409); // Conflict
        // }

        $mood->delete();

        return response()->json(null, 204); // 204 No Content
    }
}