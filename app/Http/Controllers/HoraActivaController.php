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
        $horaActiva = new HoraActiva();

        // Lógica para guardar los datos de la hora activa (adaptar según tus campos)

        return $this->dbAction($horaActiva, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(HoraActiva $horaActiva): JsonResponse
    {
        return response()->json([
            'hora_activa' => HoraActiva::find($horaActiva)
        ]);
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
    public function update(Request $request, HoraActiva $horaActiva): JsonResponse
    {
        $horaActiva = HoraActiva::find($horaActiva);

        // Lógica para actualizar los datos de la hora activa (adaptar según tus campos)

        return $this->dbAction($horaActiva, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HoraActiva $horaActiva): JsonResponse
    {
        $horaActiva = HoraActiva::find($horaActiva);

        return $this->dbAction($horaActiva, "delete");
    }
}
