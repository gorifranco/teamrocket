<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'audios' => Audio::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //es pujaran des de punt d'Interes
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $regles = [
            'url' => "required|unique:audios.url|unique:imatges.url|url",
        ];
        return $this->dbActionBasic(null, Audio::class, $request, "createOrFail", $regles);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->dbActionBasic($id, Audio::class, null, "fildOrFail", null);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //Vista de punt d'interes
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $regles = [
            'url' => "required|unique:audios.url|unique:imatges.url|url",
        ];
        return $this->dbActionBasic($id, Audio::class, $request, "updateOrFail", $regles);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->dbActionBasic($id, Audio::class, null, "deleteOrFail", null);
    }
}
