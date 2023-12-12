<?php

namespace App\Http\Controllers;

use App\Models\Municipi;
use Illuminate\Http\Request;

class MunicipiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'municipis' => Municipi::all()
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
        $municipi = new Municipi();

        // Lógica para guardar los datos del municipio (adaptar según tus campos)

        try {
            $municipi->save();
            return response()->json([
                'missatge' => 'Municipi afegit amb èxit',
                'codi' => 0,
                'municipi' => $municipi
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
    public function show(Municipi $municipi)
    {
        return response()->json([
            'municipi' => Municipi::find($municipi)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Municipi $municipi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Municipi $municipi)
    {
        $municipi = Municipi::find($municipi);

        // Lógica para actualizar los datos del municipio (adaptar según tus campos)

        try {
            $municipi->save();
            return response()->json([
                'missatge' => 'Municipi actualitzat amb èxit',
                'codi' => 0,
                'municipi' => $municipi
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
    public function destroy(Municipi $municipi)
    {
        $municipi = Municipi::find($municipi);

        try {
            $municipi->delete();
            return response()->json([
                'missatge' => 'Municipi eliminat amb èxit',
                'codi' => 0,
                'municipi' => $municipi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'municipi' => $municipi
            ], 400);
        }
    }
}
