<?php

namespace App\Http\Controllers;

use App\Models\Espai;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EspaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'espais' => Espai::all()
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
        $espai = new Espai();

        // Lógica para guardar los datos del espacio (adaptar según tus campos)

        return $this->dbAction($espai, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(Espai $espai): JsonResponse
    {
        return response()->json([
            'espai' => Espai::find($espai)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Espai $espai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Espai $espai): JsonResponse
    {
        $espai = Espai::find($espai);

        // Lógica para actualizar los datos del espacio (adaptar según tus campos)

        return $this->dbAction($espai, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Espai $espai): JsonResponse
    {
        $espai = Espai::find($espai);

        return $this->dbAction($espai, "delete");
    }
}
