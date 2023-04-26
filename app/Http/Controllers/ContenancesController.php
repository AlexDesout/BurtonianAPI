<?php

namespace App\Http\Controllers;

use App\Models\Contenances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContenancesController extends Controller

{
    // Liste des contenances
    public function listeContenances()
    {
        $contenance = Contenances::get();
        $ok = $contenance;

        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Ajouter une contenance
    public function ajouterContenances(Request $request)
    {
        // Validation des données rentrées dans la requête
        $validator = Validator::make($request->all(), [
            'litres' => ['required', 'numeric', 'unique:contenances,litres']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $contenance = new Contenances();
        $contenance->litres = $request->litres;
        $ok = $contenance->save();

        if ($ok) {
            return response()->json(["status" => 1, "message" => "Contenance ajoutée", "data" => $contenance], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"], 400);
        }
    }

    // Supprimer une contenance
    public function supprimerContenances($litres){
        $contenance = Contenances::select('*')->where('litres', '=', $litres);
        $ok = $contenance->delete();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Supprimé"], 200);
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la supression"], 400);
        }
    }
        
}
