<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parrainage;
use App\Http\Requests\ParrainageRequest;
use App\Models\Candidat;

class ParrainageController extends Controller
{
    /**
     * Récupérer la liste des parrainages (JSON)
     */
    public function index()
    {
        return response()->json(Parrainage::all(), 200);
    }

    /**
     * Afficher le formulaire de parrainage pour un candidat donné
     */
    public function afficherFormulaire($id)
    {
        $candidat = Candidat::with('user')->findOrFail($id);
        return view('parrainer', compact('candidat'));
    }

    /**
     * Enregistrer un parrainage
     */
    public function store(Request $request)
    {
        $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
        ]);

        $electeurId = auth()->id(); // Récupère l'ID de l'électeur connecté

        // Vérifie si l'électeur a déjà parrainé un candidat
        if (Parrainage::where('electeur_id', $electeurId)->exists()) {
            return redirect()->back()->with('error', 'Vous avez déjà parrainé un candidat.');
        }

        // Enregistrement du parrainage
        $parrainage = new Parrainage();
        $parrainage->electeur_id = $electeurId;
        $parrainage->candidat_id = $request->candidat_id;
        $parrainage->save();

        return redirect()->route('candidats.afficher')->with('success', 'Parrainage enregistré avec succès !');
    }

    /**
     * Récupérer un parrainage spécifique (JSON)
     */
    public function show($id)
    {
        $parrainage = Parrainage::find($id);
        if (!$parrainage) {
            return response()->json(['message' => 'Parrainage non trouvé'], 404);
        }
        return response()->json($parrainage, 200);
    }

    /**
     * Mettre à jour un parrainage (JSON)
     */
    public function update(ParrainageRequest $request, $id)
    {
        $parrainage = Parrainage::find($id);
        if (!$parrainage) {
            return response()->json(['message' => 'Parrainage non trouvé'], 404);
        }
        $parrainage->update($request->validated());
        return response()->json(['message' => 'Parrainage mis à jour', 'parrainage' => $parrainage], 200);
    }

    /**
     * Supprimer un parrainage (JSON)
     */
    public function destroy($id)
    {
        $parrainage = Parrainage::find($id);
        if (!$parrainage) {
            return response()->json(['message' => 'Parrainage non trouvé'], 404);
        }
        $parrainage->delete();
        return response()->json(['message' => 'Parrainage supprimé'], 200);
    }
}
