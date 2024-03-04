<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Commande_produit;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;

use Illuminate\Support\Facades\Mail;
use App\Mail\MessageCommande;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->type == 'client'){

            $commandes = Commande::where('client_id',$request->user()->id)->get();
            
            foreach ($commandes as $ck => $cv) {
                $cv->produits = Produit::with('media')->join('commande_produits', function($join) {
                    $join->on('commande_produits.produit_id', '=', 'produits.id');
                })->leftJoin('options', function($join) {
                    $join->on('commande_produits.option_id', '=', 'options.id');
                })->leftJoin('options as colors', function($join) {
                    $join->on('colors.option_id', '=', 'options.id');
                })->SelectRaw("produits.*, commande_produits.quantite, commande_produits.montant, options.titre as 'option', colors.titre as optioncolor")->where("commande_produits.commande_id", $cv->id)->get();
            }
        }else{
            $commandes = Commande::all();
        
            foreach ($commandes as $ck => $cv) {
                $cv->produits = Produit::with('media')->join('commande_produits', function($join) {
                    $join->on('commande_produits.produit_id', '=', 'produits.id');
                })->leftJoin('options', function($join) {
                    $join->on('commande_produits.option_id', '=', 'options.id');
                })->leftJoin('options as colors', function($join) {
                    $join->on('colors.option_id', '=', 'options.id');
                })->SelectRaw("produits.*, commande_produits.quantite, commande_produits.montant, options.titre as 'option', colors.titre as optioncolor")->where([["commande_produits.commande_id","=", $cv->id],["produits.fournisseur_id","=", $request->user()->id]])->get();
            }
           
        }

        $response = APIHelpers::createAPIResponse(false, 0, 'Liste des commandes.', $commandes);
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
        $count = Commande::all()->count() + 1;
        $commande = new Commande();
        $commande->titre = "COMMANDE du ".date("d/m/Y")." à ".date("h")."H";
        $commande->montant = $request->montant;
        $commande->livraison = $request->livraison;
        $commande->total = $request->total;
        $commande->statut = $request->statut;
        $commande->code = "COM0000". $count;
        $commande->client_id = $request->user()->id;
        
        $commande_save = $commande->save();

        foreach ($request->produits as $k => $v) {
            $commande_produit = new Commande_produit();
            
            $commande_produit->commande_id = $commande->id;
            $commande_produit->produit_id = $v["produit_id"];
            $commande_produit->option_id = $v["option_id"];
            $commande_produit->quantite = $v["quantite"];
            $commande_produit->montant = $v["montant"];
            $commande_produit->save();
        }

        if ($commande_save) {
		    $user = $request->user()->email;

            Mail::to("service-client@assygame.com")->bcc($user)
                            ->queue(new MessageCommande($request->all()));

            $response = APIHelpers::createAPIResponse(false, 0, 'Commande effectuée', null);
            return response()->json($response, 200);
        } else {
            $response = APIHelpers::createAPIResponse(true, 1, 'Impossible d\'enregistrer votre commande', null);
            return response()->json($response, 200);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
