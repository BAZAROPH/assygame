<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Produit_like;
use App\Models\Tarif;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::with('tarifs','options','categorie', 'media')->leftJoin('produit_likes', function($join) {
            $join->on('produits.id', '=', 'produit_likes.produit_id');
          })->selectRaw("produits.*")->orderByRaw("produits.like DESC")->get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici vos produits.', $produits);
        return response()->json($response, 200);
    }

    public function fourindex(Request $request)
    {
        $produits = Produit::with('tarifs','options','categorie', 'media')->where('fournisseur_id',$request->user()->id)->get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici vos produits.', $produits);
        return response()->json($response, 200);
    }

      public function authindex(Request $request)
      {
          $produits = Produit::with('tarifs','options','categorie', 'media')->leftJoin('produit_likes', function($join) {
            $join->on('produits.id', '=', 'produit_likes.produit_id');
          })->selectRaw("produits.*, produit_likes.user_id")->where('produit_likes.user_id', $request->user()->id)->orWhereNull('produit_likes.user_id')->orderByRaw("produits.like DESC")->get();
  
          $response = APIHelpers::createAPIResponse(false, 0, 'Voici vos produits.', $produits);
          return response()->json($response, 200);
      }

      public function hebdo(Request $request)
      {
        //->orWhereIn('produit_likes.user_id')
          $produits = Produit::with('tarifs','options','categorie', 'media')->where('accueil', 1)->get();

          $response = APIHelpers::createAPIResponse(false, 0, 'Voici vos produits.', $produits);
          return response()->json($response, 200);
      }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'titre' => 'required',
            'description' => 'required',
        ]);
        
            $count = Produit::all()->count() + 1;
            $produit = new Produit();
            $produit->code = "PRO-000".$count;
            $produit->titre = $request->titre;
            $produit->description = $request->description;
            $produit->categorie_id = $request->categorie_id;
            $produit->fournisseur_id = $request->user()->id;
            $produit_save = $produit->save();

            foreach ($request->tarifs as $k => $v) {
                $tarif = new Tarif();
                $tarif->quantite = $v["quantite"];
                $tarif->montant = $v["montant"];
                $tarif->produit_id = $produit->id;
                $tarif_save = $tarif->save();
            }

        if($request->option == true)
            foreach ($request->options as $k => $v) {
                $option_taille = Option::where([['titre','=', explode('|', $v["titre"])[0]],['produit_id','=', $produit->id]])->first();
                
                if ($option_taille == null) {
                    $option = new Option();
                    $option->titre = explode('|', $v["titre"])[0];
                    $option->description = $v["description"];
                    $option->produit_id = $produit->id;
                    $option_save = $option->save();

                    $optionc = new Option();
                    $optionc->titre = explode('|', $v["titre"])[1];
                    $optionc->description = $v["description"];
                    $optionc->produit_id = $produit->id;
                    $optionc->option_id = $option->id;
                    $optionc_save = $optionc->save();
                }else {
                    $option = new Option();
                    $option->titre = explode('|', $v["titre"])[1];
                    $option->description = $v["description"];
                    $option->produit_id = $produit->id;
                    $option->option_id = $option_taille->id;
                    $option_save = $option->save();
                }
            }


            if ($produit_save) {
                $response = APIHelpers::createAPIResponse(false, 0, 'Votre inscription a bien été effectuée.', $produit->id);
                return response()->json($response, 200);
            }else{
                $response = APIHelpers::createAPIResponse(true, 1, 'Votre inscription a echouée.', null);
                return response()->json($response, 200);
            }
    }

    public function updateproduit(Request $request)
    {

        $request->validate([
            'titre' => 'required',
            'description' => 'required',
        ]);
            $produit = Produit::find($request->id);
            $produit->titre = $request->titre;
            $produit->sous_titre = $request->sous_titre;
            $produit->description = $request->description;
            $produit->categorie_id = $request->categorie_id;
            $produit_save = $produit->save();

            
            foreach ($request->tarifs as $k => $v) {
                if($v["id"] == null){
                    $tarif = new Tarif();
                    $tarif->quantite = $v["quantite"];
                    $tarif->montant = $v["montant"];
                    $tarif->produit_id = $produit->id;
                    $tarif_save = $tarif->save();
                }
            }

            if($request->option == true)
                foreach ($request->options as $k => $v) {
                    if ($v["id"] == null) {
                        $option_taille = Option::where([['titre','=', explode('|', $v["titre"])[0]],['produit_id','=', $produit->id]])->first();
                        
                        if ($option_taille == null) {
                            $option = new Option();
                            $option->titre = explode('|', $v["titre"])[0];
                            $option->description = $v["description"];
                            $option->produit_id = $produit->id;
                            $option_save = $option->save();

                            $optionc = new Option();
                            $optionc->titre = explode('|', $v["titre"])[1];
                            $optionc->description = $v["description"];
                            $optionc->produit_id = $produit->id;
                            $optionc->option_id = $option->id;
                            $optionc_save = $optionc->save();
                        }else {
                            $option = new Option();
                            $option->titre = explode('|', $v["titre"])[1];
                            $option->description = $v["description"];
                            $option->produit_id = $produit->id;
                            $option->option_id = $option_taille->id;
                            $option_save = $option->save();
                        }
                    }
                }


            if ($produit_save) {
                $response = APIHelpers::createAPIResponse(false, 0, 'Votre inscription a bien été effectuée.', $produit->id);
                return response()->json($response, 200);
            }else{
                $response = APIHelpers::createAPIResponse(true, 1, 'Votre inscription a echouée.', null);
                return response()->json($response, 200);
            }
    }

    public function addtarif(Request $request)
    {
        
        $tarif = Tarif::find($request->id);
        $tarif->quantite = $request->quantite;
        $tarif->montant = $request->montant;
        $tarif_save = $tarif->save();

            if ($tarif_save) {
                $response = APIHelpers::createAPIResponse(false, 0, 'Votre inscription a bien été effectuée.', null);
                return response()->json($response, 200);
            }else{
                $response = APIHelpers::createAPIResponse(true, 1, 'Votre inscription a echouée.', null);
                return response()->json($response, 200);
            }
    }

    public function addoption(Request $request)
    {
        $option = Option();
        $option->titre = $request->titre;
        $option->description = $request->description;
        $option_save = $option->save();

            if ($option_save) {
                $response = APIHelpers::createAPIResponse(false, 0, 'Votre inscription a bien été effectuée.', null);
                return response()->json($response, 200);
            }else{
                $response = APIHelpers::createAPIResponse(true, 1, 'Votre inscription a echouée.', null);
                return response()->json($response, 200);
            }
    }

    public function deletetarif(Request $request)
    {
        $tarif = Tarif::find($request->id);
        $tarif_delete = $tarif->delete();

            
        $response = APIHelpers::createAPIResponse(false, 0, 'Votre tarif a bien été supprimé.', null);
        return response()->json($response, 200);
    }

    public function deleteoption(Request $request)
    {
        $option = Option::find($request->id);
        $option_delete = $option->delete();

        $response = APIHelpers::createAPIResponse(false, 0, 'Votre option a bien été supprimée.', null);
        return response()->json($response, 200);
            
    }

    public function show($id)
    {
        $produit = Produit::with('tarifs','options', 'media')->where('produits.id', $id)->first();

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici vos produits.', $produit);
        return response()->json($response, 200);
    }

    public function deletemedia(Request $request)
    {
        $media = Media::find($request->id);

        $media->delete();

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici votre photo produit.', null);
        return response()->json($response, 200);
    }

    public function likeindex(Request $request)
    {

        $produits = Produit::with('tarifs','options', 'media')->join('produit_likes', function($join) {
            $join->on('produits.id', '=', 'produit_likes.produit_id');
          })->where('produit_likes.user_id', $request->user()->id)->get();

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici vos produits.', $produits);
        return response()->json($response, 200);
    }

    public function islike(Request $request)
    {
        $request->validate([
            'produit_id' => 'required',
        ]);

        $produit_like = new Produit_like();
        $produit_like->produit_id = $request->produit_id;
        $produit_like->user_id = $request->user()->id;

        $produit = Produit::find($request->produit_id);
        $count = $produit->like;
        $produit->like = $count + 1;

        $produit->save();
        $produit_like_save = $produit_like->save();

        if ($produit_like_save) {
            $response = APIHelpers::createAPIResponse(false, 0, 'Votre produit like a bien été effectuée.', $produit_like->id);
            return response()->json($response, 200);
        }else{
            $response = APIHelpers::createAPIResponse(true, 1, 'Votre produit like a echouée.', null);
            return response()->json($response, 200);
        }
    }

    public function isnotlike(Request $request)
    {
        $produit_like = Produit_like::where("user_id", $request->user()->id)->where("produit_id", $request->produit_id)->first();


        $produit = Produit::find($request->produit_id);
        $count = $produit->like;
        $produit->like = $count - 1;

        $produit->save();
        $produit_like_delete = $produit_like->delete();

        if ($produit_like_delete) {
            $response = APIHelpers::createAPIResponse(false, 0, 'Votre produit like a bien été effectuée.', null);
            return response()->json($response, 200);
        }else{
            $response = APIHelpers::createAPIResponse(true, 1, 'Votre produit like a echouée.', null);
            return response()->json($response, 200);
        }
    }

    public function image(Request $request)
    {
        $produit = Produit::find($request->id);

        $produit->addMedia($request->photo)->toMediaCollection('default');

        $response = APIHelpers::createAPIResponse(false, 0, 'Voici votre photo produit.', null);
        return response()->json($response, 200);
    }

    public function delete(Request $request)
    {
        $produit = Produit::find($request->id);

        $tarifs = Tarif::where("produit_id", $request->id)->get();
        $options = Option::where("produit_id", $request->id)->get();
        $medias = Media::where("model_type", "App\Models\Produit")->where("model_id", $request->id)->get();

        foreach ($tarifs as $k => $v) {
            $tarif = Tarif::find($v["id"]);
            $tarif_delete = $tarif->delete();
        }

        foreach ($options as $k => $v) {
            $option = Option::find($v["id"]);
            $option_delete = $option->delete();
        }

        foreach ($medias as $k => $v) {
            $media = Media::find($v["id"]);
            $media_save = $media->delete();
        }

        $produit_delete = $produit->delete();

        
        $response = APIHelpers::createAPIResponse(false, 0, 'Votre produit a bien été supprimé.', null);
        return response()->json($response, 200);
        
    }
}
