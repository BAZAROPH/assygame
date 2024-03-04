<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::with('categories', 'media')->whereNull("categories.categorie_id")->get();

        foreach ($categories as $ck => $cv) {
            foreach ($cv->categories as $ck1 => $cv1) {
                $cv1->produits = Produit::with('tarifs','options', 'media')->leftJoin('produit_likes', function($join) {
                    $join->on('produits.id', '=', 'produit_likes.produit_id');
                  })->selectRaw("produits.*, produit_likes.user_id")->where('categorie_id',$cv1->id )->get();
            }
        }

        $response = APIHelpers::createAPIResponse(false, 0, 'Liste des categories.', $categories);
        return response()->json($response, 200);
    }

    
    public function categorie()
    {
        $categories = Categorie::with('categories')->whereNull("categories.categorie_id")->get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Liste des categories.', $categories);
        return response()->json($response, 200);
    }

    
    public function scategorie($id)
    {
        $categories = Categorie::with('categories')->where("categories.categorie_id", $id)->get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Liste des categories.', $categories);
        return response()->json($response, 200);
    }

    
    public function show($id)
    {
        $categories = Categorie::where("categories.categorie_id", $id)->get();

            foreach ($categories as $ck1 => $cv1) {
                $cv1->produits = Produit::with('tarifs','options', 'media')->leftJoin('produit_likes', function($join) {
                    $join->on('produits.id', '=', 'produit_likes.produit_id');
                  })->selectRaw("produits.*, produit_likes.user_id")->where('categorie_id',$cv1->id )->get();
            }

        $response = APIHelpers::createAPIResponse(false, 0, 'Liste des categories.', $categories);
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        //
    }
}
