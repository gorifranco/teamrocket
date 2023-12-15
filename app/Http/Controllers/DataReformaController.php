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
        $regles = [
            'data_reforma' => 'required|date',
            'fk_espai' => 'required|integer|min:0'
        ];
        return $this->dbActionBasic(null, DataReforma::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, DataReforma::class, null, "findOrFail", null);
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
            'data_reforma' => 'required|date',
            'fk_espai' => 'required|integer|min:0'
        ];
        return $this->dbActionBasic($id, DataReforma::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, DataReforma::class, null, "deleteOrFail", null);
    }
}
