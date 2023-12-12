<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComentariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'comentaris' => Comentari::all()
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
        $comentari = new Comentari();

        $comentari->valoracio = $request->input('valoracio');
        //fk_usuari
        //fk_espai

        return $this->dbAction($comentari, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentari $comentari): JsonResponse
    {
        return response()->json([
            'comentari' => Comentari::find($comentari)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentari $comentari)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentari $comentari): JsonResponse
    {
        $comentari = Comentari::find($comentari);

        $comentari->valoracio = $request->input('valoracio');
        //fk_usuari
        //fk_espai

        return $this->dbAction($comentari, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentari $comentari): JsonResponse
    {
        $comentari = Comentari::find($comentari);

        return $this->dbAction($comentari, "delete");
    }

    public function validar(Comentari $comentari): JsonResponse
    {
        $comentari = Comentari::find($comentari);

        $comentari->validat = true;

        return $this->dbAction($comentari, "save");
    }
}
