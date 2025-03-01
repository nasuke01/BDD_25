<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeParrainage;
use Carbon\Carbon;

class PeriodeParrainageController extends Controller
{
    /**
     * Afficher le formulaire d'ajout de période de parrainage
     */
    public function showForm()
    {
        return view('admin.parrainage');
    }

    /**
     * Enregistrer une nouvelle période de parrainage
     */
    public function store(Request $request)
    {
        // Récupérer la date actuelle
        $now = Carbon::now();

        // ✅ Validation des dates
        $request->validate([
            'date_debut' => ['required', 'date', 'after:' . $now->addMonths(6)->toDateString()],
            'date_fin' => ['required', 'date', 'after:date_debut'],
        ]);

        // ✅ Enregistrer la période
        PeriodeParrainage::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        return redirect()->back()->with('success', 'Période de parrainage enregistrée avec succès.');
    }
}
