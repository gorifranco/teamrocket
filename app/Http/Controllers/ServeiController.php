<?php

namespace App\Http\Controllers;

use App\Models\Servei;
use Illuminate\Http\Request;

class ServeiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(Request $request)
    {
        $servei = new Servei();

        // Lógica para guardar los datos del servicio (adaptar según tus campos)

        try {
            $servei->save();
            return response()->json([
                'missatge' => 'Servei afegit amb èxit',
                'codi' => 0,
                'servei' => $servei
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
    public function show(Servei $servei)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Servei $servei)
    {
        return response()->json([
            'servei' => Servei::find($servei)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servei $servei)
    {
        $servei = Servei::find($servei);

        // Lógica para actualizar los datos del servicio (adaptar según tus campos)

        try {
            $servei->save();
            return response()->json([
                'missatge' => 'Servei actualitzat amb èxit',
                'codi' => 0,
                'servei' => $servei
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
    public function destroy(Servei $servei)
    {
        $servei = Servei::find($servei);

        try {
            $servei->delete();
            return response()->json([
                'missatge' => 'Servei eliminat amb èxit',
                'codi' => 0,
                'servei' => $servei
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'servei' => $servei
            ], 400);
        }
    }
}
