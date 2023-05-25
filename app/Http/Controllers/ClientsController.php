<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    // Liste des clients
    public function listeClients()
    {
        // Requête à la BDD
        $clients = Clients::get();
        $ok = $clients;

        // Affichage du résultat de la requête
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Un client spécifique
    public function uniqueClients($idClient)
    {
        // Requête à la BDD
        $clients = Clients::select('*')->where('id_client', '=', $idClient)->get();
        $ok = $clients;

        // Affichage du résultat
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    //  Ajouter un client 
    public function ajouterClients(Request $request)
    {
        // Validation des données rentrées dans la requête
        $validator = Validator::make($request->all(), [
            'nom_client' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'numero' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Ajout dans la BDD
        $maxId = Clients::max("id_client");
        $client = new Clients();
        $client->id_client = ($maxId +1);
        $client->nom_client = $request->nom_client;
        $client->adresse = $request->adresse;
        $client->numero = $request->numero;
        $ok = $client->save();

        // Affichage du résultat 
        if ($ok) {
            return response()->json(["status" => 1, "message" => "client ajouté", "data" => $client], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"], 400);
        }
    }

    // Supprimer un client
    public function supprimerClients($idClient)
    {
        // Suppression d'un élement à partir de l'id
        $client = Clients::select('*')->where('id_client', '=', $idClient);
        $ok = $client->delete();

        // Affichage du résultat
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Supprimé"], 200);
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la supression"], 400);
        }
    }

    //  Livrer un client 
    public function livrerClients(Request $request)
    {
        // Récupération de la date actuelle
        $date_actuelle = \Carbon\Carbon::now()->toDateTimeString();
        
        // Modification du client dans la BDD
        if ($client = Clients::where("id_client", "=", $request -> id_client)->first()) {
            $client -> date_livraison = $date_actuelle;
            $ok = $client->save();
            return response()->json($client);

            // Affichage du résultat
            if ($ok) {
                return response()->json(["status" => 1, "message" => "client modifié", "data" => $client], 201);
            } else {
                return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
            }
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la modification"], 400);
        }
    }
}
