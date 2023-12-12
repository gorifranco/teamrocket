<?php

namespace App\Http\Controllers;

use App\Models\Modalitat;
use Illuminate\Http\Request;

class ModalitatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'modalitats' => Modalitat::all()
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
        $modalitat = new Modalitat();

        // Lógica para guardar los datos de la modalidad (adaptar según tus campos)

        try {
            $modalitat->save();
            return response()->json([
                'missatge' => 'Modalitat afegida amb èxit',
                'codi' => 0,
                'modalitat' => $modalitat
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
    public function show(Modalitat $modalitat)
    {
        return response()->json([
            'modalitat' => Modalitat::find($modalitat)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modalitat $modalitat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modalitat $modalitat)
    {
        $modalitat = Modalitat::find($modalitat);

        // Lógica para actualizar los datos de la modalidad (adaptar según tus campos)

        try {
            $modalitat->save();
            return response()->json([
                'missatge' => 'Modalitat actualitzada amb èxit',
                'codi' => 0,
                'modalitat' => $modalitat
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
    public function destroy(Modalitat $modalitat)
    {
        $modalitat = Modalitat::find($modalitat);

        try {
            $modalitat->delete();
            return response()->json([
                'missatge' => 'Modalitat eliminada amb èxit',
                'codi' => 0,
                'modalitat' => $modalitat
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode(),
                'modalitat' => $modalitat
            ], 400);
        }
    }
}
