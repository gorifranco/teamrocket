<?php

namespace App\Http\Controllers;

use App\Models\TipusEspai;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TipusEspaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'tipus_espais' => TipusEspai::all()
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
        $regles = [
            'nom' => 'required|unique:tipusespais.nom'
        ];

        return $this->dbActionBasic(null, TipusEspai::class, $request, "createOrFail", $regles);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
            return $this->dbActionBasic($id, TipusEspai::class, null, "findOrFail", null);
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
            'nom' => 'required|unique:tipusespais.nom'
        ];

        return $this->dbActionBasic($id, TipusEspai::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, TipusEspai::class, null, "deleteOrFail", null);
    }
}
