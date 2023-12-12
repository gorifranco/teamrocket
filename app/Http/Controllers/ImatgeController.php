<?php

namespace App\Http\Controllers;

use App\Models\Imatge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImatgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'imatges' => Imatge::all()
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
        $imatge = new Imatge();

        // Lógica para guardar los datos de la imagen (adaptar según tus campos)

        return $this->dbAction($imatge, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(Imatge $imatge): JsonResponse
    {
        return response()->json([
            'imatge' => Imatge::find($imatge)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imatge $imatge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imatge $imatge): JsonResponse
    {
        $imatge = new Imatge();

        // Lógica para actualizar los datos de la imagen (adaptar según tus campos)

        return $this->dbAction($imatge, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imatge $imatge): JsonResponse
    {
        $imatge = Imatge::find($imatge);

        return $this->dbAction($imatge, "delete");
    }
}
