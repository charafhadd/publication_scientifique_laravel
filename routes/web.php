<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ResearchTeamController;
use App\Http\Controllers\AdminController;

// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentification
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Pages publiques
Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
Route::get('/publications/{id}', [PublicationController::class, 'show'])->name('publications.show');
Route::get('/equipes', [ResearchTeamController::class, 'index'])->name('equipes.index');
Route::get('/equipes/{id}', [ResearchTeamController::class, 'show'])->name('equipes.show');

// Routes pour utilisateurs connectés
Route::get('/tableau-de-bord', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/mes-publications', [PublicationController::class, 'mesPublications'])->name('publications.mes');
Route::get('/publications/creer', [PublicationController::class, 'create'])->name('publications.create');
Route::post('/publications', [PublicationController::class, 'store'])->name('publications.store');
Route::delete('/publications/{id}', [PublicationController::class, 'destroy'])->name('publications.destroy');

// Routes Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    
    // Utilisateurs
    Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('admin.utilisateurs');
    Route::post('/utilisateurs', [AdminController::class, 'creerUtilisateur'])->name('admin.utilisateurs.store');
    Route::put('/utilisateurs/{id}', [AdminController::class, 'modifierUtilisateur'])->name('admin.utilisateurs.update');
    Route::delete('/utilisateurs/{id}', [AdminController::class, 'supprimerUtilisateur'])->name('admin.utilisateurs.destroy');
    
    // Équipes
    Route::get('/equipes', [AdminController::class, 'equipes'])->name('admin.equipes');
    Route::post('/equipes', [AdminController::class, 'creerEquipe'])->name('admin.equipes.store');
    Route::put('/equipes/{id}', [AdminController::class, 'modifierEquipe'])->name('admin.equipes.update');
    Route::delete('/equipes/{id}', [AdminController::class, 'supprimerEquipe'])->name('admin.equipes.destroy');
    
    // Catégories
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'creerCategorie'])->name('admin.categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'modifierCategorie'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'supprimerCategorie'])->name('admin.categories.destroy');
});