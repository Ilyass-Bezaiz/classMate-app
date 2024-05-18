<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\AdminDashboard\Accueil;
use App\Livewire\AdminDashboard\Etudiants;
use App\Livewire\AdminDashboard\Calendrier;
use App\Livewire\AdminDashboard\ClassDetails;
use App\Livewire\AdminDashboard\Classes;
use App\Livewire\AdminDashboard\Professeurs;
use App\Livewire\AdminDashboard\ShowProfesseur;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/accueil', Accueil::class)->name('accueil');
    Route::get('/professeurs', Professeurs::class)->name('professeurs');
    Route::get('/professeurs/{id}', [Professeurs::class, 'show'])->name('professeurs.show');
    Route::get('/etudiants', Etudiants::class)->name('etudiants');
    Route::get('/etudiants/{id}', [Etudiants::class, 'show'])->name('etudiants.show');
    Route::get('/classes', Classes::class)->name('classes');
    Route::get('/classe/{id}', ClassDetails::class)->name('classe.show');
    Route::get('/calendrier', Calendrier::class)->name('calendrier');
});
