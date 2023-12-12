<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use Exception;
use Illuminate\Http\Request;

class ComentariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'comentaris' => Comentari::all()
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
        $comentari = new Comentari();

        $comentari->valoracio = $request->input('valoracio');
        //fk_usuari
        //fk_espai

        try {
            $comentari->save();
            return response()->json([
                'missatge' => 'Comentari afegit amb èxit',
                'codi' => 0,
                'comentari' => $comentari
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ],400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentari $comentari)
    {
        return response()->json([
            'comentari' => Comentari::find($comentari)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentari $comentari)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentari $comentari)
    {
        $comentari = Comentari::find($comentari);

        $comentari->valoracio = $request->input('valoracio');
        //fk_usuari
        //fk_espai

        try {
            $comentari->save();
            return response()->json([
                'missatge' => 'Comentari actualitzat amb èxit',
                'codi' => 0,
                'comentari' => $comentari
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ],400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentari $comentari)
    {
        $comentari = Comentari::find($comentari);

        try {
            $comentari->delete();
            return response()->json([
                'missatge' => 'Comentari eliminat amb èxit',
                'codi' => 0,
                'comentari' => $comentari
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'comentari' => $comentari
            ],400);
        }
    }
    public function validar(Comentari $comentari)
    {
        $comentari = Comentari::find($comentari);

        $comentari->validat = true;

        try{
            $comentari->save();
            return response()->json([
                'missatge' => 'Comentari validat amb èxit',
                'codi' => 0,
                'comentari' => $comentari
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'comentari' => $comentari
            ], 400);
        }

    }
}
