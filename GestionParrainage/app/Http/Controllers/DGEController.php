<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DGEController extends Controller
{
    public function importElecteurs()
    {
        return response()->json(['message' => 'Liste des électeurs importée']);
    }

    public function ajouterCandidat()
    {
        return response()->json(['message' => 'Candidat ajouté']);
    }

    public function monitorParrainages()
    {
        return response()->json(['parrainages' => []]);
    }

    public function gererParrainage()
    {
        return response()->json(['message' => 'Parrainage ouvert ou fermé']);
    }
}
