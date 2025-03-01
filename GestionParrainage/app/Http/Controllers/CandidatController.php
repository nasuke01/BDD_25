<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;

class CandidatController extends Controller
{
    /**
     * Afficher la liste des candidats
     */
    public function afficherCandidats()
    {
        $candidats = Candidat::with('user')->get(); // ✅ Récupérer les candidats avec leurs utilisateurs
        return view('candidats', compact('candidats')); // ✅ Envoyer les candidats à la vue
    }
}
