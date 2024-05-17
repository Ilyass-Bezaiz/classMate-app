<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\AdminDashboard\Accueil;
use App\Livewire\AdminDashboard\Etudiants;
use App\Livewire\AdminDashboard\Calendrier;
use App\Livewire\AdminDashboard\Professeurs;

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
    Route::get('/etudiants', Etudiants::class)->name('etudiants');
    Route::get('/classes', Etudiants::class)->name('classes');
    Route::get('/calendrier', Calendrier::class)->name('calendrier');
});
