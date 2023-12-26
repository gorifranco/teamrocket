<?php

use App\Http\Controllers\ArquitecteController;
use App\Http\Controllers\ComentariController;
use App\Http\Controllers\EspaiController;
use App\Http\Controllers\HoraActivaController;
use App\Http\Controllers\IllaController;
use App\Http\Controllers\ImatgeController;
use App\Http\Controllers\ModalitatController;
use App\Http\Controllers\MunicipiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuntInteresController;
use App\Http\Controllers\ServeiController;
use App\Http\Controllers\TipusEspaiController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\ZonaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::Resource('arquitectes', ArquitecteController::class)->only(['index', 'show', 'create']);
Route::Resource('comentaris', ComentariController::class)->only(['index', 'show']);
Route::Resource('espais', EspaiController::class)->only(['index', 'show']);
Route::Resource('hores-actives', HoraActivaController::class)->only(['index', 'show']);
Route::Resource('illes', IllaController::class);
Route::Resource('imatges', ImatgeController::class)->only(['index', 'show']);
Route::Resource('modalitats', ModalitatController::class)->only(['index', 'show']);
Route::Resource('municipis', MunicipiController::class);
Route::Resource('punts-interes', PuntInteresController::class)->only(['index', 'show']);
Route::Resource('serveis', ServeiController::class)->only(['index', 'show']);
Route::Resource('tipus-espais', TipusEspaiController::class)->only(['index', 'show']);
Route::Resource('visites', VisitaController::class)->only(['index', 'show']);
Route::Resource('zones', ZonaController::class);


require __DIR__.'/auth.php';
