<?php
// Cout total des commandes

use App\Models\Commande;
use App\Models\Produit;
use App\Models\Tarif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

function cout_commandes($commandes, $statut)
{
    $cout = 0;
    foreach ($commandes as $key => $commande) {
        if ($commande->statut == $statut) {
            $cout += $commande->montant;
        }
    }
    return $cout;
}

// Total de commande d'une date
function total_date_commandes($date)
{
    $date = Carbon::create($date);
    //dd($date->startOfDay());
    $commandes = Commande::orderBy('id', 'desc')
    ->whereBetween('created_at', [$date->startOfDay(), $date->copy()->endOfDay()])
    ->where([
        'statut' => 'attente'
    ])
    ->sum('montant');
    return $commandes;
}

// Envoie de SMS
function envoieSMS($telephone)
{
    $telephone = trim($telephone);
    $vowels = array(".", " ", "-", "/", "_", "+");
    $telephone = str_replace($vowels, "", $telephone);
    //echo strlen($telephone);
    if (strlen($telephone) == 8 or strlen($telephone) == 10) {
        $telephone = '225'.$telephone;
    }
    if (substr($telephone, 0, 2) == '00') {
        $telephone = substr($telephone, 2, 30);
    }

    //dd($telephone);
    //echo $telephone;
    // SMS
    if (strlen($telephone) == 11 or strlen($telephone) == 13) {
        $param = array(
            'username' => 'assygame',
            'password' => 'Assygame@2021',
            'sender' => 'Assygame',
            'text' => 'Félicitation! Votre commande a été bien enregistrée. Un commercial vous contactera. Infoline : 225 0707823299',
            'type' => 'text',
            'datetime' => Carbon::today(),
        );
        $recipients = array($telephone, '2250140622180');
        $post = 'to=' . implode(';', $recipients);
        foreach ($param as $key => $val) {
            $post .= '&' . $key . '=' . rawurlencode($val);
        }
        $url = "http://2tmsmspro.com/api/api_http.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
        $result = curl_exec($ch);
        if(curl_errno($ch)) {
            $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
        }
        else {
            $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
            switch($returnCode) {
                case 200 :
                    break;
                default :
                    $result = "HTTP ERROR: " . $returnCode;
            }
        }
        curl_close($ch);
        //print $result;
    }
    //Fin SMS
}


function devise($montant)
{
    return number_format($montant, 0, '.', ' ').' Fcfa';
}


// Durée générale de vie des cookies
function dureeCookie()
{
    return 60*60*24*7; // 7 jours
}


// Détails produit dans panier
function detailPanier($code)
{
    $produit = Produit::with([
        'categorie',
        'fournisseur',
        'tarifs' => function($q){
            $q->orderBy('montant', 'asc');
        },
        'tailles',
        'couleurs',
    ])
    ->where([
        'code' => $code,
    ])
    ->first();
    return $produit;
}


// Détails tarif
function detailTarif($id)
{
    return $tarif = Tarif::find($id);
}


// Calculer les frais d'expédition
function coutLivraison($cart)
{
    $cout = 0;
    foreach ($cart as $item)
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
    return $cout;
}


// Détails commandes
function detailCommande($field, $value)
{
    $commande = Commande::with([
        'client',
        'paiements',
        'produits',
    ])
    ->where([
        $field => $value,
    ])
    ->when(auth()->user(), function($q){
        return $q->where([
            'client_id' => auth()->user()->id,
        ]);
    })
    ->first();
    return $commande;
}


/**
 * get only button of cinetpay pay form
 * @param $formName
 * @param int $btnType
 * @param $size
 * @return string
 */
function getOnlyPayButtonToSubmit($formName, $btnType = 1, $size)
{
    $size = ($size == 'small') ? 'small' : (($size == 'larger') ? 'larger' : 'large');

    if (!empty($formName) && $btnType == 1) {
        $btn = "<button class='cpButton " . $size . "'> Acheter </button>";
    } elseif (!empty($formName) && $btnType == 2) {
        $btn = "<button class='cpButton " . $size . "'> Payer </button>";
    } elseif (!empty($formName) && $btnType == 3) {
        $btn = "<button class='cpButton " . $size . "'> Faire un don </button>";
    } elseif (!empty($formName) && $btnType == 4) {
        $btn = "<button class='cpButton " . $size . "'> Payer avec CinetPay</button>";
    } else {
        $btn = "<button class='cpButton " . $size . "'> Je confirme ma commande </button>";
    }
    return $btn;
}
