<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Http\Requests\CandidatRequest;
use App\Models\User;

class CandidatController extends Controller
{
    /**
     * Récupérer la liste des candidats en JSON
     */
    public function index()
    {
        return response()->json(Candidat::with('user:id,nom,prenom,email')->get(), 200);
    }

    /**
     * Afficher la liste des candidats en Blade
     */
    public function afficherCandidats()
    {
        $candidats = Candidat::with('user')->get();
        return view('candidats', compact('candidats'));
    }

    /**
     * Ajouter un candidat manuellement
     */
    public function store(CandidatRequest $request)
    {
        $candidat = Candidat::create($request->validated());
        return response()->json(['message' => 'Candidat ajouté avec succès', 'candidat' => $candidat], 201);
    }

    /**
     * Récupérer un candidat spécifique
     */
    public function show($id)
    {
        $candidat = Candidat::find($id);
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
        return response()->json($candidat, 200);
    }

    /**
     * Mettre à jour un candidat
     */
    public function update(CandidatRequest $request, $id)
    {
        $candidat = Candidat::find($id);
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
        $candidat->update($request->validated());
        return response()->json(['message' => 'Candidat mis à jour', 'candidat' => $candidat], 200);
    }

    /**
     * Supprimer un candidat
     */
    public function destroy($id)
    {
        $candidat = Candidat::find($id);
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
        $candidat->delete();
        return response()->json(['message' => 'Candidat supprimé'], 200);
    }

    /**
     * Ajouter un candidat automatiquement après inscription
     */
    public function addCandidateAfterRegister($userId, $data)
    {
        $user = User::find($userId);
        if (!$user || $user->type_utilisateur !== 'CANDIDAT') {
            return response()->json(['message' => 'Utilisateur non valide ou non candidat'], 400);
        }

        // Vérifier si le candidat existe déjà
        if (Candidat::where('user_id', $userId)->exists()) {
            return response()->json(['message' => 'Candidat déjà enregistré'], 400);
        }

        // Création du candidat
        $candidat = Candidat::create([
            'user_id' => $userId,
            'parti_politique' => $data['parti_politique'] ?? null,
            'slogan' => $data['slogan'] ?? null,
            'photo' => $data['photo'] ?? null,
            'couleurs_parti' => $data['couleurs_parti'] ?? null,
            'url_candidat' => $data['url_candidat'] ?? null,
        ]);

        return response()->json(['message' => 'Candidat ajouté après inscription', 'candidat' => $candidat], 201);
    }
}
