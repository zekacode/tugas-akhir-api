<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mood;
use App\Http\Resources\MoodResource;
use Illuminate\Http\Request;

class MoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moods = Mood::all();
        return MoodResource::collection($moods);
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
    public function show(Mood $mood)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mood $mood)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mood $mood)
    {
        //
    }
}
