<?php

use App\Enums\Role;
use Illuminate\Support\Facades\Route;
use App\Livewire\AdminDashboard\Accueil;
use App\Livewire\AdminDashboard\Classes;
use App\Livewire\AdminDashboard\Filieres;
use App\Livewire\AdminDashboard\Etudiants;
use App\Livewire\AdminDashboard\AddStudent;
use App\Livewire\AdminDashboard\AddTeacher;
use App\Livewire\AdminDashboard\Calendrier;
use App\Livewire\AdminDashboard\EditStudent;
use App\Livewire\AdminDashboard\EditTeacher;
use App\Livewire\AdminDashboard\Professeurs;
use App\Livewire\AdminDashboard\ClassDetails;
use App\Livewire\AdminDashboard\Departements;
use App\Livewire\AdminDashboard\ShowProfesseur;
use App\Livewire\AdminDashboard\EtudiantProfile;
use App\Livewire\AdminDashboard\AddEditProfesseur;
use App\Livewire\AdminDashboard\ProfesseurProfile;

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
    'role:' . Role::ADMIN
])->group(function () {
    Route::get('/accueil', Accueil::class)->name('accueil');
    Route::get('/professeurs', Professeurs::class)->name('professeurs');
    Route::get('/professeurs/add', AddTeacher::class)->name('professeur.add');
    Route::get('/professeurs/show/{id}', ProfesseurProfile::class)->name('professeur.profile');
    // Route::get('/professeurs/edit/{id}', [AddEditProfesseur::class, 'edit'])->name('professeur.edit');
    Route::get('/professeurs/edit/{id}', EditTeacher::class)->name('professeur.edit');
    Route::get('/etudiants', Etudiants::class)->name('etudiants');
    Route::get('/etudiants/add', AddStudent::class)->name('etudiant.add');
    Route::get('/etudiants/{id}', [EtudiantProfile::class, 'show'])->name('etudiant.profile');
    Route::get('/etudiants/edit/{id}', EditStudent::class)->name('etudiant.edit');
    Route::get('/classes', Classes::class)->name('classes');
    Route::get('/classe/{id}', ClassDetails::class)->name('classe.show');
    Route::get('/filieres', Filieres::class)->name('filieres');
    Route::get('/departements', Departements::class)->name('departements');
    Route::get('/calendrier', Calendrier::class)->name('calendrier');
});
