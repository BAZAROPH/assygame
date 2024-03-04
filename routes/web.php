<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WebController::class, 'index'])->name('accueil');
Route::get('/category/{categorie}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/search', [SearchController::class, 'searchArticle'])->name('search');
Route::get('/products', [ProductController::class, 'products'])->name('product.all');

Route::resources([
    'product' => ProductController::class,
]);

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/wishlist', [ShoppingController::class, 'wishlist'])->name('wishlist');
Route::get('/wishlist/{produit}', [ShoppingController::class, 'addWishlist'])->name('wishlist.add');
Route::get('/panier', [ShoppingController::class, 'panier'])->name('panier');
Route::get('/cart/{produit}', [ShoppingController::class, 'addCart'])->name('panier.add');
Auth::routes();

Route::group([
    'middleware' => [
        'App\Http\Middleware\FinalisationInscription',
        'App\Http\Middleware\Authenticate',
        ]
    ], function() {
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::get('/profil/finish', [UserController::class, 'finishAccount'])->name('profil.finish');
    Route::post('/profil/finish', [UserController::class, 'finishRegister'])->name('profil.register');

    Route::get('/product/tarif/{produit}', [ProductController::class, 'tarif'])->name('product.tarif');
    Route::post('/product/tarif/{produit}', [ProductController::class, 'tarifStore'])->name('product.tarifStore');
    Route::post('/storeMedia', [ProductController::class, 'storeMedia'])->name('product.storeMedia');
    Route::get('/notify', [ShoppingController::class, 'notify'])->name('checkout.notify');
    Route::get('/return', [ShoppingController::class, 'retour'])->name('checkout.return');
    Route::get('/cancel', [ShoppingController::class, 'cancel'])->name('checkout.cancel');


    Route::get('/profil/edit', [UserController::class, 'edit_member']);
    Route::post('/profil/edit', [UserController::class, 'update_member']);
    Route::get('/profil/picture', [UserController::class, 'edit_picture']);
    Route::post('/profil/picture', [UserController::class, 'update_picture']);
    Route::get('/profil/password', [UserController::class, 'edit_password']);
    Route::post('/profil/password', [UserController::class, 'update_password']);
    Route::get('/profil/commande', [UserController::class, 'commande'])->name('commande');

    Route::get('/mode-de-paiement', [ShoppingController::class, 'modePaiement'])->name('panier.paiement');
    Route::get('/status-payment', [ShoppingController::class, 'statusPayment'])->name('statusPayment');
    Route::get('/felicitation/{reference}', [ShoppingController::class, 'felicitation'])->name('felicitation');

});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/commande/rapport', [CommandeController::class, 'rapport'])->name('rapport');
    Route::get('/produit/{produit}/validation/{status}', [ProduitController::class, 'validation'])->name('validation');
    Route::get('/produit/{produit}/hebdo/{status}', [ProduitController::class, 'hebdo'])->name('hebdo');

    Route::resources([
        'categorie' => CategorieController::class,
        'produit' => ProduitController::class,
        'commande' => CommandeController::class,
        'user' => UserController::class,
        'slider' => SliderController::class,
    ]);
    Route::post('/commande/{commande}', [CommandeController::class, 'statut_commande'])->name('statut_commande');
});

Route::get('/transitaire/{user}', [UserController::class, 'transitaire'])->name('transitaire');
Route::post('/transitaire/{user}', [UserController::class, 'transitaire_send'])->name('transitaire_send');
Route::post('/transitaire/{user}/edit', [UserController::class, 'transitaire_update'])->name('transitaire_update');

Route::get('/findCategory/{id}', [WebController::class, 'findCategory'])->name('category.find');
Route::get('/fraisExpedition/{quantite}/{rowId}', [WebController::class, 'fraisExpedition'])->name('panier.frais');

//Route::get('/{slug}', [WebController::class, 'showProduit'])->name('showProduit');
//Route::get('/category/{slug}', [WebController::class, 'showCategory'])->name('showCategory');

Route::get('test', function () {
    dd(Cart::instance('shopping')->content()->toArray());
    //Cart::instance('shopping')->destroy();
});
