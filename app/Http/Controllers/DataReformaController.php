<?php

namespace App\Http\Controllers;

use App\Models\DataReforma;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataReformaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'dates' => DataReforma::all()
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
        $dataReforma = new DataReforma();

        $dataReforma->valoracio = $request->input('valoracio');
        //fk_usuari
        //fk_espai

        return $this->dbActionBasic($dataReforma, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(DataReforma $dataReforma): JsonResponse
    {
        return response()->json([
            'data_reforma' => DataReforma::find($dataReforma)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataReforma $dataReforma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataReforma $dataReforma): JsonResponse
    {
        $dataReforma = DataReforma::find($dataReforma);

        $dataReforma->valoracio = $request->input('valoracio');
        //fk_usuari
        //fk_espai

        return $this->dbActionBasic($dataReforma, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataReforma $dataReforma): JsonResponse
    {
        $dataReforma = DataReforma::find($dataReforma);

        return $this->dbActionBasic($dataReforma, "delete");
    }
}
