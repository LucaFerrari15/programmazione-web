<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DataLayer
{
    public function listProducts()
    {
        $productsList = Product::orderBy('nome')->get();
        return $productsList;
    }

    public function findProductById($id)
    {
        $product = Product::where('id', $id)->first();
        return $product;
    }

    public function findProductByName($nome)
    {
        $product = Product::where('nome', $nome)->get();
        if (count($product) === 0) {
            return false;
        } else {
            return true;
        }
        ;
    }


    public function listTeams()
    {
        $teamsList = Team::all();
        return $teamsList;
    }

    public function listBrands()
    {
        $brandList = Brand::all();
        return $brandList;
    }

    public function addToCart($product_id, $size_id, $user_id)
    {
        // Se il prodotto+taglia esiste già → incremento quantità
        $existing = CartItem::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->where('size_id', $size_id)
            ->first();

        if ($existing) {
            $existing->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'size_id' => $size_id,
                'quantity' => 1
            ]);
        }
    }

    public function removeFromCart($cart_item_id, $user_id)
    {
        $cartItem = CartItem::where('id', $cart_item_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$cartItem) {
            return; // TODO
        }

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
        }
    }


    public function showCart($user_id)
    {
        $cart = CartItem::where('user_id', $user_id)->orderBy('product_id', 'asc')->get();
        return $cart;
    }
}