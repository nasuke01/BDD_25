<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeParrainage;
use App\Http\Requests\PeriodeParrainageRequest;

class PeriodeParrainageController extends Controller
{
    public function index()
    {
        return response()->json(PeriodeParrainage::all(), 200);
    }

    public function store(PeriodeParrainageRequest $request)
    {
        $periode = PeriodeParrainage::create($request->validated());
        return response()->json(['message' => 'Période de parrainage ajoutée avec succès', 'periode' => $periode], 201);
    }

    public function update(PeriodeParrainageRequest $request, $id)
    {
        $periode = PeriodeParrainage::find($id);
        if (!$periode) {
            return response()->json(['message' => 'Période de parrainage non trouvée'], 404);
        }
        $periode->update($request->validated());
        return response()->json(['message' => 'Période de parrainage mise à jour', 'periode' => $periode], 200);
    }
}