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
        $puntInteres = new PuntInteres();

        // Lógica para guardar los datos del punto de interés (adaptar según tus campos)

        return $this->dbAction($puntInteres, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(PuntInteres $puntInteres): JsonResponse
    {
        return response()->json([
            'punt_interes' => PuntInteres::find($puntInteres)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PuntInteres $puntInteres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PuntInteres $puntInteres): JsonResponse
    {
        $puntInteres = PuntInteres::find($puntInteres);

        // Lógica para actualizar los datos del punto de interés (adaptar según tus campos)

        return $this->dbAction($puntInteres, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PuntInteres $puntInteres): JsonResponse
    {
        $puntInteres = PuntInteres::find($puntInteres);

        return $this->dbAction($puntInteres, "delete");
    }
}
