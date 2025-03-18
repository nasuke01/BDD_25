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

// ✅ Route pour afficher la page avec les statistiques
Route::get('/classement', [CandidatController::class, 'afficherClassement']);


// ✅ Route pour afficher la page du classement en Blade
Route::get('/classement', [CandidatController::class, 'afficherClassement'])->name('classement');

// ✅ Route API pour récupérer les statistiques des candidats
Route::get('/api/statistiques', [CandidatController::class, 'statistiques'])->name('api.statistiques');


Route::get('/electeurs/import', [ElecteurController::class, 'showImportForm'])->name('electeurs.importForm');
Route::post('/electeurs/import', [ElecteurController::class, 'import'])->name('electeurs.import');
<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beno Bokk Parrainage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        /* ✅ Background Image en plein écran avec animation */
        .background-container {
            position: fixed;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/palaisp.jpg') }}") no-repeat center center;
            background-size: cover;
            opacity: 0;
            animation: fadeInBackground 2s ease-in-out forwards;
        }

        @keyframes fadeInBackground {
            from {
                opacity: 0;
                transform: scale(1.1);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ✅ Overlay pour rendre le texte lisible */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Assombrit l’image */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            opacity: 0;
            animation: fadeInOverlay 2s ease-in-out 1.5s forwards;
        }

        @keyframes fadeInOverlay {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .overlay h1 {
            font-size: 4rem;
            color: white;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .overlay p {
            font-size: 1.3rem;
            color: white;
            max-width: 800px;
            margin-top: 10px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
        }

        .cta-btn {
            background-color: #28a745;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.3s ease-in-out;
        }

        .cta-btn:hover {
            background-color: #218838;
        }

        /* ✅ Barre de navigation en haut */
        .navbar {
            position: absolute;
            top: 0;
            width: 100%;
            background: rgba(0, 123, 255, 0.8);
            padding: 1rem;
        }

        .navbar-brand, .nav-link {
            color: white !important;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <!-- ✅ Background Image -->
    <div class="background-container"></div>

    <!-- ✅ Barre de navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">🏛 Beno Bokk Parrainage</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Se connecter</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">S'inscrire</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ Overlay avec description et bouton -->
    <div class="overlay">
        <h1>BENO BOKK PARRAINAGE</h1>
        <p>
            Le Sénégal est un pays indépendant depuis le 4 avril 1960. Son premier président était <strong>Léopold Sédar Senghor</strong>,
            suivi de <strong>Abdou Diouf</strong>, <strong>Abdoulaye Wade</strong>, <strong>Macky Sall</strong> et d'autres figures emblématiques.
            Aujourd'hui, le parrainage électoral est une composante essentielle du processus démocratique sénégalais.
        </p>
        <p>
            Cette plateforme est conçue pour permettre aux citoyens d'exprimer leur soutien aux candidats et de participer activement
            à la vie politique de notre pays.
        </p>

        <!-- ✅ Bouton d'inscription -->
        <a href="{{ route('register') }}" class="cta-btn">
            Pour commencer Inscris toi en cliquant ici🚀
        </a>
    </div>
    

</body>
</html>
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Parrainer un candidat</h2>
    
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $candidat->user->nom }} {{ $candidat->user->prenom }}</h4>
            <p><strong>Parti :</strong> {{ $candidat->parti_politique ?? 'Indépendant' }}</p>
            <p><strong>Slogan :</strong> {{ $candidat->slogan ?? '—' }}</p>
            <img src="{{ $candidat->photo ?? asset('default.jpg') }}" alt="Photo de {{ $candidat->user->nom }}" class="img-fluid mb-3">
            <form action="{{ route('parrainage.store') }}" method="POST">
                @csrf
                <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                <button type="submit" class="btn btn-success">Confirmer mon parrainage</button>
            </form>
        </div>
    </div>
</div>
@endsection
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url("{{ asset('images/senegal.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            font-size: 1.2rem;
            padding: 10px;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .alert {
            color: red;
            font-size: 0.9rem;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            font-weight: bold;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Inscription</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Numéro Carte Électeur :</label>
                <input type="text" name="numCarteElecteur" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date de Naissance :</label>
                <input type="date" name="dateNaissance" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nom :</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Prénom :</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email :</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Téléphone :</label>
                <input type="text" name="telephone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Type Utilisateur :</label>
                <select name="type_utilisateur" class="form-select" required>
                    <option value="ELECTEUR">Électeur</option>
                    <option value="CANDIDAT">Candidat</option>
                    <option value="ADMINISTRATEUR">Administrateur</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Parti Politique (si Candidat) :</label>
                <input type="text" name="parti_politique" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe :</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer le mot de passe :</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>

            <a href="{{ route('login') }}" class="back-link">Déjà un compte ? Se connecter</a>
        </form>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importer Électeurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url("{{ asset('images/senegal.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            font-size: 1rem;
            font-weight: bold;
            padding: 10px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .alert {
            font-size: 1rem;
            text-align: center;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Importer la liste des électeurs</h1>

        @if(session('success'))
            <p class="alert success">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form method="POST" action="{{ route('electeurs.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Fichier CSV :</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Importer</button>
            </form>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Police et couleurs de base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f7;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        /* Card container */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f5a623, #f76c6c);
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .card-body {
            color: #fff;
            text-align: center;
        }

        .card-body .btn {
            width: 100%;
            padding: 15px;
            font-size: 1.2rem;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .card-body .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .card-body .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-body .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .card-body .btn-danger:hover {
            background-color: #c82333;
        }

        .card-body .btn-success {
            background-color: #28a745;
            border: none;
        }

        .card-body .btn-success:hover {
            background-color: #218838;
        }

        .alert {
            font-weight: bold;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        /* Link Hover Effect */
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            text-transform: uppercase;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Animation for buttons */
        .btn-primary, .btn-danger, .btn-success {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        .btn-primary::after, .btn-danger::after, .btn-success::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
            transform: scaleX(0);
            transform-origin: right;
        }

        .btn-primary:hover::after, .btn-danger:hover::after, .btn-success:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .btn-primary, .btn-danger, .btn-success {
            padding: 15px 30px;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Tableau de bord -->
        <div class="card">
            <div class="card-header">Tableau de Bord DGE</div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Affichage de la période actuelle -->
                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\ElecteurController;
use App\Http\Controllers\AuthController;

Route::prefix('admin')->middleware('auth')->group(function () {
    // ✅ Route pour le tableau de bord de l'administrateur
    Route::get('/dashboard', function () {
        $periode = \App\Models\PeriodeParrainage::latest()->first(); // Récupérer la période de parrainage
        return view('admin.dashboard', compact('periode'));
    })->name('admin.dashboard');

    // ✅ Route pour fermer le dépôt de candidatures
    Route::post('/fermer-candidature', [ParrainageController::class, 'fermerCandidature'])->name('admin.fermer.candidature');

    // ✅ Route pour fermer le parrainage
    Route::post('/fermer-parrainage', [ParrainageController::class, 'fermerParrainage'])->name('admin.fermer.parrainage');

    // ✅ Route pour rouvrir le dépôt de candidatures
    Route::post('/rouvrir-candidature', [ParrainageController::class, 'rouvrirCandidature'])->name('admin.rouvrir.candidature');

    // ✅ Route pour rouvrir le parrainage
    Route::post('/rouvrir-parrainage', [ParrainageController::class, 'rouvrirParrainage'])->name('admin.rouvrir.parrainage');

    // ✅ Route pour consulter le classement des candidats
    Route::get('/classement', [ParrainageController::class, 'afficherClassement'])->name('classement');

    // ✅ Route pour importer les électeurs
    Route::get('/electeurs/import', [ElecteurController::class, 'showImportForm'])->name('electeurs.importForm');
});
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\ElecteurController;
use App\Http\Controllers\AuthController;

Route::prefix('admin')->middleware('auth')->group(function () {
    // ✅ Route pour le tableau de bord de l'administrateur
    Route::get('/dashboard', function () {
        $periode = \App\Models\PeriodeParrainage::latest()->first(); // Récupérer la période de parrainage
        return view('admin.dashboard', compact('periode'));
    })->name('admin.dashboard');

    // ✅ Route pour fermer le dépôt de candidatures
    Route::post('/fermer-candidature', [ParrainageController::class, 'fermerCandidature'])->name('admin.fermer.candidature');

    // ✅ Route pour fermer le parrainage
    Route::post('/fermer-parrainage', [ParrainageController::class, 'fermerParrainage'])->name('admin.fermer.parrainage');

    // ✅ Route pour rouvrir le dépôt de candidatures
    Route::post('/rouvrir-candidature', [ParrainageController::class, 'rouvrirCandidature'])->name('admin.rouvrir.candidature');

    // ✅ Route pour rouvrir le parrainage
    Route::post('/rouvrir-parrainage', [ParrainageController::class, 'rouvrirParrainage'])->name('admin.rouvrir.parrainage');

    // ✅ Route pour consulter le classement des candidats
    Route::get('/classement', [ParrainageController::class, 'afficherClassement'])->name('classement');

    // ✅ Route pour importer les électeurs
    Route::get('/electeurs/import', [ElecteurController::class, 'showImportForm'])->name('electeurs.importForm');
});
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Tableau de Bord Administrateur
            </div>
            <div class="card-body">
                <h5 class="card-title">Gérer les opérations de parrainage</h5>
                
                <!-- Affichage des messages de succès ou d'erreur -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h3>Période de Parrainage Actuelle</h3>
                @if($periode)
                    <p><strong>Date de Début :</strong> {{ $periode->date_debut }}</p>
                    <p><strong>Date de Fin :</strong> {{ $periode->date_fin }}</p>
                @else
                    <p>Aucune période de parrainage définie.</p>
                @endif

                <!-- Actions administratives -->
                <form method="POST" action="{{ route('admin.fermer.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.fermer.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Fermer Parrainage</button>
                </form>

                <br>

                <!-- Boutons pour rouvrir les candidatures et le parrainage -->
                <form method="POST" action="{{ route('admin.rouvrir.candidature') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Dépôt de Candidature</button>
                </form>

                <form method="POST" action="{{ route('admin.rouvrir.parrainage') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Rouvrir Parrainage</button>
                </form>

                <br>

                <!-- Liens pour consulter les classements et importer un fichier -->
                <a href="{{ route('classement') }}" class="btn btn-primary">Consulter classement des candidats</a>
                <a href="{{ route('electeurs.importForm') }}" class="btn btn-primary mt-3">Importer fichier CSV</a>
            </div>
        </div>
    </div>

</body>
</html>
