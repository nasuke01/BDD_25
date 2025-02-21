<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\ElecteurController;
use App\Http\Controllers\DashboardController;

// ✅ Test pour voir si Laravel fonctionne
Route::get('/test', function () {
    return "Laravel fonctionne !";
})->name('test');

// ✅ Routes pour afficher les formulaires d'authentification
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// ✅ Routes pour l'inscription et la connexion
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// ✅ Route pour la déconnexion (GET pour tests, POST pour sécurité)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout.post');

// ✅ Routes protégées pour l'utilisateur connecté
Route::middleware('auth:sanctum')->group(function () {
    // 📌 Profil utilisateur
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

    // 📌 Mise à jour du profil utilisateur
    Route::get('/user/update', function () {
        return view('auth.update'); // Assurez-vous que ce fichier existe dans resources/views/auth/update.blade.php
    })->name('user.update');

    Route::put('/user/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
});

// ✅ Accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ✅ Routes pour les candidats (API JSON)
Route::get('/candidats-json', [CandidatController::class, 'index'])->name('candidats.index');
Route::get('/candidats/inscription', [CandidatController::class, 'create'])->name('candidats.create');
Route::post('/candidats', [CandidatController::class, 'store'])->name('candidats.store');

// ✅ Route pour afficher la liste des candidats en Blade
Route::get('/candidats', [CandidatController::class, 'afficherCandidats'])->name('candidats.afficher');

// route pour afficher parrainage en blade
Route::get('/parrainer/{id}', [ParrainageController::class, 'afficherFormulaire'])->name('parrainage.form');
Route::post('/parrainage', [ParrainageController::class, 'store'])->name('parrainage.store');


// ✅ Routes pour le parrainage
Route::get('/parrainage', [ParrainageController::class, 'index'])->name('parrainage.index');
Route::post('/parrainage', [ParrainageController::class, 'store'])->name('parrainage.store');
Route::get('/parrainage/confirmation', [ParrainageController::class, 'confirmation'])->name('parrainage.confirmation');

// ✅ Routes pour la gestion des électeurs
Route::get('/electeurs/import', [ElecteurController::class, 'importForm'])->name('electeurs.importForm');
Route::post('/electeurs/import', [ElecteurController::class, 'import'])->name('electeurs.import');
Route::get('/electeurs/verification', [ElecteurController::class, 'verification'])->name('electeurs.verification');

// ✅ Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
