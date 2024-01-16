<?php

use App\Http\Controllers\ProfileController;
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

Route::inertia("/espai/{id}", "Espai")->name("espai");

Route::group(['middleware' => 'auth'], function() {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::inertia("/arquitectes", "Arquitectes")->name('arquitectes');
    Route::inertia("/serveis", "Serveis")->name('serveis');
    Route::inertia("/modalitats", "Modalitats")->name('modalitats');
    Route::inertia("/tipus_espais", "Tipus_espais")->name('tipus_espais');
    Route::inertia("/espais", "Espais")->name('espais_per_gestor');
    Route::inertia("/editarEspai/{id}", "Espai_edit")->name("editarEspai");
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
