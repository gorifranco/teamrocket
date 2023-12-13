<?php

namespace App\Http\Controllers;

use App\Models\Illa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //No canvien
    }

    /**
     * Display the specified resource.
     */
    public function show(Illa $illa): JsonRespons   e
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
        //No canvien
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Illa $illa)
    {
        //No Canvien
    }
}