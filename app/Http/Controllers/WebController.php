<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Slider;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Cookie::get('homASS')) {
            if (request('accueil')) {
                $cookie = Cookie::make('homASS', 1, 60*60*24*365*5);
                return redirect(route('accueil'))->cookie($cookie);
            }
            $sliders = Slider::where([
                'type' => 'splashscreen',
            ])
            ->orderBy('id', 'desc')
            ->get();
            // Journalisation
                activity()
                ->log('splashscreen');
            // End journalisation
            return view('web.enter')->with([
                'sliders' => $sliders,
                'infosPage' => array(
                    'title' => 'splashscreen',
                    'slug' => route('accueil'),
                ),
            ]);
        }
        else {
            // get carousel homepage
            $sliders = Slider::where([
                'type' => 'accueil',
            ])
            ->orderBy('id', 'desc')
            ->get();

            // Get categorie level 1
            $categories = Categorie::whereNull('categorie_id')
            ->orderBy('titre', 'asc')
            ->get();

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
            ->limit(14)
            ->get();
            //dd($produits->toArray());

            // Get recents products
            $hebdo = Produit::with([
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
                'hebdo' => 1,
            ])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

            // Journalisation
                activity()
                ->log('home');
            // End journalisation
            return view('web.welcome')->with([
                'produits' => $produits,
                'hebdo' => $hebdo,
                'categories' => $categories,
                'sliders' => $sliders,
                'infosPage' => array(
                    'title' => 'Accueil',
                    'slug' => route('accueil'),
                ),
            ]);
        }
    }

    // Find category
    public function findCategory($id)
    {
        $childrens = Categorie::where([
            'categorie_id' => $id,
        ])->get();
        //dd($quartier->toArray());
        return response()->json($childrens);
    }

    // Calcul de frais d'expédition en fonction du nombre d'article
    public function fraisExpedition($quantite, $rowId)
    {
        if ($quantite > 0) {
            Cart::instance('shopping')->update($rowId, $quantite); // Will update the quantity
        }
        $cout = 0;
        foreach (Cart::instance('shopping')->content() as $item)
        {
            $quantite = $item->qty * $item->options->quantite;
            $post = detailPanier($item->id);
            if ($post->categorie_id == 5) {
                $cout += $quantite * 5000;
            }
            else {
                switch ($quantite) {
                    case ($quantite >= 1 && $quantite <= 100):
                        $cout += $quantite * 2000;
                        break;
                    case ($quantite <= 200):
                        $cout += $quantite * 1500;
                        break;
                    case ($quantite <= 500):
                        $cout += $quantite * 1000;
                        break;
                    case ($quantite <= 1000):
                        $cout += $quantite * 700;
                        break;
                    case ($quantite > 1000):
                        $cout += $quantite * 500;
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        $totalCommande = Cart::instance('shopping')->total() + $cout;
        $sousTotal = Cart::instance('shopping')->total();
        return response()->json(
            array(
                'cout' => devise($cout),
                'totalCommande' => devise($totalCommande),
                'sousTotal' => devise($sousTotal),
            )
        );
    }
}
