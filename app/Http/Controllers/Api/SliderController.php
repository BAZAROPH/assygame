<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::with('media')->get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Votre profil a bien été modifié.', $sliders);
        return response()->json($response, 200);
    }
}
