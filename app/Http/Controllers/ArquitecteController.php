<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArquitecteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'arquitecte' => Arquitecte::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('arquitectes.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $regles = [
            'nom' => "required|unique:arquitectes|max:255",
            'data_naix' => 'date'
        ];
//        $validated = $request->validate([
//            'nom' => "required|unique:arquitectes|max:10",
//            'data_naix' => 'date'
//        ]);

//        Arquitecte::create($validated);

//        return redirect(route('arquitectes'));

        $validacio = Validator::make($request->all(), $regles);
        if (!$validacio->fails()) {
            $obj = Arquitecte::create($request->all());
            return response()->json([
                'data' => $obj
            ], 200);
        }else{
            return response()->json([
                'errors'=> $validacio->errors()->toArray(),
               'missatge' => 'no ha nat be'
            ],400);
        }


//        return $this->dbActionBasic(null, Arquitecte::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $arquitecte = Arquitecte::findOrFail($id);

        return response()->json([
            'arquitecte' => $arquitecte
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arquitecte $arquitecte): View
    {
        $arquitecte = Arquitecte::find($arquitecte);

        return view('arquitectes.editar', ['arquitecte' => $arquitecte]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id): JsonResponse
    {
        $regles = [
        'nom' => "required|unique:arquitectes|max:255",
        'data_naix' => 'date'
    ];
        return $this->dbActionBasic($id, Arquitecte::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Arquitecte::class, null, "deleteOrFail", null);
    }
}
