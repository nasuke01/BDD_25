<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\AdminController;
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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ Route protégée pour afficher la page après connexion
Route::middleware(['auth'])->get('/accueil-parrainage', [ParrainageController::class, 'accueilParrainage'])->name('accueil.parrainage');

// ✅ Route protégée pour afficher le profil après connexion
Route::middleware(['auth'])->get('/profile', [UserController::class, 'profile'])->name('profile');

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

// ✅ Route pour afficher la liste des candidats
Route::get('/candidats', [CandidatController::class, 'afficherCandidats'])->name('candidats.afficher');

// ✅ Route pour afficher la liste des candidats en Blade
Route::middleware(['auth'])->get('/candidats', [CandidatController::class, 'afficherCandidats'])->name('candidats.afficher');

// ✅ Route pour afficher le formulaire de parrainage en Blade
Route::middleware(['auth'])->get('/parrainer/{id}', [ParrainageController::class, 'afficherFormulaire'])->name('parrainage.form');
Route::middleware(['auth'])->post('/parrainage', [ParrainageController::class, 'store'])->name('parrainage.store');

// ✅ Routes pour le parrainage (API JSON)
Route::get('/parrainage', [ParrainageController::class, 'index'])->name('parrainage.index');
Route::post('/parrainage', [ParrainageController::class, 'store'])->name('parrainage.store');
Route::get('/parrainage/confirmation', [ParrainageController::class, 'confirmation'])->name('parrainage.confirmation');

// ✅ Routes pour la gestion des électeurs
Route::get('/electeurs/import', [ElecteurController::class, 'importForm'])->name('electeurs.importForm');
Route::post('/electeurs/import', [ElecteurController::class, 'import'])->name('electeurs.import');
Route::get('/electeurs/verification', [ElecteurController::class, 'verification'])->name('electeurs.verification');

// ✅ Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

use App\Http\Controllers\PeriodeParrainageController;

// ✅ Route pour afficher le formulaire d'ajout de période (admin uniquement)
Route::get('/admin/parrainage', [PeriodeParrainageController::class, 'showForm'])->name('periode.form');
Route::post('/admin/parrainage', [PeriodeParrainageController::class, 'store'])->name('periode.store');


// ✅ Route protégée pour le tableau de bord de l'admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/fermer-parrainage', [AdminController::class, 'fermerParrainage'])->name('admin.fermer.parrainage');
    Route::post('/admin/fermer-candidature', [AdminController::class, 'fermerCandidature'])->name('admin.fermer.candidature');
});

// ✅ Routes pour la gestion des périodes de parrainage
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/fermer-parrainage', [AdminController::class, 'fermerParrainage'])->name('admin.fermer.parrainage');
    Route::post('/admin/fermer-candidature', [AdminController::class, 'fermerCandidature'])->name('admin.fermer.candidature');

    // ✅ Routes pour rouvrir les candidatures et le parrainage
    Route::post('/admin/rouvrir-parrainage', [AdminController::class, 'rouvrirParrainage'])->name('admin.rouvrir.parrainage');
    Route::post('/admin/rouvrir-candidature', [AdminController::class, 'rouvrirCandidature'])->name('admin.rouvrir.candidature');
});


// ✅ Route pour afficher le formulaire de parrainage
Route::get('/parrainer/{id}', [ParrainageController::class, 'afficherFormulaire'])->name('parrainage.form');
// ✅ Route pour afficher la page d'accueil du parrainage
Route::get('/accueil-parrainage', [ParrainageController::class, 'accueilParrainage'])->name('accueil.parrainage');
 


// ✅ Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ✅ Route API pour récupérer les statistiques des candidats
Route::get('/api/statistiques', [CandidatController::class, 'statistiques']);

// ✅ Route pour afficher le classement en React
Route::get('/classement', function () {
    return view('classement');
});
