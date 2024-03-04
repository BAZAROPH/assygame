<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;

class PaysController extends Controller
{
    public function index()
    {
        $pays = Pays::with('ville')->get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Liste des pays.', $pays);
        return response()->json($response, 200);
    }
}
