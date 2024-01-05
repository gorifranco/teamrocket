<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArquitecteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Arquitecte::paginate(10)
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

        return $this->dbActionBasic(null, Arquitecte::class, $request, "createOrFail", $regles);

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

    public function find(string $str)
    {
        $data = Arquitecte::where('nom', 'LIKE', '%' . $str . '%')
            ->orWhere('descripcio', 'LIKE', '%' . $str . '%')
            ->orWhere('id', 'LIKE','%'. $str. '%')
            ->orWhere('data_naix', 'LIKE','%'. $str. '%')
            ->paginate(10);

        return response()->json([
            'data' => $data
            ]);
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
