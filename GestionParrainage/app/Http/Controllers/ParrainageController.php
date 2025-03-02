<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parrainage;
use App\Models\Candidat;

class ParrainageController extends Controller
{
    /**
     * Afficher la page d'accueil du parrainage
     */
    public function accueilParrainage()
    {
        return view('accueil-parrainage');
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

        $electeurId = auth()->id();

        // Vérifie si l'électeur a déjà parrainé un candidat
        if (Parrainage::where('electeur_id', $electeurId)->exists()) {
            return redirect()->back()->with('error', 'Vous avez déjà parrainé un candidat.');
        }

        // Enregistrement du parrainage
        Parrainage::create([
            'electeur_id' => $electeurId,
            'candidat_id' => $request->candidat_id,
        ]);
        return redirect()->route('candidats.afficher')->with('success', 'Votre parrainage a été enregistré avec succès.');
        return redirect()->route('candidats.afficher')->with('success', 'Parrainage enregistré avec succès !');
    }
    
}
