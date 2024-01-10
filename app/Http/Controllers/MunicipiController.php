<?php

namespace App\Http\Controllers;

use App\Models\Municipi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MunicipiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'municipis' => Municipi::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        //No es creen
//    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->dbActionBasic($id, Municipi::class, null, "findOrFail", null);
    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(String $id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, string $id)
//    {
//        //No canvien
//    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(string $id)
//    {
//        //No es destrueixen
//    }
}
