<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::orderBy('id', 'desc')
        ->with([
            'categorie',
            'mesure',
            'fournisseur',
            'tarifs',
            'options',
            'couleurs',
            'tailles',
            'produit_likes',
            'commandes',
        ])
        ->get();

        $trashed = Produit::onlyTrashed()
        ->get();
        //dd($produits->toArray());

        return view('produit.index')->with([
            'trashed' => $trashed,
            'valeurs' => $produits,
            'infosPage' => array(
                'title' => 'Produits',
                'icon' => 'icofont-shopping-cart',
                'add' => 0,
            ),
        ]);
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
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //dd($produit->id);
        $produit = Produit::where('id', $produit->id)
        ->with([
            'categorie' => function($q){
                $q->with([
                    'categorie' => function($q){
                        $q->with('categorie');
                    }]
                );
            },
            'mesure',
            'fournisseur',
            'tarifs',
            'couleurs',
            'tailles',
            'options',
            'produit_likes',
            'commandes',
        ])
        ->firstOrFail();
        //dd($produit->toArray());

        return view('produit.show')->with([
            'valeur' => $produit,
            'infosPage' => array(
                'title' => 'Produits',
                'icon' => 'icofont-shopping-cart',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function validation(Produit $produit, $status)
    {
        //dd($produit->toArray());
        if ($status == 1) {
            $produit->status = 1;
            $produit->save();
            //dd($produit->toArray());
            flash()->overlay('Le produit "'.$produit->titre.'" a bien été validé ', 'Validation')->success();
            return back();
        }
        elseif ($status == 0) {
            $produit->status = null;
            $produit->save();
            flash()->overlay('Vous avez annulé la validation du produit "'.$produit->titre.'"', 'Validation')->warning();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function hebdo(Produit $produit, $status)
    {
        //dd($produit->toArray());
        if ($status == 1) {
            $produit->hebdo = 1;
            $produit->save();
            //dd($produit->toArray());
            flash()->overlay('Le produit "'.$produit->titre.'" a été mis en hebdo ', 'Hebdomadaire')->success();
            return back();
        }
        elseif (empty($status)) {
            $produit->hebdo = null;
            $produit->save();
            flash()->overlay('Vous avez supprimé "'.$produit->titre.'" des produits hebdomadaire', 'Hebdomadaire')->warning();
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        $categories = Categorie::orderBy('id', 'desc')
        ->with([
            'categorie',
            'categories',
            'produits'
        ])
        ->where([
            'categorie_id' => null,
        ])
        ->get();
        $produit = Produit::with([
            'categorie' => function($q){
                $q->with([
                    'categorie' => function($q){
                        $q->with('categorie');
                    }]
                );
            },
            'mesure',
            'fournisseur',
            'tarifs',
            'options',
            'produit_likes',
            'commandes',
        ])
        ->findOrFail($produit->id);
        //dd($categories->toArray());
        return view('produit.create')->with([
            'valeurs' => $categories,
            'valeur' => $produit,
            'infosPage' => array(
                'title' => 'Modifier produit : '.$produit->titre,
                'icon' => 'icofont-shopping-cart',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        $this->validate($request,[
            'titre' => 'required|max:255',
        ]);
        $produit = Produit::findOrFail($produit->id);
        //dd($categorie->toArray());
        $produit->titre = request('titre');
        $produit->sous_titre = request('sous_titre');
        $produit->description = request('description');
        $produit->categorie_id = request('categorie_id');
        $produit->save();

        if($request->hasFile('image'))
        {
            $produit->addMediaFromRequest('image')
            ->toMediaCollection('image');
        }

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        $produit = Produit::findOrFail($produit->id);
        $produit->delete();
        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }
}
