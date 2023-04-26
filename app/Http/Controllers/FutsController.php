<?php

namespace App\Http\Controllers;

use App\Models\Fut;
use App\Models\Futs;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class FutsController extends Controller
{
    // Liste futs vides
    public function listeFutsVides(Request $request)
    {
        if ($request->has('litres')) {
            $futs = Futs::select("*")->where('type', "=", NULL)->where("litres", "=", $request->litres)->get();
            $ok = $futs;
            // var_dump($request->litres);
        } else {
            $futs = Futs::select("*")->where('type', '=', NULL)->get();
            $ok = $futs;
        }

        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Un fut spécifique
    public function uniqueFut($idFut)
    {
        $fut = Futs::select("*")->where('id_fut', "=", $idFut)->get();
        $ok = $fut;
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    //  Ajouter un fût 
    public function ajouterFuts(Request $request)
    {
        // Recherche du plus grand id dans la BDD
        $maxId = Futs::max("id_fut");
        var_dump($maxId);

        // Validation des données rentrées dans la requête
        $validator = Validator::make($request->all(), [
            'litres' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $fut = new Futs();
        $fut->id_fut = ($maxId+1);
        $fut->litres = $request->litres;
        $ok = $fut->save();

        if ($ok) {
            return response()->json(["status" => 1, "message" => "Fût ajouté", "data" => $fut], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"], 400);
        }
    }

    public function supprimerFuts($idFut)
    {
        $fut = Futs::select('*')->where('id_fut', '=', $idFut);
        $ok = $fut->delete();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Supprimé"], 200);
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la supression"], 400);
        }
    }
}
