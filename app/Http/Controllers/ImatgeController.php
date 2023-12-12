<?php

namespace App\Http\Controllers;

use App\Models\Imatge;
use Illuminate\Http\Request;

class ImatgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'imatges' => Imatge::all()
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
        $imatge = new Imatge();

        // Lógica para guardar los datos de la imagen (adaptar según tus campos)

        try {
            $imatge->save();
            return response()->json([
                'missatge' => 'Imatge afegida amb èxit',
                'codi' => 0,
                'imatge' => $imatge
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
    public function show(Imatge $imatge)
    {
        return response()->json([
            'imatge' => Imatge::find($imatge)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imatge $imatge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imatge $imatge)
    {

        // Lógica para actualizar los datos de la imagen (adaptar según tus campos)

        try {
            $imatge->save();
            return response()->json([
                'missatge' => 'Imatge actualitzada amb èxit',
                'codi' => 0,
                'imatge' => $imatge
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
    public function destroy(Imatge $imatge)
    {
        $imatge = Imatge::find($imatge);

        try {
            $imatge->delete();
            return response()->json([
                'missatge' => 'Imatge eliminada amb èxit',
                'codi' => 0,
                'imatge' => $imatge
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'imatge' => $imatge
            ], 400);
        }
    }
}
