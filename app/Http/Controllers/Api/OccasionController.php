<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Occasion;
use Illuminate\Http\Request;
use App\Http\Resources\OccasionResource;

class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $occasions = Occasion::all();
        return OccasionResource::collection($occasions);
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
    public function show(Occasion $occasion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Occasion $occasion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occasion $occasion)
    {
        //
    }
}
