<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Electeur;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ElecteurController extends Controller
{
    /**
     * Afficher la liste des électeurs
     */
    public function index()
    {
        return response()->json(Electeur::all(), 200);
    }

    /**
     * Enregistrer un nouvel électeur
     */
    public function store(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'numCarteElecteur' => 'required|string|unique:electeurs,numCarteElecteur',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'dateNaissance' => 'required|date',
            'email' => 'required|email|unique:electeurs,email',
            'telephone' => 'required|string|unique:electeurs,telephone',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erreur de validation', 'errors' => $validator->errors()], 400);
        }

        // Création de l'électeur
        $electeur = Electeur::create($request->all());
        return response()->json(['message' => 'Électeur ajouté avec succès', 'electeur' => $electeur], 201);
    }

    /**
     * Récupérer un électeur spécifique
     */
    public function show($id)
    {
        $electeur = Electeur::find($id);
        if (!$electeur) {
            return response()->json(['message' => 'Électeur non trouvé'], 404);
        }
        return response()->json($electeur, 200);
    }

    /**
     * Mettre à jour un électeur
     */
    public function update(Request $request, $id)
    {
        $electeur = Electeur::find($id);
        if (!$electeur) {
            return response()->json(['message' => 'Électeur non trouvé'], 404);
        }

        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'numCarteElecteur' => 'string|unique:electeurs,numCarteElecteur,' . $id,
            'nom' => 'string',
            'prenom' => 'string',
            'dateNaissance' => 'date',
            'email' => 'email|unique:electeurs,email,' . $id,
            'telephone' => 'string|unique:electeurs,telephone,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Erreur de validation', 'errors' => $validator->errors()], 400);
        }

        // Mise à jour de l'électeur
        $electeur->update($request->all());
        return response()->json(['message' => 'Électeur mis à jour', 'electeur' => $electeur], 200);
    }

    /**
     * Supprimer un électeur
     */
    public function destroy($id)
    {
        $electeur = Electeur::find($id);
        if (!$electeur) {
            return response()->json(['message' => 'Électeur non trouvé'], 404);
        }
        $electeur->delete();
        return response()->json(['message' => 'Électeur supprimé'], 200);
    }

    /**
     * Afficher le formulaire d'importation des électeurs
     */
    public function showImportForm()
    {
        return view('electeurs.import');
    }

    /**
     * Gérer l'importation des électeurs depuis un fichier CSV
     */
    public function import(Request $request)
    {
        // ✅ Validation du fichier CSV
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ✅ Ouvrir et lire le fichier
        $file = $request->file('file');
        $handle = fopen($file->getPathname(), "r");
        $header = fgetcsv($handle); // Lire l'en-tête

        if (!$header) {
            return back()->withErrors(['file' => 'Le fichier est vide ou mal formaté.']);
        }

        // ✅ Lire chaque ligne et insérer dans la base de données
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            Electeur::updateOrCreate(
                ['numCarteElecteur' => $data[0]], // Vérifier si l'électeur existe déjà
                [
                    'nom' => $data[1],
                    'prenom' => $data[2],
                    'dateNaissance' => $data[3],
                    'email' => $data[4],
                    'telephone' => $data[5],
                ]
            );
        }
        fclose($handle);

        return redirect()->back()->with('success', 'Liste des électeurs importée avec succès !');
    }
}
