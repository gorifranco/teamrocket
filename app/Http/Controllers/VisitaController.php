<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'visites' => Visita::all()
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
    public function store(Request $request)
    {
        $visita = new Visita();

        // Lógica para guardar los datos de la visita (adaptar según tus campos)

        try {
            $visita->save();
            return response()->json([
                'missatge' => 'Visita afegida amb èxit',
                'codi' => 0,
                'visita' => $visita
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Visita $visita)
    {
        return response()->json([
            'visita' => Visita::find($visita)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visita $visita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visita $visita)
    {
        $visita = Visita::find($visita);

        // Lógica para actualizar los datos de la visita (adaptar según tus campos)

        try {
            $visita->save();
            return response()->json([
                'missatge' => 'Visita actualitzada amb èxit',
                'codi' => 0,
                'visita' => $visita
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visita $visita)
    {
        $visita = Visita::find($visita);

        try {
            $visita->delete();
            return response()->json([
                'missatge' => 'Visita eliminada amb èxit',
                'codi' => 0,
                'visita' => $visita
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'visita' => $visita
            ], 400);
        }
    }
}
