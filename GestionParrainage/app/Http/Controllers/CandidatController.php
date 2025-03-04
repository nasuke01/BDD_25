<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;

class CandidatController extends Controller
{
  
    
    public function afficherClassement()
{
    $candidats = Candidat::with('user')->orderByDesc('parrainages_count')->get();

    return view('classement', compact('candidats'));
}

    
public function statistiques()
{
    $candidats = Candidat::with('user:id,nom,prenom') // ✅ On récupère bien le user avec son nom et prénom
                        ->orderByDesc('parrainages_count')
                        ->get();

    return response()->json($candidats);
}

  
    public function afficherCandidats()
    {
        $candidats = Candidat::with('user')->get(); // Récupère tous les candidats avec leurs informations utilisateur
    
        return view('candidats', compact('candidats'));
    }
    

}
