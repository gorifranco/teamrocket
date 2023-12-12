<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'zones' => Zona::all()
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
        $zona = new Zona();

        // Lógica para guardar los datos de la zona (adaptar según tus campos)

        try {
            $zona->save();
            return response()->json([
                'missatge' => 'Zona afegida amb èxit',
                'codi' => 0,
                'zona' => $zona
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
    public function show(Zona $zona)
    {
        return response()->json([
            'zona' => Zona::find($zona)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zona $zona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zona $zona)
    {
        $zona = Zona::find($zona);

        // Lógica para actualizar los datos de la zona (adaptar según tus campos)

        try {
            $zona->save();
            return response()->json([
                'missatge' => 'Zona actualitzada amb èxit',
                'codi' => 0,
                'zona' => $zona
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
    public function destroy(Zona $zona)
    {
        $zona = Zona::find($zona);

        try {
            $zona->delete();
            return response()->json([
                'missatge' => 'Zona eliminada amb èxit',
                'codi' => 0,
                'zona' => $zona
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'zona' => $zona
            ], 400);
        }
    }
}
