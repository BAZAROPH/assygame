<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Commande;
use App\Mail\CommandeMail;
use App\Models\Produit;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Detection\MobileDetect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use CinetPay\CinetPay;
use Exception;

//use Illuminate\Support\Facades\Cookie;
//use Symfony\Component\HttpFoundation\Cookie;

class ShoppingController extends Controller
{
    function addCart(Produit $produit)
    {
        $tarif = detailTarif(request('tarif'));
        Cart::instance('shopping')->add($produit->code, $produit->titre, request('quantity'), $tarif->montant, 0, [
            'taille' => request('taille'),
            'couleur' => request('couleur'),
            'quantite' => $tarif->quantite,
        ]);

        flash('Ajout de <strong>"'.$produit->titre.'"</strong> panier')->success();
        //Alert::success('Panier', 'Ajout de "'.$produit->titre.'" au panier');
        return back();
    }

    function addWishlist(Produit $produit)
    {
        //dd($produit->toArray());
        Cart::instance('wishlist')->add($produit->code, $produit->titre, 1, 1);
        flash('Ajout de <strong>"'.$produit->titre.'"</strong> au favoris')->success();
        return back();
    }

    function panier()
    {
        $code_commande = null;
        if (auth()->user()) {
            $user = User::with([
                'commandes',
                'panier' => function($q){
                    $q->with([
                        'produits',
                    ]);
                },
            ])
            ->find(auth()->user()->id);
            //dd($user->toArray());

            $cout_commande = Cart::instance('shopping')->subtotal();
            $cout_livraison = coutLivraison(Cart::instance('shopping')->content());
            $total_commande = $cout_commande + $cout_livraison;
            if (count($user->panier) == 0) {
                $commande = Commande::create([
                    'montant' => $cout_commande,
                    'livraison' => $cout_livraison,
                    'total' => $total_commande,
                    'client_id' => auth()->user()->id,
                    'statut' => 'cours',
                    'created_ip' => request()->ip(),
                ]);
                foreach (Cart::instance('shopping')->content() as $item){
                    $post = detailPanier($item->id);
                    $commande->produits()->attach($post->id, [
                        'montant' => $item->price,
                        'quantite' => $item->qty,
                        'options' => json_encode($item->options),
                    ]);
                }
            }
            else {
                if (count(Cart::instance('shopping')->content())) {
                    $commande = $user->panier->first();
                    $code_commande = $commande->code;
                    $commande->montant = $cout_commande;
                    $commande->livraison = $cout_livraison;
                    $commande->total = $total_commande;
                    $commande->save();
                    foreach (Cart::instance('shopping')->content() as $item){
                        $post = detailPanier($item->id);
                        $commande->produits()->detach($post->id);
                        $commande->produits()->attach($post->id, [
                            'montant' => $item->price,
                            'quantite' => $item->qty,
                            'options' => json_encode($item->options),
                        ]);
                    }
                }
                else {
                    /* foreach($user->panier->first()->produits as $produit){
                        Cart::instance('shopping')->add($produit->code, $produit->titre, $produit->pivot->quantite, $produit->montant, 0, [
                            'taille' => request('taille'),
                            'couleur' => request('couleur'),
                            'quantite' => $produit->quantite,
                        ]);
                    } */
                }
            }

        }
        // Vider panier
        if (request('clean') == 1) {
            Cart::instance('shopping')->destroy();
            flash('Panier vider avec succès')->success();
            return redirect()->route('panier');
        }

        // Supprimer élément du panier
        if (request('rowId')) {
            Cart::instance('shopping')->remove(request('rowId'));
            flash('Elément supprimé avec succès')->success();
            return redirect('panier');
        }

        /*
        * Preparation des elements constituant le panier
        */
        $apiKey = "37555867560e854f2a14d99.49563298"; //Veuillez entrer votre apiKey
        $site_id = "918232"; //Veuillez entrer votre siteId
        $id_transaction = CinetPay::generateTransId(); // Identifiant du Paiement
        $description_du_paiement = 'Commande N°'.$code_commande; // Description du Payment
        $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système
        $montant_a_payer = mt_rand(100, 200); // Montant à Payer : minimun est de 100 francs sur CinetPay
        $devise = 'XOF'; // Montant à Payer : minimun est de 100 francs sur CinetPay
        $identifiant_du_payeur = 'payeur@domaine.ci'; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
        $formName = "goCinetPay"; // nom du formulaire CinetPay
        $notify_url = route('checkout.notify'); // Lien de notification CallBack CinetPay (IPN Link)
        $return_url = route('checkout.return'); // Lien de retour CallBack CinetPay
        $cancel_url = 'https://assygame.test/panier?cancel'; // Lien d'annulation CinetPay
        // Configuration du bouton
        $btnType = 5;//1-5xwxxw
        $btnSize = 'large'; // 'small' pour reduire la taille du bouton, 'large' pour une taille moyenne ou 'larger' pour  une taille plus grande

        // Paramétrage du panier CinetPay et affichage du formulaire
        $cp = new CinetPay($site_id, $apiKey);

        // Journalisation
        activity()
            ->log('show cart');
        // End journalisation
        return view('web.cart.panier')->with([
            'apiKey' => $apiKey,
            'site_id' => $site_id,
            'id_transaction' => $id_transaction,
            'description_du_paiement' => $description_du_paiement,
            'date_transaction' => $date_transaction,
            'montant_a_payer' => $montant_a_payer,
            'devise' => $devise,
            'identifiant_du_payeur' => $identifiant_du_payeur,
            'formName' => $formName,
            'notify_url' => $notify_url,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
            'btnType' => $btnType,
            'btnSize' => $btnSize,
            'cp' => $cp,
            'infosPage' => array(
                'title' => 'Panier',
                'slug' => route('panier'),
            ),
        ]);
    }

    // Liste d'envie
    function wishlist()
    {
        if (request('clean') == 1) {
            Cart::instance('wishlist')->destroy();
            return redirect('wishlist');
        }
        if (request('rowId')) {
            Cart::instance('wishlist')->remove(request('rowId'));
            flash('Elément supprimé avec succès')->success();
            return redirect('wishlist');
        }
        // Journalisation
        activity()
            ->log('show wishlist');
        // End journalisation
        return view('web.cart.wishlist')->with([
            'infosPage' => array(
                'title' => 'Favoris',
                'slug' => 'wishlist',
            ),
        ]);
    }

    // Adresse de livraison
    function adresseLivraison()
    {
        return_panier();
        $commande = detailCommande('reference', Cookie::get('invASS'));
        //dd($commande->toArray());
        /* if (!$commande) {
            $commande = panierCommande('reference', Cookie::get('invASS'), auth()->user());
        } */

        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
            $client = User::find($user_id);
        }
        else{
            $user_id = auth()->user()->id;
            $client = null;
            if (!$commande->user_id) {
                $commande->user_id = $user_id;
                $commande->save();
            }
        }
        // Les adresses de livraison d'un user
        $adresses = Categorie::with([
            'parent'
        ])
        ->where([
            'user_id' => $user_id,
            'taxonomie_id' => 33,
        ])
        ->orderBy('id', 'desc')
        ->get();

        // Listing des pays
        $pays = Categorie::where([
            'taxonomie_id' => 4,
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        // Liste des villes du pays selectionné par defaut
        $villes = Categorie::where([
            'taxonomie_id' => 5,
            'parent_id' => 928
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        // Liste des quartiers de la ville selectionnée par defaut
        $quartiers = Categorie::where([
            'taxonomie_id' => 6,
            'parent_id' => 928
        ])
        ->orderBy('libelle', 'asc')
        ->get();

        //dd($adresses->toArray());
        if (!count(Cart::instance('shopping')->content())){
            return redirect('panier');
        }

        // Vérification adresse de livraison avant de passer à date de livraison
        if (request('address_id')) {
            $adresse = Categorie::where([
                'user_id' => $user_id,
                'taxonomie_id' => 33,
                'id' => request('address_id'),
            ])->first();
            //dd($adresse);
            if ($adresse) {
                //$cookie = Cookie::make('adresse', request('address_id'), dureeCookie());
                $commande->adresse_id = request('address_id');
                $commande->save();
                return redirect('date-de-livraison')/* ->cookie($cookie) */;
            }
            else {
                flash('Cette de adresse de livraison est inconnue !!')->error();
                return redirect('adresse-de-livraison');
            }
        }

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout listing user-adresse');
        // End journalisation
        return view('web.cart.adresse-de-livraison')->with([
            'client' => $client,
            'pays' => $pays,
            'villes' => $villes,
            'quartiers' => $quartiers,
            'adresses' => $adresses,
            'infosPage' => array(
                'title' => 'Adresse de livraison',
                'slug' => 'adresse-de-livraison',
            ),
        ]);
    }

    // Ajouter une adresse de livraison d'un user
    function addAddress(Request $request)
    {
        $this->validate($request,[
            'pays_id' => 'required|integer',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
        ]);

        $commande = detailCommande('reference', Cookie::get('invASS'));
        if ($commande->commercial_id) {
            $user_id = $commande->user_id;
        }
        else{
            $user_id = auth()->user()->id;
        }
        $adresse = Categorie::create([
            'libelle' => request('adresse'),
            'sous_titre' => request('ville'),
            'lien' => request('telephone'),
            'parent_id' => request('pays_id'),
            'taxonomie_id' => 33,
            'user_id' => $user_id,
        ]);
        flash('Ajout effectué avec succès')->success();
        return back();
    }

    // Modifier adresse de livraison d'un user
    function editAddress(Request $request, $id)
    {
        $this->validate($request,[
            'pays_id' => 'required|integer',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
        ]);

        $adresse = Categorie::findOrFail($id);
        $adresse->parent_id = request('pays_id');
        $adresse->libelle = request('adresse');
        $adresse->sous_titre = request('ville');
        $adresse->lien = request('telephone');
        $adresse->save();
        flash('Modification effectuée avec succès')->success();
        return back();
    }

    // Ajouter une adresse de livraison d'un user
    function deleteAddress(Request $request, $id)
    {
        $adresse = Categorie::findOrFail($id);
        $adresse->delete();
        flash('Suppression effectuée avec succès')->success();
        return back();
    }

    // Page de choix du mode de paiement
    function modePaiement()
    {
        if (!count(Cart::instance('shopping')->content())){
            return redirect('panier');
        }
        $cout_commande = Cart::instance('shopping')->subtotal();
        $cout_livraison = coutLivraison(Cart::instance('shopping')->content());
        $total_commande = $cout_commande + $cout_livraison;
        $user_id = (auth()->user()) ? auth()->user()->id : null;

        if (!Cookie::get('invASS')) {
            $commande = Commande::create([
                'montant' => $cout_commande,
                'livraison' => $cout_livraison,
                'total' => $total_commande,
                'client_id' => $user_id,
                'statut' => 'cours',
                'created_ip' => request()->ip(),
            ]);
            foreach (Cart::instance('shopping')->content() as $item){
                $post = detailPanier($item->id);
                $commande->produits()->attach($post->id, [
                    'montant' => $item->price,
                    'quantite' => $item->qty,
                    'options' => json_encode($item->options),
                ]);
            }
            $cookie = Cookie::make('invASS', $commande->code, dureeCookie());
            return redirect()->route('panier.paiement')->cookie($cookie);
        }
        else {
            $commande = Commande::with([
                'client',
                'paiements',
                'produits',
            ])
            ->where('code', Cookie::get('invASS'))
            ->first();
            $commande->montant = $cout_commande;
            $commande->livraison = $cout_livraison;
            $commande->total = $total_commande;
            $commande->save();
            //dd($commande->toArray());
            foreach (Cart::instance('shopping')->content() as $item){
                $post = detailPanier($item->id);
                $commande->produits()->detach($post->id);
                $commande->produits()->attach($post->id, [
                    'montant' => $item->price,
                    'quantite' => $item->qty,
                    'options' => json_encode($item->options),
                ]);
            }
        }
        $commande = detailCommande('code', Cookie::get('invASS'));

        // En cas d'annulation de paiement
        if (request('annulation') == 'paiement') {
            //flash('Paiement annulé')->error();
            $ids = $commande->mode_paiements()
            ->where('token', request('token'))
            ->update([
                'valide' => 2
            ]);
            Alert::warning('Paiement', 'Paiement annulé');
        }
        /*
        * Preparation des elements constituant le panier
        */
        $apiKey = "37555867560e854f2a14d99.49563298"; //Veuillez entrer votre apiKey
        $site_id = "918232"; //Veuillez entrer votre siteId
        $id_transaction = CinetPay::generateTransId(); // Identifiant du Paiement
        $description_du_paiement = sprintf('Mon produit de ref %s', $id_transaction); // Description du Payment
        $date_transaction = date("Y-m-d H:i:s"); // Date Paiement dans votre système
        $montant_a_payer = mt_rand(100, 200); // Montant à Payer : minimun est de 100 francs sur CinetPay
        $devise = 'XOF'; // Montant à Payer : minimun est de 100 francs sur CinetPay
        $identifiant_du_payeur = 'payeur@domaine.ci'; // Mettez ici une information qui vous permettra d'identifier de façon unique le payeur
        $formName = "goCinetPay"; // nom du formulaire CinetPay
        $notify_url = 'http://lemarche.mws-ci.com/cinetpay/notify'; // Lien de notification CallBack CinetPay (IPN Link)
        $return_url = ''; // Lien de retour CallBack CinetPay
        $cancel_url = 'https://assygame.test/panier?cancel'; // Lien d'annulation CinetPay
        // Configuration du bouton
        $btnType = 5;//1-5xwxxw
        $btnSize = 'large'; // 'small' pour reduire la taille du bouton, 'large' pour une taille moyenne ou 'larger' pour  une taille plus grande

        // Paramétrage du panier CinetPay et affichage du formulaire
        $cp = new CinetPay($site_id, $apiKey);

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout mode-de-paiement');
        // End journalisation
        return view('web.cart.mode-de-paiement')->with([
            'apiKey' => $apiKey,
            'site_id' => $site_id,
            'id_transaction' => $id_transaction,
            'description_du_paiement' => $description_du_paiement,
            'date_transaction' => $date_transaction,
            'montant_a_payer' => $montant_a_payer,
            'devise' => $devise,
            'identifiant_du_payeur' => $identifiant_du_payeur,
            'formName' => $formName,
            'notify_url' => $notify_url,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
            'btnType' => $btnType,
            'btnSize' => $btnSize,
            'cp' => $cp,
            'commande' => $commande,
            'infosPage' => array(
                'title' => 'Mode de paiement',
                'slug' => 'mode-de-paiement',
            ),
        ]);
    }

    public function notify()
    {
        $id_transaction = $_POST['cpm_trans_id'];
        if (!empty($id_transaction)) {
            try {
                $apiKey = "37555867560e854f2a14d99.49563298"; //Veuillez entrer votre apiKey
                $site_id = "918232"; //Veuillez entrer votre siteId

                $cp = new CinetPay($site_id, $apiKey);

                // Reprise exacte des bonnes données chez CinetPay
                $cp->setTransId($id_transaction)->getPayStatus();
                $paymentData = [
                    "cpm_site_id" => $cp->_cpm_site_id,
                    "signature" => $cp->_signature,
                    "cpm_amount" => $cp->_cpm_amount,
                    "cpm_trans_id" => $cp->_cpm_trans_id,
                    "cpm_custom" => $cp->_cpm_custom,
                    "cpm_currency" => $cp->_cpm_currency,
                    "cpm_payid" => $cp->_cpm_payid,
                    "cpm_payment_date" => $cp->_cpm_payment_date,
                    "cpm_payment_time" => $cp->_cpm_payment_time,
                    "cpm_error_message" => $cp->_cpm_error_message,
                    "payment_method" => $cp->_payment_method,
                    "cpm_phone_prefixe" => $cp->_cpm_phone_prefixe,
                    "cel_phone_num" => $cp->_cel_phone_num,
                    "cpm_ipn_ack" => $cp->_cpm_ipn_ack,
                    "created_at" => $cp->_created_at,
                    "updated_at" => $cp->_updated_at,
                    "cpm_result" => $cp->_cpm_result,
                    "cpm_trans_status" => $cp->_cpm_trans_status,
                    "cpm_designation" => $cp->_cpm_designation,
                    "buyer_name" => $cp->_buyer_name,
                ];
                // Recuperation de la ligne de la transaction dans votre base de données

                // Verification de l'etat du traitement de la commande

                // Si le paiement est bon alors ne traitez plus cette transaction : die();

                // On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction

                // On verifie que le paiement est valide
                if ($cp->isValidPayment()) {
                    echo 'Felicitation, votre paiement a été effectué avec succès';
                    die();
                } else {
                    echo 'Echec, votre paiement a échoué pour cause : ' . $cp->_cpm_error_message;
                    die();
                }
            } catch (Exception $e) {
                // Une erreur s'est produite
                echo "Erreur :" . $e->getMessage();
            }
        } else {
            // redirection vers la page d'accueil
            die();
        }
    }

    // Page de choix du mode de paiement
    function felicitation($reference)
    {
        $commande = Commande::with([
            'client',
            'paiements',
            'produits',
        ])
        ->where([
            'code' => $reference,
        ])
        ->when(auth()->user(), function($q){
            return $q->where([
                'client_id' => auth()->user()->id,
            ]);
        })
        ->first();

        // Journalisation
        activity()
            ->performedOn($commande)
            ->log('checkout felicitation');
        // End journalisation
        return view('web.cart.felicitation')->with([
            'commande' => $commande,
            'infosPage' => array(
                'title' => 'Commande validée',
                'slug' => 'felicitation',
            ),
        ]);
    }
}
