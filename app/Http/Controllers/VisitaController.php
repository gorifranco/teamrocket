<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'visites' => Visita::all()
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
        $visita = new Visita();

        $visita->nom = $request->input("nom");
        $visita->descripcio = $request->input("descripcio");
        $visita->dataInici = $request->input("dataInici");
        $visita->dataFi = $request->input("dataFi");
        $visita->reqInscripcio = $request->input("reqInscripcio");
        $visita->places = $request->input("places");

        return $this->dbActionBasic($visita, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(Visita $visita): JsonResponse
    {
        return response()->json([
            'visita' => Visita::find($visita)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visita $visita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visita $visita): JsonResponse
    {
        $visita = Visita::find($visita);

        $visita->nom = $request->input("nom");
        $visita->descripcio = $request->input("descripcio");
        $visita->dataInici = $request->input("dataInici");
        $visita->dataFi = $request->input("dataFi");
        $visita->reqInscripcio = $request->input("reqInscripcio");
        $visita->places = $request->input("places");

        return $this->dbActionBasic($visita, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visita $visita): JsonResponse
    {
        $visita = Visita::find($visita);

        return $this->dbActionBasic($visita, "delete");
    }
}
