<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FutsController;
use App\Http\Controllers\BieresController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContenancesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

                // Bières :

// Liste des Bières
Route::get('/bieres', [App\Http\Controllers\BieresController::class, 'listeBieres']);

// Suppression Bieres
Route::delete('/bieres/{nomBiere}', [App\Http\Controllers\BieresController::class, 'supprimerBieres']);

// Ajout Bieres
Route::post('/bieres', [App\Http\Controllers\BieresController::class, 'ajouterBieres']);


                // Contenance :

// liste Contenances
Route::get('/contenances', [App\Http\Controllers\ContenancesController::class, 'listeContenances']);

// Ajout Contenances
Route::post('/contenances', [App\Http\Controllers\ContenancesController::class, 'ajouterContenances']);

// Suppression Contenances
Route::delete('/contenances/{litres}', [App\Http\Controllers\ContenancesController::class, 'supprimerContenances']);


                // Clients :

// liste Client
Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'listeClients']);

//  Client par nom
Route::get('/clients/{nomClient}', [App\Http\Controllers\ClientsController::class, 'uniqueClients']);

// Ajout Clients
Route::post('/clients', [App\Http\Controllers\ClientsController::class, 'ajouterClients']);

// Suppression Clients
Route::delete('/clients/{nomClient}', [App\Http\Controllers\ClientsController::class, 'supprimerClients']);

// livraison Clients
Route::put('/clients', [App\Http\Controllers\ClientsController::class, 'livrerClients']);


                // Fûts :

// Liste fûts  se trouvant chez un client
Route::get('/futs/livrer', [App\Http\Controllers\FutsController::class, 'listeClients']);

// Liste fûts pleins ne se trouvant pas chez un client
Route::get('/futs/pleins', [App\Http\Controllers\FutsController::class, 'listeFutsPleins']);

// Liste fûts vides
Route::get('/futs/vides', [App\Http\Controllers\FutsController::class, 'listeFutsVides']);

// Un fût spécifique
Route::get('/futs/{idFut}', [App\Http\Controllers\FutsController::class, 'uniqueFut']);

// Ajout fûts
Route::post('/futs', [App\Http\Controllers\FutsController::class, 'ajouterFuts']);

// Suppression fûts
Route::delete('/futs/{idFut}', [App\Http\Controllers\FutsController::class, 'supprimerFuts']);