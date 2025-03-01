<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;

class CandidatController extends Controller
{
    public function afficherCandidats()
    {
        $candidats = Candidat::with('user')->get();

        if ($candidats->isEmpty()) {
            return view('candidats')->with('message', 'Aucun candidat trouvé.');
        }

        return view('candidats', compact('candidats'));
    }
}
