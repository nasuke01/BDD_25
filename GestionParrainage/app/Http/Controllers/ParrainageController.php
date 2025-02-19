<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parrainage;
use App\Http\Requests\ParrainageRequest;

class ParrainageController extends Controller
{
    public function index()
    {
        return response()->json(Parrainage::all(), 200);
    }

    public function store(ParrainageRequest $request)
    {
        $parrainage = Parrainage::create($request->validated());
        return response()->json(['message' => 'Parrainage ajouté avec succès', 'parrainage' => $parrainage], 201);
    }

    public function show($id)
    {
        $parrainage = Parrainage::find($id);
        if (!$parrainage) {
            return response()->json(['message' => 'Parrainage non trouvé'], 404);
        }
        return response()->json($parrainage, 200);
    }

    public function update(ParrainageRequest $request, $id)
    {
        $parrainage = Parrainage::find($id);
        if (!$parrainage) {
            return response()->json(['message' => 'Parrainage non trouvé'], 404);
        }
        $parrainage->update($request->validated());
        return response()->json(['message' => 'Parrainage mis à jour', 'parrainage' => $parrainage], 200);
    }

    public function destroy($id)
    {
        $parrainage = Parrainage::find($id);
        if (!$parrainage) {
            return response()->json(['message' => 'Parrainage non trouvé'], 404);
        }
        $parrainage->delete();
        return response()->json(['message' => 'Parrainage supprimé'], 200);
    }
}