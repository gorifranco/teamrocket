<?php

use App\Http\Controllers\ArquitecteController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\DataReformaController;
use App\Http\Controllers\EspaiController;
use App\Http\Controllers\HoraActivaController;
use App\Http\Controllers\IllaController;
use App\Http\Controllers\ImatgeController;
use App\Http\Controllers\LoginController;
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

Route::post('/login', [LoginController::class, 'login']);


//Guest routes
Route::apiResource("arquitectes", ArquitecteController::class)->only("index", "show");
Route::apiResource('audios', AudioController::class)->only(['index', 'show']);
Route::apiResource('dates-reformes', DataReformaController::class)->only(['index', 'show']);
Route::apiResource('espais', EspaiController::class)->only(['index', 'show']);
Route::apiResource('hores-actives', HoraActivaController::class)->only(['index', 'show']);
Route::apiResource('illes', IllaController::class)->only(['index', 'show']);
Route::apiResource('imatges', ImatgeController::class)->only(['index', 'show']);
Route::apiResource('modalitats', ModalitatController::class)->only(['index', 'show']);
Route::apiResource('municipis', MunicipiController::class)->only(['index', 'show']);
Route::apiResource('punts_interes', PuntInteresController::class)->only(['index', 'show']);
Route::apiResource('serveis', ServeiController::class)->only(['index', 'show']);
Route::apiResource('tipus_espais', TipusEspaiController::class)->only(['index', 'show']);
Route::apiResource('visites', VisitaController::class)->only(['index', 'show']);
Route::apiResource('zones', ZonaController::class)->only(['index', 'show']);


Route::get("arquitectes_tots", [ArquitecteController::class, "tots"]);
Route::get("tipus_espais_tots", [TipusEspaiController::class, "tots"]);
Route::get("modalitats_tots", [ModalitatController::class, "tots"]);
Route::get("punts_per_espai/{id}", [PuntInteresController::class, "punts_per_espai"])
    ->name("punts_per_espai");
Route::get("visites_per_espai/{id}", [VisitaController::class, "visites_per_espai"])
    ->name("visites_per_espai");
Route::get("comentaris_per_espai/{id}", [ComentariController::class, 'comentaris_per_espai'])
    ->name("comentaris_per_espai");


Route::middleware(['apiMiddleware'])->group(function () {
    Route::apiResource("comentaris", ComentariController::class)->only("store", 'destroy', 'edit');

    Route::middleware(["tipusUsuari:administrador,gestor"])->group(function () {
        Route::apiResource("arquitectes", ArquitecteController::class)
            ->only("store", "destroy", "update");
        Route::apiResource("tipus_espais", TipusEspaiController::class)
            ->only("store", "destroy", "update");
        Route::apiResource("serveis", ServeiController::class)
            ->only("store", "destroy", "update");
        Route::apiResource("modalitats", ModalitatController::class)
            ->only("store", "destroy", "update");
        Route::apiResource("espais", EspaiController::class)
            ->only("store", "destroy", "update");
        Route::put("espais/{id}/activar_desactivar", [EspaiController::class, "activar_desactivar"]);
        Route::get("/espais_per_gestor", [EspaiController::class, "espais_per_gestor"]);
        Route::get("/espais_per_gestor_tots", [EspaiController::class, "espais_per_gestor_tots"]);
        Route::get("/espais_per_gestor/find/{cerca}", [EspaiController::class, "espais_per_gestor_find"]);
        Route::apiResource("punts_interes", PuntInteresController::class)
            ->only("store", "destroy", "update");
        Route::apiResource("visites", VisitaController::class)
            ->only("store", "destroy", "update");
    //Comentaris
        Route::get("/comentaris/validar_invalidar/{id}", [ComentariController::class, "validar_invalidar"]);
        Route::get("comentaris_per_espai_tots/{id}", [ComentariController::class, 'comentaris_per_espai_tots'])
            ->name("comentaris_per_espai_tots");

    //Audios
        Route::apiResource("audios", AudioController::class)
            ->only("update", "destroy");
        Route::post("/audios", [AudioController::class, "uploadAudio"]);



        Route::apiResources([
            'dates-reformes' => DataReformaController::class,
            'hores-actives' => HoraActivaController::class,
            'imatges' => ImatgeController::class,
        ]);
    });
//Domes admins
    Route::apiResource("comentaris", ComentariController::class)
        ->only("index")
        ->middleware("tipusUsuari:administrador");
    Route::apiResource("audios", AudioController::class)
        ->only("show", "index");
});



Route::get('/arquitectes/find/{cerca}', [ArquitecteController::class, 'find']);
Route::get('/modalitats/find/{cerca}', [ModalitatController::class, 'find']);
Route::get('/tipus_espais/find/{cerca}', [TipusEspaiController::class, 'find']);

