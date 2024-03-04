<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Models\Produit;
use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search product.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchArticle()
    {
        // Get recents products
        $produits = Produit::with([
            'categorie',
            'fournisseur',
            'tarifs' => function($q){
                $q->orderBy('montant', 'asc');
            }
        ])
        ->where([
            'status' => 1,
        ])
        ->where('titre', 'like', '%' . request('term_search') . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(30);
        // Journalisation
        activity()
            ->log('product search');
        // End journalisation
        return view('web.cart.search-produit')->with([
            'produits' => $produits,
            'infosPage' => array(
                'title' => 'Recherche de produit',
                'slug' => route('search'),
            ),
        ]);
    }
}
