<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcour;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;

class ParcourController extends Controller
{
    public function index()
    {
        $parcours = Pays::with('ville')->get();

        $response = APIHelpers::createAPIResponse(false, 1, 'Liste des parcours.', $parcours);
        return response()->json($response, 200);
    }
}
