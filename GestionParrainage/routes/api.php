<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\DGEController;

Route::prefix('api')->group(function () {
    // 📌 Authentification
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

    // 📌 Gestion des parrainages (Protégé)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/parrainages', [ParrainageController::class, 'index']);
        Route::post('/parrainage', [ParrainageController::class, 'create']);
        Route::put('/parrainage/{id}', [ParrainageController::class, 'update']);
        Route::delete('/parrainage/{id}', [ParrainageController::class, 'delete']);
    });

    // 📌 Routes réservées à la DGE (Admin uniquement)
    Route::middleware(['auth:sanctum', 'role:DGE'])->prefix('dge')->group(function () {
        Route::post('/import-electeurs', [DGEController::class, 'importElecteurs']);
        Route::post('/ajouter-candidat', [DGEController::class, 'ajouterCandidat']);
        Route::get('/monitoring', [DGEController::class, 'monitorParrainages']);
        Route::post('/gerer-parrainage', [DGEController::class, 'gererParrainage']);
    });
});
