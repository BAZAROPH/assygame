<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;

class VilleController extends Controller
{
    public function index()
    {
        $villes = Ville::get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Liste des villes.', $villes);
        return response()->json($response, 200);
    }
}
