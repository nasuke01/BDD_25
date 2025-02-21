<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Candidat;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('auth.register'); // Vérifie que resources/views/auth/register.blade.php existe
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Vérifie que resources/views/auth/login.blade.php existe
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function register(Request $request)
    {
        // ✅ Validation des données
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

        // ✅ Si l'utilisateur est un candidat, on l'ajoute dans la table `candidats`
        if ($user->type_utilisateur == 'CANDIDAT') {
            app(CandidatController::class)->addCandidateAfterRegister($user->id, $request->all());
        }

        // ✅ Gestion des réponses en fonction du type de requête
        if ($request->wantsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token], 201);
        } else {
            return redirect('/register')->with('success', 'Inscription réussie ! Connectez-vous maintenant.');
        }
    }

    /**
     * Connecte un utilisateur
     */
    public function login(Request $request)
    {
        // ✅ Validation des champs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Vérifier si les identifiants sont valides
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Récupérer l'utilisateur
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Déconnecte l'utilisateur (suppression du token)
     */
    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Aucun utilisateur connecté.'], 401);
        }

        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Déconnexion réussie.']);
    }
}
