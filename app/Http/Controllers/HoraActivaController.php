<?php

namespace App\Http\Controllers;

use App\Models\HoraActiva;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HoraActivaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'horesActives' => HoraActiva::all()
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
            'dia' => 'required|integer|min:0|max:7',
            'desde' => 'required|time',
            'fins' => 'required|time'
            ];

        return $this->dbActionBasic(null, HoraActiva::class, $request, "createOrFail", $regles);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, HoraActiva::class, null, "findOrFail", null);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HoraActiva $horaActiva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $regles = [
            'dia' => 'required|integer|min:0|max:7',
            'desde' => 'required|time',
            'fins' => 'required|time'
        ];

        return $this->dbActionBasic($id, HoraActiva::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, HoraActiva::class, null, "deleteOrFail", null);
    }
}
