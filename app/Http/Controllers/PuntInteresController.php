<?php

namespace App\Http\Controllers;

use App\Models\PuntInteres;
use Illuminate\Http\Request;

class PuntInteresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'puntsInteres' => PuntInteres::all()
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
        $puntInteres = new PuntInteres();

        // Lógica para guardar los datos del punto de interés (adaptar según tus campos)

        try {
            $puntInteres->save();
            return response()->json([
                'missatge' => 'Punt d\'interès afegit amb èxit',
                'codi' => 0,
                'punt_interes' => $puntInteres
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
    public function show(PuntInteres $puntInteres)
    {
        return response()->json([
            'punt_interes' => PuntInteres::find($puntInteres)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PuntInteres $puntInteres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PuntInteres $puntInteres)
    {
        $puntInteres = PuntInteres::find($puntInteres);

        // Lógica para actualizar los datos del punto de interés (adaptar según tus campos)

        try {
            $puntInteres->save();
            return response()->json([
                'missatge' => 'Punt d\'interès actualitzat amb èxit',
                'codi' => 0,
                'punt_interes' => $puntInteres
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
    public function destroy(PuntInteres $puntInteres)
    {
        $puntInteres = PuntInteres::find($puntInteres);

        try {
            $puntInteres->delete();
            return response()->json([
                'missatge' => 'Punt d\'interès eliminat amb èxit',
                'codi' => 0,
                'punt_interes' => $puntInteres
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'punt_interes' => $puntInteres
            ], 400);
        }
    }
}
