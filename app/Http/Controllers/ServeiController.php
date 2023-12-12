<?php

namespace App\Http\Controllers;

use App\Models\Servei;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServeiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'serveis' => Servei::all()
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
        $servei = new Servei();

        // Lógica para guardar los datos del servicio (adaptar según tus campos)

        return $this->dbAction($servei, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(Servei $servei)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servei $servei): JsonResponse
    {
        return response()->json([
            'servei' => Servei::find($servei)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servei $servei): JsonResponse
    {
        $servei = Servei::find($servei);


        return $this->dbAction($servei, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servei $servei): JsonResponse
    {
        $servei = Servei::find($servei);

        return $this->dbAction($servei, "delete");
    }
}
