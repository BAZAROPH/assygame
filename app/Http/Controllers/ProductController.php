<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Option;
use App\Models\Produit;
use App\Models\Tarif;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get recents products
        $produits = Produit::with([
            'categorie',
            'fournisseur',
            'tarifs' => function($q){
                $q->orderBy('montant', 'asc');
            },
            'tailles',
            'couleurs',
        ])
        ->where([
            'fournisseur_id' => auth()->user()->id,
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        // Journalisation
        activity()
            ->log('user product index');
        // End journalisation
        return view('web.user.product.index')->with([
            'produits' => $produits,
            'infosPage' => array(
                'title' => 'Produits',
                'slug' => route('product.index'),
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
        if (Cookie::get('proASS')) {
            $produit = Produit::where([
                'code' => Cookie::get('proASS')
            ])->first();
            flash('Finaliser votre publication')->info();
            return redirect(route('product.tarif', $produit));
        }
        $categories = Categorie::whereNull('categorie_id')
        ->orderBy('titre', 'asc')
        ->get();
        // get all sizes
        $sizes = Option::where([
            'type' => 'taille'
        ])
        ->orderBy('titre', 'asc')
        ->get();
        // get all colors
        $colors = Option::where([
            'type' => 'couleur'
        ])
        ->orderBy('titre', 'asc')
        ->get();
        // Journalisation
        activity()
            ->log('user product create');
        // End journalisation
        return view('web.user.product.create')->with([
            'sizes' => $sizes,
            'colors' => $colors,
            'categories' => $categories,
            'infosPage' => array(
                'title' => 'Ajout de produit',
                'slug' => route('product.create'),
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
            'categorie' => 'integer|required',
            'sous_categorie' => 'integer',
            'titre' => 'string|required|max:255',
            'description' => 'required',
        ]);

        if (empty(request('sous_categorie'))) {
            $produit = Produit::create([
                'titre' => request('titre'),
                'description' => request('description'),
                'categorie_id' => request('categorie'),
                'stock' => 'En stock',
                'status' => 0,
                'fournisseur_id' => auth()->user()->id
            ]);
        }
        else {
            $produit = Produit::create([
                'titre' => request('titre'),
                'description' => request('description'),
                'categorie_id' => request('sous_categorie'),
                'stock' => 'En stock',
                'status' => 0,
                'fournisseur_id' => auth()->user()->id
            ]);
        }
        //dd($produit);

        foreach ($request->input('document', []) as $file) {
            $produit->addMedia(storage_path('app/public/'.$file))->toMediaCollection('image', 'public');
        }
        $tailles = $produit->tailles()->attach(request('size'));
        $couleurs = $produit->couleurs()->attach(request('color'));

        flash('Finaliser votre publication')->info();
        $cookie = Cookie::make('proASS', $produit->code, dureeCookie());
        return redirect(route('product.tarif', $produit))->cookie($cookie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $product)
    {
        //dd(Cart::instance('shopping')->subtotal());
        $produit = Produit::with([
            'categorie',
            'fournisseur',
            'tarifs' => function($q){
                $q->orderBy('montant', 'asc');
            },
            'tailles',
            'couleurs',
        ])
        ->find($product->id);
        if (!$product) {

            redirect()->route('accueil');
        }
        //dd($produit->toArray());
        // Journalisation
        /* activity()
            ->log('user product create'); */
        // End journalisation
        return view('web.produit.show')->with([
            'produit' => $produit,
            'infosPage' => array(
                'title' => $produit->titre,
                'slug' => route('product.show', $produit),
            ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //
    }

    // Storage pictures product
    public function storeMedia(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $name = uniqid('iMQ_').'_'.Str::random(30).'.'.$extension;

        $path = storage_path('app/public/');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        //$img = Image::make($file);
        //$img->insert(public_path('admin/image/watermark.png'), 'bottom-right', 10, 10);
        $file->move($path, $name);
        //$img->save(storage_path('app/public/'.$name));

        // Journalisation
        activity()
            ->log('upload image dropzone');
        // End journalisation

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tarif(Produit $produit)
    {
        if (!Cookie::get('proASS')) {
            return redirect(route('product.create'));
        }
        // Journalisation
        activity()
            ->log('user product create tarif');
        // End journalisation
        return view('web.user.product.tarif')->with([
            'produit' => $produit,
            'infosPage' => array(
                'title' => 'Tarif de produit',
                'slug' => route('product.tarifStore', $produit),
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tarifStore(Request $request, Produit $produit)
    {
        $this->validate($request,[
            'quantite' => 'array|required',
            'montant' => 'array|required',
        ]);
        //dd(request('quantite'), request('montant'));

        foreach (request('quantite') as $key => $value) {
            Tarif::create([
                'quantite' => request('quantite')[$key],
                'montant' => request('montant')[$key],
                'produit_id' => $produit->id,
            ]);
        }
        $cookie = Cookie::forget('proASS');
        flash('Produit ajouté avec succès')->success();
        return redirect(route('product.index'))->cookie($cookie);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        // Get recents products
        $produits = Produit::with([
            'categorie',
            'fournisseur',
            'tarifs' => function($q){
                $q->orderBy('montant', 'asc');
            },
            'tailles',
            'couleurs',
        ])
        ->where([
            'status' => 1,
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(30);
        // Journalisation
        activity()
            ->log('user product index');
        // End journalisation
        return view('web.produit.all')->with([
            'produits' => $produits,
            'infosPage' => array(
                'title' => 'Tous les produits',
                'slug' => route('product.all'),
            ),
        ]);
    }
}
