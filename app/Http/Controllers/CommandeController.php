<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = Commande::orderBy('id', 'desc')
        ->with([
            'client',
            'commande_produits',
        ])
        ->whereNotIn('statut', [
            'cours'
        ])
        ->get();
        $trashed = Commande::onlyTrashed()
        ->get();

        //total_date_commandes('2021-03-22');

        //dd($categories->toArray());
        return view('commande.index')->with([
            'trashed' => $trashed,
            'valeurs' => $commandes,
            'infosPage' => array(
                'title' => 'Commandes',
                'icon' => 'icofont-truck-alt',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rapport()
    {
        $commandes = Commande::orderBy('id', 'desc')
        ->with([
            'client',
            'commande_produits',
        ])
        ->get();
        return view('commande.rapport')->with([
            'valeurs' => $commandes,
            'infosPage' => array(
                'title' => 'Rapport de commandes',
                'icon' => 'icofont-truck-alt',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statut_commande(Request $request, Commande $commande)
    {
        $this->validate($request,[
            'statut' => 'required|max:255',
        ]);
        $commande->statut = request('statut');
        $commande->save();

        flash()->overlay('L"état de la commande a bien été changé', 'Message')->success();
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //dd($produit->id);
        $commande = Commande::where('id', $commande->id)
        ->with([
            'client',
            'commande_produits',
            'produits' => function($q){
                $q->with('categorie');
            },
        ])
        ->firstOrFail();
        //dd($commande->toArray());

        return view('commande.show')->with([
            'valeur' => $commande,
            'infosPage' => array(
                'title' => 'Commande N°'.$commande->code,
                'icon' => 'icofont-truck-alt',
                'add' => 0,
            ),
        ]);
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
