<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::orderBy('id', 'desc')
        ->with([
            'categorie',
            'categories' => function($q){
                $q->with([
                    'categories' => function($q){
                        $q->with('categories');
                    }]
                );
            },
            'produits'
        ])
        ->where([
            'categorie_id' => null,
        ])
        ->get();

        $trashed = Categorie::onlyTrashed()
        ->get();
        //dd($categories->toArray());

        return view('categorie.index')->with([
            'trashed' => $trashed,
            'valeurs' => $categories,
            'infosPage' => array(
                'title' => 'Categories',
                'icon' => 'icofont-ui-folder',
                'add' => 1,
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

        //dd($categories->toArray());

        return view('categorie.create')->with([
            'valeurs' => $categories,
            'infosPage' => array(
                'title' => 'Ajout de catégorie',
                'icon' => 'icofont-ui-folder',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'titre' => 'required|max:255',
        ]);

        //$code = IdGenerator::generate(['table' => 'categories', 'length' => 10, 'prefix' =>date('s')]);
        $categorie = Categorie::create([
            'titre' => request('titre'),
            'sous_titre' => request('sous_titre'),
            'description' => request('description'),
            'categorie_id' => request('categorie_id'),
        ]);

        if($request->hasFile('image'))
        {
            $categorie->addMediaFromRequest('image')
            ->toMediaCollection('image');
        }
        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
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
        $categorie = Categorie::findOrFail($categorie->id);
        //dd($categories->toArray());
        return view('categorie.create')->with([
            'valeurs' => $categories,
            'valeur' => $categorie,
            'infosPage' => array(
                'title' => 'Modifier catégorie : '.$categorie->titre,
                'icon' => 'icofont-ui-folder',
                'add' => 0,
            ),
        ]);
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
        $this->validate($request,[
            'titre' => 'required|max:255',
        ]);
        $categorie = Categorie::findOrFail($categorie->id);
        //dd($categorie->toArray());
        $categorie->titre = request('titre');
        $categorie->sous_titre = request('sous_titre');
        $categorie->description = request('description');
        $categorie->categorie_id = request('categorie_id');
        $categorie->save();

        if($request->hasFile('image'))
        {
            $media = $categorie->getMedia('image');
            //dd($media->toArray());
            if (count($media)) {
                $media[0]->delete();
            }
            $categorie->addMediaFromRequest('image')
            ->toMediaCollection('image');
        }

        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        //dd($categorie->toArray());
        $categorie = Categorie::findOrFail($categorie->id);
        $categorie->delete();
        flash()->overlay('Suppression effectuée avec succès', 'Message')->success();
        return back();
    }
}
