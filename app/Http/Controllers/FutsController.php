<?php

namespace App\Http\Controllers;
use App\Models\Fut;
use App\Models\Futs;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class FutsController extends Controller
{
    public function uniqueFut($idFut){
        $fut = Futs::select("*")->where('id_fut', "=", $idFut)->get();
        $ok = $fut;
        if ($ok) {
            return response()->json($ok);
        } else {
            return response()->json(["status" => 0, "message" => "Pas trouvé"], 400);
        }
    }
}
