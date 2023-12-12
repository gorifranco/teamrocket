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
        $audio = new Audio();

        $audio->url = $request->input('nom');
        $audio->ordre = $request->input('ordre');
        $audio->transcripcio = $request->input('transcripcio');

        return $this->dbAction($audio, "save");
    }

    /**
     * Display the specified resource.
     */
    public function show(Audio $audio)
    {
        return response()->json([
            'audio' => Audio::find($audio)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Audio $audio)
    {
        //Vista de punt d'interes
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Audio $audio)
    {
        $audio = DB::find($audio);

        $audio->url = $request->input('nom');
        $audio->ordre = $request->input('ordre');
        $audio->transcripcio = $request->input('transcripcio');

        return $this->dbAction($audio, "save");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audio $audio)
    {
        $audio = Arquitecte::find($audio);

        return $this->dbAction($audio, "delete");
    }
}
