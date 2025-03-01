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
     * Enregistre un nouvel utilisateur et l'ajoute à la table `candidats` si c'est un candidat
     */
    public function register(Request $request)
    {
        // ✅ Vérifier que les données du formulaire sont bien envoyées
        // dd($request->all());

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
        ]);

        // ✅ Création de l'utilisateur dans `users`
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

        // ✅ Vérification si l'utilisateur est bien créé
        // dd($user);

        // ✅ Ajouter dans `candidats` si c'est un candidat
        if ($user->type_utilisateur === 'CANDIDAT') {
            Candidat::create([
                'user_id' => $user->id,
                'parti_politique' => $request->parti_politique ?? null,
                'slogan' => $request->slogan ?? null,
                'photo' => $request->photo ?? null,
                'couleurs_parti' => $request->couleurs_parti ?? null,
                'url_candidat' => $request->url_candidat ?? null,
            ]);
        }

        // ✅ Redirection vers la page de connexion avec message de succès
        return redirect('/login')->with('success', 'Inscription réussie ! Connectez-vous maintenant.');
    }

    /**
     * Connecte un utilisateur et redirige vers /accueil-parrainage
     */
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

        return redirect()->route('accueil.parrainage')->with('success', 'Connexion réussie !');
    }

    /**
     * Déconnecte l'utilisateur et redirige vers /login
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Déconnexion réussie.');
    }
}
