<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parrainage;
use App\Models\PeriodeParrainage;
use Carbon\Carbon;

class ParrainageController extends Controller
{
    /**
     * Enregistrer un parrainage et empêcher après la date de fin
     */
    public function store(Request $request)
    {
        $periode = PeriodeParrainage::latest()->first();
        $now = Carbon::now();

        // ✅ Vérifier si la période de parrainage est encore ouverte
        if ($periode && $now->greaterThanOrEqualTo($periode->date_fin)) {
            return back()->withErrors(['error' => 'Le parrainage est fermé car la période est terminée.']);
        }

        // ✅ Validation
        $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
        ]);

        $electeurId = auth()->id();

        // Vérifie si l'électeur a déjà parrainé un candidat
        if (Parrainage::where('electeur_id', $electeurId)->exists()) {
            return back()->withErrors(['error' => 'Vous avez déjà parrainé un candidat.']);
        }

        // ✅ Enregistrement du parrainage
        $parrainage = new Parrainage();
        $parrainage->electeur_id = $electeurId;
        $parrainage->candidat_id = $request->candidat_id;
        $parrainage->save();

        return redirect()->route('candidats.afficher')->with('success', 'Parrainage enregistré avec succès !');
    }
}
