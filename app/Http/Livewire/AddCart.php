<?php

namespace App\Http\Livewire;

use App\Models\Produit;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class AddCart extends Component
{

    public function addCart($id)
    {
        $produit = $this->post = Produit::findOrFail($id);
        //Cart::instance('test')->add('293ad', 'Product 1', 1, 9.99, 550, ['size' => 'large']);
        Cart::instance('shopping')->add($produit->code, $produit->titre, request('quantity'), request('tarif'));
        //Alert::success('Panier', 'Ajout au panier effectué avec succès');
    }
    public function render()
    {
        return view('livewire.add-cart');
    }
}
