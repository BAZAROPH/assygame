<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::group(['prefix' => 'user'], function () {
        Route::post('/photo', [App\Http\Controllers\Api\UserController::class,'photo']);
        Route::get('/logout', [App\Http\Controllers\Api\UserController::class,'logout']);
        Route::post('/saveToken', [App\Http\Controllers\Api\UserController::class,'saveToken']);
        Route::get('/show', [App\Http\Controllers\Api\UserController::class,'show']);
        Route::post('/update', [App\Http\Controllers\Api\UserController::class,'update']);
        Route::get('/delete', [App\Http\Controllers\Api\UserController::class,'destroy']);
    });

    Route::group(['prefix' => 'produit'], function () {
        Route::post('/store', [App\Http\Controllers\Api\ProduitController::class,'store']);
        Route::post('/delete', [App\Http\Controllers\Api\ProduitController::class,'delete']);
        Route::get('/fourindex', [App\Http\Controllers\Api\ProduitController::class,'fourindex']);
        Route::post('/isnotlike', [App\Http\Controllers\Api\ProduitController::class,'isnotlike']);
        Route::post('/islike', [App\Http\Controllers\Api\ProduitController::class,'islike']);
        Route::post('/tarif', [App\Http\Controllers\Api\ProduitController::class,'tarif']);
        Route::post('/image', [App\Http\Controllers\Api\ProduitController::class,'image']);
        Route::post('/option', [App\Http\Controllers\Api\ProduitController::class,'option']);
        Route::get('/likeindex', [App\Http\Controllers\Api\ProduitController::class,'likeindex']);
        Route::get('/authindex', [App\Http\Controllers\Api\ProduitController::class,'authindex']);
        Route::post('/updateproduit', [App\Http\Controllers\Api\ProduitController::class,'updateproduit']);
        Route::post('/deleteoption', [App\Http\Controllers\Api\ProduitController::class,'deleteoption']);
        Route::post('/deletetarif', [App\Http\Controllers\Api\ProduitController::class,'deletetarif']);
        Route::post('/deletemedia', [App\Http\Controllers\Api\ProduitController::class,'deletemedia']);
    });

    Route::group(['prefix' => 'commande'], function () {
        Route::post('/store', [App\Http\Controllers\Api\CommandeController::class,'store']);
        Route::get('/index', [App\Http\Controllers\Api\CommandeController::class,'index']);
    });
});

Route::group(['prefix' => 'produit'], function () {
    Route::get('/hebdo', [App\Http\Controllers\Api\ProduitController::class,'hebdo']);
    Route::get('/index', [App\Http\Controllers\Api\ProduitController::class,'index']);
    Route::get('/show/{id}', [App\Http\Controllers\Api\ProduitController::class,'show']);
});

Route::group(['prefix' => 'ville'], function () {
    Route::get('/index', [App\Http\Controllers\Api\VilleController::class,'index']);
});

Route::group(['prefix' => 'slider'], function () {
    Route::get('/index', [App\Http\Controllers\Api\SliderController::class,'index']);
});

Route::group(['prefix' => 'pays'], function () {
    Route::get('/index', [App\Http\Controllers\Api\PaysController::class,'index']);
});

Route::group(['prefix' => 'categorie'], function () {
    Route::get('/index', [App\Http\Controllers\Api\CategorieController::class,'index']);
    Route::get('/index/{id}', [App\Http\Controllers\Api\CategorieController::class,'scategorie']);
    Route::get('/show/{id}', [App\Http\Controllers\Api\CategorieController::class,'show']);
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/login', [App\Http\Controllers\Api\UserController::class,'login']);
    Route::post('/register', [App\Http\Controllers\Api\UserController::class,'register']);
    Route::post('/token', [App\Http\Controllers\Api\UserController::class,'token']);
});