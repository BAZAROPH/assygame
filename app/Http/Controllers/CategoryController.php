<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recuperation des grandes categories
        $categories = Categorie::with([
            'categorie',
            'categories' => function($q){
                $q->with([
                    'produits' => function($q){
                        $q->where([
                            'status' => 1,
                        ]);
                    }
                ]);
            },
            'produits' => function($q){
                $q->where([
                    'status' => 1,
                ]);
            },
        ])
        ->whereNull('categorie_id')
        ->get();

        return view('web.category.index')->with([
            'categories' => $categories,
            'infosPage' => array(
                'title' =>'Categorie',
                'slug' => 'categorie',
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
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        $categorie = Categorie::with([
            'categorie',
            'categories'=>function($q){
                $q->with([
                    'produits' => function($q){
                        $q->where([
                            'status' => 1,
                        ]);
                    }
                ]);
            },
            'produits',
        ])
        ->find($categorie->id);
        // dd($categorie->toArray());
        return view('web.category.show')->with([
            'categorie' => $categorie,
            'infosPage' => array(
                'title' => $categorie->titre,
                'slug' => route('category.show', $categorie),
            ),
        ]);
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
