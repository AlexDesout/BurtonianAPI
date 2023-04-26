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
        $bieres = Bieres::get();
        $ok = $bieres;

        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Supprimer une bière
    public function supprimerBieres($nomBiere)
    {
        $biere = Bieres::select('*')->where('type', '=', $nomBiere);
        $ok = $biere->delete();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Supprimé", "data" => $biere], 200);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de
            supression"], 400);
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

        $biere = new Bieres();
        $biere->type = $request->type;
        $ok = $biere->save();

        if ($ok) {
            return response()->json(["status" => 1, "message" => "Bière ajoutée", "data" => $biere], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"], 400);
        }
    }
}
