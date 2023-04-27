<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bieres;
use Illuminate\Support\Facades\Validator;

class BieresController extends Controller
{
    // Liste des bières
    public function listeBieres()
    {
        // Requête à la BDD
        $bieres = Bieres::get();
        $ok = $bieres;

        // Affichage du résultat
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Supprimer une bière
    public function supprimerBieres($nomBiere)
    {
        // Suppression dans la BDD
        $biere = Bieres::select('*')->where('type', '=', $nomBiere);
        $ok = $biere->delete();

        // Affichage du résultat
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Supprimé", "data" => $biere], 200);
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la supression"], 400);
        }
    }

    // Ajouter une bière
    public function ajouterBieres(Request $request)
    {
        // Validation des données rentrées dans la requête
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', 'unique:bieres,type']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Ajout dans la BDD
        $biere = new Bieres();
        $biere->type = $request->type;
        $ok = $biere->save();

        // Affichage du résultat
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Bière ajoutée", "data" => $biere], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"], 400);
        }
    }
}
