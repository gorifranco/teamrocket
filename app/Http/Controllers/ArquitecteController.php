<?php

namespace App\Http\Controllers;

use app\Models\Arquitecte;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class ArquitecteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'arquitectes' => Arquitecte::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('arquitectes.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $arquitecte = new Arquitecte();

        $arquitecte->nom = $request->input('nom');
        $arquitecte->data_naix = $request->input('data_naix');
        $arquitecte->descripcio = $request->input('descripcio');

        try {
            $arquitecte->save();
            return response()->json([
                'missatge' => 'Arquitecte creat amb èxit',
                'codi' => 0,
                'arquitecte' => $arquitecte
            ]);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'arquitecte' => Arquitecte::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $arquitecte = Arquitecte::find($id);
        return view('arquitectes.editar', ['arquitecte' => $arquitecte]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $arquitecte = Arquitecte::find($id);

        $arquitecte->nom = $request->input('nom');
        $arquitecte->data_naix = $request->input('data_naix');
        $arquitecte->descripcio = $request->input('descripcio');

        try {
            $arquitecte->save();
            return response()->json([
                'missatge' => 'Arquitecte editat amb èxit',
                'codi' => 0,
                'arquitecte' => $arquitecte
            ]);
        } catch (Exception $e) {
            return response()->json([
                'missatge' => $e->getMessage(),
                'codi' => $e->getCode()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $arquitecte = Arquitecte::find($id);

        try{
            $arquitecte->delete();
            return response()->json([
                'message' => 'Arquitecte borrat amb èxit',
                'code' => 0,
                'arquitecte' => $arquitecte
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'arquitecte' => $arquitecte
            ]);
        }
    }
}
