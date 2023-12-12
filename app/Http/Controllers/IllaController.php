<?php

namespace App\Http\Controllers;

use App\Models\Illa;
use Illuminate\Http\Request;

class IllaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'illes' => Illa::all()
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
        $illa = new Illa();

        // Lógica para guardar los datos de la isla (adaptar según tus campos)

        try {
            $illa->save();
            return response()->json([
                'missatge' => 'Illa afegida amb èxit',
                'codi' => 0,
                'illa' => $illa
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
    public function show(Illa $illa)
    {
        return response()->json([
            'illa' => Illa::find($illa)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Illa $illa)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Illa $illa)
    {
                $illa = Illa::find($illa);

                // Lógica para actualizar los datos de la isla (adaptar según tus campos)

                try {
                    $illa->save();
                    return response()->json([
                        'missatge' => 'Illa actualitzada amb èxit',
                        'codi' => 0,
                        'illa' => $illa
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
    public function destroy(Illa $illa)
    {
        $illa = Illa::find($illa);

        try {
            $illa->delete();
            return response()->json([
                'missatge' => 'Illa eliminada amb èxit',
                'codi' => 0,
                'illa' => $illa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'illa' => $illa
            ], 400);
        }
    }
}
