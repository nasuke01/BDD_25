<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeParrainage;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Afficher le tableau de bord de l'administrateur
     */
    public function dashboard()
    {
        $periode = PeriodeParrainage::latest()->first();
        return view('admin.dashboard_admin', compact('periode'));
    }

    /**
     * Fermer le parrainage en mettant la date de fin à aujourd'hui
     */
    public function fermerParrainage()
    {
        $periode = PeriodeParrainage::latest()->first();

        if ($periode) {
            $periode->update(['date_fin' => Carbon::now()]);
            return redirect()->back()->with('success', 'Le parrainage a été fermé.');
        }

        return redirect()->back()->with('error', 'Aucune période de parrainage trouvée.');
    }

    /**
     * Fermer le dépôt de candidature en mettant la date de début à aujourd'hui
     */
    public function fermerCandidature()
    {
        $periode = PeriodeParrainage::latest()->first();

        if ($periode) {
            $periode->update(['date_debut' => Carbon::now()]);
            return redirect()->back()->with('success', 'Le dépôt des candidatures est fermé.');
        }

        return redirect()->back()->with('error', 'Aucune période de parrainage trouvée.');
    }

    /**
     * Rouvrir le parrainage en mettant une nouvelle date de fin
     */
    public function rouvrirParrainage()
    {
        $periode = PeriodeParrainage::latest()->first();

        if ($periode) {
            $periode->update(['date_fin' => Carbon::now()->addMonths(2)]);
            return redirect()->back()->with('success', 'Le parrainage a été rouvert pour 2 mois.');
        }

        return redirect()->back()->with('error', 'Aucune période de parrainage trouvée.');
    }

    /**
     * Rouvrir le dépôt des candidatures en mettant une nouvelle date de début
     */
    public function rouvrirCandidature()
    {
        $periode = PeriodeParrainage::latest()->first();

        if ($periode) {
            $periode->update(['date_debut' => Carbon::now()->addDays(7)]);
            return redirect()->back()->with('success', 'Le dépôt des candidatures est rouvert pour 7 jours.');
        }

        return redirect()->back()->with('error', 'Aucune période de parrainage trouvée.');
    }
}
