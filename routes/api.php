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
Route::delete('/bieres/{nomBiere}', [App\Http\Controllers\BieresController::class, 'supprimerBieres'])->middleware('auth.basic');

// Ajout Bieres
Route::post('/bieres', [App\Http\Controllers\BieresController::class, 'ajouterBieres'])->middleware('auth.basic');


                // Contenance :

// liste Contenances
Route::get('/contenances', [App\Http\Controllers\ContenancesController::class, 'listeContenances']);

// Ajout Contenances
Route::post('/contenances', [App\Http\Controllers\ContenancesController::class, 'ajouterContenances'])->middleware('auth.basic');

// Suppression Contenances
Route::delete('/contenances/{litres}', [App\Http\Controllers\ContenancesController::class, 'supprimerContenances'])->middleware('auth.basic');


                // Clients :

// liste Client
Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'listeClients']);

//  Client par nom
Route::get('/clients/{idClient}', [App\Http\Controllers\ClientsController::class, 'uniqueClients']);

// Ajout Clients
Route::post('/clients', [App\Http\Controllers\ClientsController::class, 'ajouterClients'])->middleware('auth.basic');

// Suppression Clients
Route::delete('/clients/{idClient}', [App\Http\Controllers\ClientsController::class, 'supprimerClients'])->middleware('auth.basic');

// Livraison Clients
Route::put('/clients/livrer', [App\Http\Controllers\ClientsController::class, 'livrerClients'])->middleware('auth.basic');

// Modifier Client
Route::put('/clients', [App\Http\Controllers\ClientsController::class, 'modifierClients'])->middleware('auth.basic');




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
Route::post('/futs', [App\Http\Controllers\FutsController::class, 'ajouterFuts'])->middleware('auth.basic');

// Suppression fûts
Route::delete('/futs/{idFut}', [App\Http\Controllers\FutsController::class, 'supprimerFuts'])->middleware('auth.basic');

// Remplir fûts
Route::put('/futs/remplir', [App\Http\Controllers\FutsController::class, 'remplirFuts'])->middleware('auth.basic');

// Vider fûts
Route::put('/futs/vider', [App\Http\Controllers\FutsController::class, 'viderFuts'])->middleware('auth.basic');

// Livrer fûts
Route::put('/futs/livrer', [App\Http\Controllers\FutsController::class, 'livrerFuts'])->middleware('auth.basic');

// Reprendre fûts
Route::put('/futs/reprendre', [App\Http\Controllers\FutsController::class, 'reprendreFuts'])->middleware('auth.basic');