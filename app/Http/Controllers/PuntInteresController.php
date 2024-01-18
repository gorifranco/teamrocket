<?php

namespace App\Http\Controllers;

use App\Models\PuntInteres;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PuntInteresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'puntsInteres' => PuntInteres::all()
        ]);
    }

    public function punts_per_espai (string $id) {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $regles = [
            'nom' => 'required',
            'descripcio' => 'required',
        ];
        return $this->dbActionBasic(null, PuntInteres::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'punt_interes' => PuntInteres::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $regles = [
            'nom' => 'required',
            'descripcio' => 'required',
            'fk_espai' => 'required|integer|min:0'
        ];
        return $this->dbActionBasic($id, PuntInteres::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, PuntInteres::class, null, "deleteOrFail", null);
    }
}
