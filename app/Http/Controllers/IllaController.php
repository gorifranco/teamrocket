<?php

namespace App\Http\Controllers;

use App\Models\Illa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class IllaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'illes' => Illa::all()
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
//        //No canvien
//    }

    /**
     * Display the specified resource.
     */
    public function show(String $id): JsonResponse
    {
        return $this->dbActionBasic($id, Illa::class, null, "findOrFail", null);

    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(String $id)
//    {
//
//    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, String $id)
//    {
//        //No canvien
//    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(String $id)
//    {
//        //No Canvien
//    }
}
