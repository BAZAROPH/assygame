<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Categorie::get();
        $produits = Produit::get();
        $commandes = Commande::whereNotIn('statut', [
            'cours'
        ])
        ->get();
        $clients = User::where(['type' => 'client'])->get();
        $fournisseurs = User::where(['type' => 'fournisseur'])->get();
        $sliders = Slider::get();

        return view('home')->with([
            'categories' => $categories,
            'produits' => $produits,
            'commandes' => $commandes,
            'clients' => $clients,
            'fournisseurs' => $fournisseurs,
            'sliders' => $sliders,
            'infosPage' => array(
                'title' => 'Accueil',
            ),
        ]);
    }
}
