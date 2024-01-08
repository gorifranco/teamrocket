<?php

use App\Http\Controllers\ArquitecteController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\DataReformaController;
use App\Http\Controllers\EspaiController;
use App\Http\Controllers\HoraActivaController;
use App\Http\Controllers\IllaController;
use App\Http\Controllers\ImatgeController;
use App\Http\Controllers\ModalitatController;
use App\Http\Controllers\MunicipiController;
use App\Http\Controllers\PuntInteresController;
use App\Http\Controllers\ServeiController;
use App\Http\Controllers\TipusEspaiController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\ZonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'arquitectes' => ArquitecteController::class,
    'audios' => AudioController::class,
    'comentaris' => ComentariController::class,
    'dates-reformes' => DataReformaController::class,
    'espais' => EspaiController::class,
    'hores-actives' => HoraActivaController::class,
    'illes' => IllaController::class,
    'imatges' => ImatgeController::class,
    'modalitats' => ModalitatController::class,
    'municipis' => MunicipiController::class,
    'punts-interes' => PuntInteresController::class,
    'serveis' => ServeiController::class,
    'tipus-espais' => TipusEspaiController::class,
    'visites' => VisitaController::class,
    'zones' => ZonaController::class
]);

Route::get('/arquitectes/find/{cerca}', [ArquitecteController::class, 'find']);
