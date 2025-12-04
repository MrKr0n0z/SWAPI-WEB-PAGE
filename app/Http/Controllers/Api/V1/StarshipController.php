<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StarshipResource;
use App\Models\Starship;
use Illuminate\Http\Request;

class StarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $starships = Starship::all();
        return StarshipResource::collection($starships);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $starship = Starship::where('swapi_id', $id)->firstOrFail();
        return new StarshipResource($starship);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
