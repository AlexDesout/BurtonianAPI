<?php

namespace App\Http\Controllers;

use App\Models\Fut;
use App\Models\Futs;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class FutsController extends Controller
{
    // Liste fûts se trouvant chez un client
    public function listeClients(Request $request)
    {
        // Vérification des paramètres de la requête
        if ($request->has('litres') && $request->has('nomClient')) {
            $futs = Futs::select("*")->where('type', "!=", NULL)->where('nom_client', '=', $request->nomClient)->where("litres", "=", $request->litres)->get();
            $ok = $futs;
        } else {
            $futs = Futs::select("*")->where('type', '!=', NULL)->where('nom_client', '!=', NULL)->get();
            $ok = $futs;
        }
        if ($request->has('litres') && !$request->has('nomClient')) {
            $futs = Futs::select("*")->where('type', "!=", NULL)->where('nom_client', '!=', NULL)->where("litres", "=", $request->litres)->get();
            $ok = $futs;
        }
        if (!$request->has('litres') && $request->has('nomClient')) {
            $futs = Futs::select("*")->where('type', "!=", NULL)->where('nom_client', '=', $request->nomClient)->get();
            $ok = $futs;
        }

        // Affichage du résultat
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Liste futs pleins ne se trouvant pas chez un client
    public function listeFutsPleins(Request $request)
    {
        // Vérification des paramètres de la requête
        if ($request->has('litres') && $request->has('type')) {
            $futs = Futs::select("*")->where('type', "!=", NULL)->where('nom_client', '=', NULL)->where("litres", "=", $request->litres)->where("type", "=", $request->type)->get();
            $ok = $futs;
        } else {
            $futs = Futs::select("*")->where('type', '!=', NULL)->where('nom_client', '=', NULL)->get();
            $ok = $futs;
        }
        if ($request->has('litres') && !$request->has('type')) {
            $futs = Futs::select("*")->where('type', "!=", NULL)->where('nom_client', '=', NULL)->where("litres", "=", $request->litres)->get();
            $ok = $futs;
        }
        if (!$request->has('litres') && $request->has('type')) {
            $futs = Futs::select("*")->where('type', "!=", NULL)->where('nom_client', '=', NULL)->where("type", "=", $request->type)->get();
            $ok = $futs;
        }

        // Affichage du résultat
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }
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

        // Affichage du résultat
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Un fut spécifique
    public function uniqueFut($idFut)
    {
        // Requête SQL
        $fut = Futs::select("*")->where('id_fut', "=", $idFut)->get();
        $ok = $fut;

        // Affichage du résultat
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
        // var_dump($maxId);

        // Validation des données rentrées dans la requête
        $validator = Validator::make($request->all(), [
            'litres' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Ajout dans la BDD
        $fut = new Futs();
        $fut->id_fut = ($maxId + 1);
        $fut->litres = $request->litres;
        $ok = $fut->save();

        // Affichage du résultat
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Fût ajouté", "data" => $fut], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"], 400);
        }
    }

    // Supprimer un fut
    public function supprimerFuts($idFut)
    {
        // Suppression
        $fut = Futs::select('*')->where('id_fut', '=', $idFut);
        $ok = $fut->delete();

        // Affichage du résultat
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Supprimé"], 200);
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la supression"], 400);
        }
    }

    // Remplir un fût
    public function remplirFuts(Request $request)
    {

        // Vérification de la requête
        $validator = Validator::make($request->all(), [
            'id_fut' => ['required', 'numeric'],
            'type' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Modification dans la BDD
        if ($fut = Futs::where("id_fut", "=", $request->id_fut)->where("type", "=", NULL)->first()) {
            $fut->type = $request->type;
            $ok = $fut->save();
            return response()->json($fut);
            if ($ok) {
                return response()->json(["status" => 1, "message" => "Fût modifié", "data" => $fut], 201);
            } else {
                return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
            }
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
        }
    }

    // Remplir un fût
    public function viderFuts(Request $request)
    {
        // Vérification de la requête
        $validator = Validator::make($request->all(), [
            'id_fut' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Modification dans la BDD
        if ($fut = Futs::where("id_fut", "=", $request->id_fut)->where("type", "!=", NULL)->first()) {
            $fut->type = NULL;
            $ok = $fut->save();
            return response()->json($fut);
            if ($ok) {
                return response()->json(["status" => 1, "message" => "Fût modifié", "data" => $fut], 201);
            } else {
                return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
            }
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
        }
    }

    // Livrer un fût
    public function livrerFuts(Request $request)
    {
        $date_actuelle = \Carbon\Carbon::now()->toDateTimeString();
        // Vérification de la requête
        $validator = Validator::make($request->all(), [
            'id_fut' => ['required', 'numeric'],
            'nom_client' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Modification dans la BDD
        if ($fut = Futs::where("id_fut", "=", $request->id_fut)->where("nom_client", "=", NULL)->where("type", "!=", NULL)->first()) {
            $fut->nom_client = $request->nom_client;
            $fut->date_livraison = $date_actuelle;
            $ok = $fut->save();
            return response()->json($fut);
            if ($ok) {
                return response()->json(["status" => 1, "message" => "Fût modifié", "data" => $fut], 201);
            } else {
                return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
            }
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
        }
    }

    // Reprendre un fût
    public function reprendreFuts(Request $request)
    {
        // Vérification de la requête
        $validator = Validator::make($request->all(), [
            'id_fut' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Modification dans la BDD
        if ($fut = Futs::where("id_fut", "=", $request->id_fut)->where("nom_client", "!=", NULL)->first()) {
            $fut->nom_client = NULL;
            $fut->type = NULL;
            $fut->date_livraison = NULL;
            $ok = $fut->save();
            return response()->json($fut);
            if ($ok) {
                return response()->json(["status" => 1, "message" => "Fût modifié", "data" => $fut], 201);
            } else {
                return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
            }
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
        }
    }
}
