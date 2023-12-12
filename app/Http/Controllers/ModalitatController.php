<?php

namespace App\Http\Controllers;

use App\Models\Modalitat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModalitatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'modalitats' => Modalitat::all()
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
        $modalitat = new Modalitat();

        // Lógica para guardar los datos de la modalidad (adaptar según tus campos)

        return $this->dbAction($modalitat, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(Modalitat $modalitat): JsonResponse
    {
        return response()->json([
            'modalitat' => Modalitat::find($modalitat)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modalitat $modalitat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modalitat $modalitat): JsonResponse
    {
        $modalitat = Modalitat::find($modalitat);

        // Lógica para actualizar los datos de la modalidad (adaptar según tus campos)

        return $this->dbAction($modalitat, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modalitat $modalitat): JsonResponse
    {
        $modalitat = Modalitat::find($modalitat);

        return $this->dbAction($modalitat, "delete");
    }
}
