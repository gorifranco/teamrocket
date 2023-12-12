<?php

namespace App\Http\Controllers;

use App\Models\TipusEspai;
use Illuminate\Http\Request;

class TipusEspaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'tipus_espais' => TipusEspai::all()
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
        $tipusEspai = new TipusEspai();

        // Lógica para guardar los datos del tipo de espacio (adaptar según tus campos)

        try {
            $tipusEspai->save();
            return response()->json([
                'missatge' => 'Tipus d\'espai afegit amb èxit',
                'codi' => 0,
                'tipus_espai' => $tipusEspai
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
    public function show(TipusEspai $tipusEspai)
    {
        return response()->json([
            'tipus_espai' => TipusEspai::find($tipusEspai)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipusEspai $tipusEspai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipusEspai $tipusEspai)
    {
        $tipusEspai = TipusEspai::find($tipusEspai);

        // Lógica para actualizar los datos del tipo de espacio (adaptar según tus campos)

        try {
            $tipusEspai->save();
            return response()->json([
                'missatge' => 'Tipus d\'espai actualitzat amb èxit',
                'codi' => 0,
                'tipus_espai' => $tipusEspai
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
    public function destroy(TipusEspai $tipusEspai)
    {
        $tipusEspai = TipusEspai::find($tipusEspai);

        try {
            $tipusEspai->delete();
            return response()->json([
                'missatge' => 'Tipus d\'espai eliminat amb èxit',
                'codi' => 0,
                'tipus_espai' => $tipusEspai
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'tipus_espai' => $tipusEspai
            ], 400);
        }
    }
}
