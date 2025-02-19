<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Electeur;
use App\Http\Requests\ElecteurRequest;

class ElecteurController extends Controller
{
    public function index()
    {
        return response()->json(Electeur::all(), 200);
    }

    public function store(ElecteurRequest $request)
    {
        $electeur = Electeur::create($request->validated());
        return response()->json(['message' => 'Électeur ajouté avec succès', 'electeur' => $electeur], 201);
    }

    public function show($id)
    {
        $electeur = Electeur::find($id);
        if (!$electeur) {
            return response()->json(['message' => 'Électeur non trouvé'], 404);
        }
        return response()->json($electeur, 200);
    }

    public function update(ElecteurRequest $request, $id)
    {
        $electeur = Electeur::find($id);
        if (!$electeur) {
            return response()->json(['message' => 'Électeur non trouvé'], 404);
        }
        $electeur->update($request->validated());
        return response()->json(['message' => 'Électeur mis à jour', 'electeur' => $electeur], 200);
    }

    public function destroy($id)
    {
        $electeur = Electeur::find($id);
        if (!$electeur) {
            return response()->json(['message' => 'Électeur non trouvé'], 404);
        }
        $electeur->delete();
        return response()->json(['message' => 'Électeur supprimé'], 200);
    }
}
