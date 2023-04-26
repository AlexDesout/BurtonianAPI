<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FutsController;
use App\Http\Controllers\BieresController;
use App\Http\Controllers\ClientController;
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


// Liste des Bières
Route::get('/bieres', [App\Http\Controllers\BieresController::class, 'listeBieres']);

// Suppression Bieres
Route::delete('/bieres/{nomBiere}', [App\Http\Controllers\BieresController::class, 'supprimerBieres']);

// Ajout Bieres
Route::post('/bieres', [App\Http\Controllers\BieresController::class, 'ajouterBieres']);
