<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Http\Requests\CandidatRequest;

class CandidatController extends Controller
{
    public function index()
    {
        return response()->json(Candidat::all(), 200);
    }

    public function store(CandidatRequest $request)
    {
        $candidat = Candidat::create($request->validated());
        return response()->json(['message' => 'Candidat ajouté avec succès', 'candidat' => $candidat], 201);
    }

    public function show($id)
    {
        $candidat = Candidat::find($id);
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
        return response()->json($candidat, 200);
    }

    public function update(CandidatRequest $request, $id)
    {
        $candidat = Candidat::find($id);
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
        $candidat->update($request->validated());
        return response()->json(['message' => 'Candidat mis à jour', 'candidat' => $candidat], 200);
    }

    public function destroy($id)
    {
        $candidat = Candidat::find($id);
        if (!$candidat) {
            return response()->json(['message' => 'Candidat non trouvé'], 404);
        }
        $candidat->delete();
        return response()->json(['message' => 'Candidat supprimé'], 200);
    }
}