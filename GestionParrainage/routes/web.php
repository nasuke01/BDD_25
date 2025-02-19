<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

// ✅ Route pour la déconnexion (disponible en GET pour tests et POST pour sécurité)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout.post');

// ✅ Routes protégées pour l'utilisateur connecté
Route::middleware('auth:sanctum')->group(function () {
    // 📌 Profil utilisateur
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

    // 📌 Mise à jour du profil utilisateur (Page et API)
    Route::get('/user/update', function () {
        return view('auth.update'); // Vérifie que ce fichier existe dans resources/views/auth/update.blade.php
    })->name('user.update');

    Route::put('/user/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
});
