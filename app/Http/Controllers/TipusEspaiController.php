<?php

namespace App\Http\Controllers;

use App\Models\TipusEspai;
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
        $tipusEspai = new TipusEspai();

        $tipusEspai->nom = $request->get("nom");

        return $this->dbActionBasic($tipusEspai, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(TipusEspai $tipusEspai): JsonResponse
    {
        return response()->json([
            'tipus_espai' => TipusEspai::find($tipusEspai)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipusEspai $tipusEspai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipusEspai $tipusEspai): JsonResponse
    {
        $tipusEspai = TipusEspai::find($tipusEspai);

        $tipusEspai->nom = $request->get("nom");

        return $this->dbActionBasic($tipusEspai, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipusEspai $tipusEspai): JsonResponse
    {
        $tipusEspai = TipusEspai::find($tipusEspai);

        return $this->dbActionBasic($tipusEspai, "delete");
    }
}
