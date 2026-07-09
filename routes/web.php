<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuiviController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. ACCUEIL PUBLIC (Site Vitrine)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('accueil');


/*
|--------------------------------------------------------------------------
| 2. ROUTES SÉCURISÉES (Utilisateurs connectés)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- AIGUILLAGE DASHBOARD (Affiche le bureau selon le rôle) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // --- GESTION & CONSULTATION DES DOSSIERS ---
    
    // Liste des dossiers (Visible par tous les agents et titulaires)
    Route::get('/dossiers', [DossierController::class, 'index'])->name('dossiers.index');

    // Fiche d'instruction détaillée (Le poste de travail scindé avec PDF)
    Route::get('/dossiers/voir/{dossier}', [DossierController::class, 'show'])->name('dossiers.show');


    // --- ACTIONS : DÉPÔT & ENREGISTREMENT (Titulaire, Secrétaire, Admin) ---
    Route::middleware('role:titulaire,admin,public,secretaire')->group(function () {
        Route::get('/nouveau-dossier', [DossierController::class, 'create'])->name('dossiers.create');
        Route::post('/nouveau-dossier/enregistrer', [DossierController::class, 'store'])->name('dossiers.store');
    });


    // --- ACTIONS : TRAITEMENT MÉTIER (Secrétariat, Géométrie, Direction, Cabinet) ---
    Route::middleware('role:admin,secretaire,geometre,geologue,chef_division,ministre')->group(function () {
        Route::post('/dossiers/{dossier}/traiter', [DossierController::class, 'traiter'])->name('dossiers.traiter');
    });


    // --- ACTIONS : DIRECTION & CABINET (Transitions et Clôture) ---
    Route::middleware('role:admin,chef_division,ministre')->group(function () {
        // Validation des étapes (Avis Technique et Octroi) via le workflow
        Route::patch('/dossiers/validation/{dossier}/next', [DossierController::class, 'nextStep'])->name('dossiers.next');
        
        // Notification aux bureaux territoriaux (Action finale de clôture par le Chef de Division)
        Route::post('/dossiers/{dossier}/notifier', [DossierController::class, 'notifierTerritoire'])->name('dossiers.notifier');
    });


    // --- ACTIONS : SUIVI DE TERRAIN (Agent Territorial) ---
    Route::middleware('role:admin,agent_territorial')->group(function () {
        Route::post('/dossiers/{dossier}/installer', [SuiviController::class, 'installer'])->name('suivi.installer');
        Route::post('/dossiers/{dossier}/rapport', [SuiviController::class, 'rapport'])->name('suivi.rapport');
    });


    // --- ADMINISTRATION SYSTÈME (Gestion du Personnel & Comptes) ---
    // CORRECTION : Ajout de toutes les routes nécessaires pour l'Admin
    Route::middleware('role:admin')->group(function () {
        // Liste des utilisateurs
        Route::get('/admin/utilisateurs', [AdminController::class, 'users'])->name('admin.users');
        
        // Création manuelle d'un compte agent/utilisateur
        Route::post('/admin/utilisateurs/creer', [AdminController::class, 'store'])->name('admin.users.store');
        
        // Mise à jour d'un compte (Rôle & Territoire)
        Route::patch('/admin/utilisateurs/{user}', [AdminController::class, 'updateRole'])->name('admin.users.update');
        
        // Suppression d'un compte (La route qui manquait)
        Route::delete('/admin/utilisateurs/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    });


    // --- PROFIL PERSONNEL (Laravel Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';