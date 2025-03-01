<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Candidat;

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

    /**
     * Enregistre un nouvel utilisateur et l'ajoute dans `candidats` si c'est un candidat
     */
    public function register(Request $request)
    {
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
            'parti_politique' => 'nullable|string|max:255', // ✅ Ajout du champ parti politique
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
                'parti_politique' => $validatedData['parti_politique'] ?? 'Indépendant', // ✅ Prend le parti sinon "Indépendant"
                'slogan' => $request->slogan ?? null,
                'photo' => $request->photo ?? null,
                'couleurs_parti' => $request->couleurs_parti ?? null,
                'url_candidat' => $request->url_candidat ?? null,
            ]);
        }

        return redirect('/login')->with('success', 'Inscription réussie ! Connectez-vous maintenant.');
    }
}
