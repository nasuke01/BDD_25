<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Candidat;
use App\Models\PeriodeParrainage;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
{
    // ✅ Validation des champs
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors(['email' => 'Les informations de connexion sont incorrectes.']);
    }

    $request->session()->regenerate();

    // ✅ Vérifier si c'est un administrateur
    if (Auth::user()->type_utilisateur === 'ADMINISTRATEUR') {
        return redirect()->route('admin.dashboard')->with('success', 'Bienvenue sur le tableau de bord administrateur.');
    }

    return redirect()->route('accueil.parrainage')->with('success', 'Connexion réussie !');
}


    /**
     * Enregistre un nouvel utilisateur et bloque l'inscription des candidats après le début du parrainage
     */
    public function register(Request $request)
    {
        $periode = PeriodeParrainage::latest()->first();
        $now = Carbon::now();

        // ✅ Vérifier si la période de parrainage a déjà commencé et empêcher l'inscription des candidats
        if ($periode && $now->greaterThanOrEqualTo($periode->date_debut) && $request->type_utilisateur === 'CANDIDAT') {
            return back()->withErrors(['error' => 'L\'ajout de candidats est fermé car la période de parrainage a commencé.']);
        }

        // ✅ Validation des champs
        $validatedData = $request->validate([
            'numCarteElecteur' => 'required|string|unique:users,numCarteElecteur',
            'dateNaissance' => 'required|date',
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|unique:users,telephone',
            'type_utilisateur' => 'required|in:ELECTEUR,CANDIDAT,ADMINISTRATEUR',
            'password' => 'required|string|min:6|confirmed',
            'parti_politique' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:255',
        ]);

        // ✅ Création de l'utilisateur
        $user = User::create([
            'numCarteElecteur' => $validatedData['numCarteElecteur'],
            'dateNaissance' => $validatedData['dateNaissance'],
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'telephone' => $validatedData['telephone'],
            'type_utilisateur' => $validatedData['type_utilisateur'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // ✅ Ajouter dans `candidats` si c'est un candidat
        if ($user->type_utilisateur === 'CANDIDAT') {
            Candidat::create([
                'user_id' => $user->id,
                'parti_politique' => $validatedData['parti_politique'] ?? 'Indépendant',
                'slogan' => $validatedData['slogan'] ?? 'Aucun slogan défini',
                'photo' => $request->photo ?? null,
                'couleurs_parti' => $request->couleurs_parti ?? null,
                'url_candidat' => $request->url_candidat ?? null,
            ]);
        }

        return redirect('/login')->with('success', 'Inscription réussie ! Connectez-vous maintenant.');
    }
}
