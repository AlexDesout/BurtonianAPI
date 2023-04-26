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
        $clients = Clients::get();
        $ok = $clients;

        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }

    // Un client spécifique clients
    public function uniqueClients($nomClient)
    {
        $clients = Clients::select('*')->where('nom_client', '=', $nomClient)->get();
        $ok = $clients;

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
            'nom_client' => ['required', 'string', 'unique:clients,nom_client'],
            'adresse' => ['required', 'string'],
            'numero' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $client = new Clients();
        $client->nom_client = $request->nom_client;
        $client->adresse = $request->adresse;
        $client->numero = $request->numero;
        $ok = $client->save();

        if ($ok) {
            return response()->json(["status" => 1, "message" => "client ajoutée", "data" => $client], 201);
        } else {
            return response()->json(["status" => 0, "message" => "pb lors de l'ajout"], 400);
        }
    }

    // Supprimer un client
    public function supprimerClients($nomClient)
    {
        $client = Clients::select('*')->where('nom_client', '=', $nomClient);
        $ok = $client->delete();
        if ($ok) {
            return response()->json(["status" => 1, "message" => "Supprimé"], 200);
        } else {
            return response()->json(["status" => 0, "message" => "Problème lors de la supression"], 400);
        }
    }

    //  Livrer un client 
    public function livrerClients(Request $request)
    {
        $date_actuelle = \Carbon\Carbon::now()->toDateTimeString();
        // var_dump($request -> nom_client);
        if ($client = Clients::where("nom_client", "=", $request -> nom_client)->first()) {
            $client -> date_livraison = $date_actuelle;
            $ok = $client->save();
            return response()->json($client);
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
