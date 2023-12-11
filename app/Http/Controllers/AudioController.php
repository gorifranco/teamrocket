<?php

namespace App\Http\Controllers;

use App\Models\Arquitecte;
use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

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

        try {
            $audio->save();
            return response()->json([
                'missatge' => 'Audio afegit amb èxit',
                'codi' => 0,
                'audio' => $audio
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

        try {
            $audio->save();
            return response()->json([
                'missatge' => 'Audio afegit amb èxit',
                'codi' => 0,
                'audio' => $audio
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
    public function destroy(Audio $audio)
    {
        $audio = Arquitecte::find($audio);

        try{
            $audio->delete();
            return response()->json([
                'missatge' => 'Audio borrat amb èxit',
                'codi' => 0,
                'audio' => $audio
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'audio' => $audio
            ]);
        }
    }
}
