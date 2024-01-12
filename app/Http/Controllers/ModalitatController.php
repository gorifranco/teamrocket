<?php

namespace App\Http\Controllers;

use App\Models\Modalitat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModalitatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Modalitat::paginate(10)
        ]);
    }

    public function tots(): JsonResponse
    {
        return response()->json([
            'data' => Modalitat::all(),
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
    public function store(Request $request): JsonResponse
    {
        $regles = [
            'nom' => 'required|unique:modalitats,nom'
        ];
        return $this->dbActionBasic(null, Modalitat::class, $request, "createOrFail", $regles);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
return $this->dbActionBasic($id, Modalitat::class, null, "findOrFail", null);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $regles = [
            'nom' => "required|unique:modalitats,nom,$id"
        ];
        return $this->dbActionBasic($id, Modalitat::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Modalitat::class, null, "deleteOrFail",null);

    }

    public function find(string $str): JsonResponse
    {
        $data = Modalitat::where('nom', 'LIKE', '%' . $str . '%')
            ->orWhere('id', 'LIKE','%'. $str. '%')
            ->paginate(10);

        return response()->json([
            'data' => $data
        ]);
    }
}
