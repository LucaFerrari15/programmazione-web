<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ProductNotAvailableException;
use App\Exceptions\CartEmptyException;
use App\Exceptions\CartItemNotFoundException;

class DataLayer
{
    public function listProducts()
    {
        $productsList = Product::orderBy('nome')->get();
        return $productsList;
    }

    public function listSizes() 
    {
        $sizesList = Size::all();
        return $sizesList;
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

    public function getOrderStatus() {
        return Order::getStatusOptions();
    }

    public function findOrderByTerm($term)
    {
        return Order::where(function ($query) use ($term) {
            $query->where('id', 'LIKE', "%{$term}%")
                ->orWhere('user_id', 'LIKE', "%{$term}%")
                ->orWhere('status', 'LIKE', "%{$term}%")
                ->orWhere('nome_spedizione', 'LIKE', "%{$term}%")
                ->orWhere('cognome_spedizione', 'LIKE', "%{$term}%")
                ->orWhere('via', 'LIKE', "%{$term}%")
                ->orWhere('civico', 'LIKE', "%{$term}%")
                ->orWhere('cap', 'LIKE', "%{$term}%")
                ->orWhere('comune', 'LIKE', "%{$term}%")
                ->orWhere('provincia', 'LIKE', "%{$term}%")
                ->orWhere('paese', 'LIKE', "%{$term}%")
                ->orWhere('total', 'LIKE', "%{$term}%");
        })->get();
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

    public function removeOneFromCart($cart_item_id, $user_id)
    {
        $cartItem = CartItem::where('id', $cart_item_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$cartItem) {
            throw new CartItemNotFoundException("L'articolo selezionato non esiste nel carrello.");
        }

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
        }
    }

    public function removeFromCart($cart_item_id, $user_id) {
        $cartItem = CartItem::where('id', $cart_item_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$cartItem) {
            throw new CartItemNotFoundException("L'articolo selezionato non esiste nel carrello.");
        }

        $cartItem->delete();
    }


    public function showCart($user_id)
    {
        $cart = CartItem::where('user_id', $user_id)
            ->with(['product', 'size'])
            ->orderBy('product_id', 'asc')
            ->get();

        return $cart;
    }


    public function createNewOrder($user_id, $orderData, $total)
    {
        return Order::create([
            'user_id' => $user_id,
            'status' => 'paid', // simulazione
            'nome_spedizione' => $orderData['nome_spedizione'],
            'cognome_spedizione' => $orderData['cognome_spedizione'],
            'via' => $orderData['via'],
            'civico' => $orderData['civico'],
            'cap' => $orderData['cap'],
            'comune' => $orderData['comune'],
            'provincia' => $orderData['provincia'],
            'paese' => $orderData['paese'],

            'total' => $total
        ]);
    }

    public function getQuantityProductByIdAndSize($product_id, $size_id)
    {
        $productSizeCercato = ProductSize::where('product_id', $product_id)
            ->where('size_id', $size_id)
            ->first();
        return $productSizeCercato ? $productSizeCercato->quantita : 0;
    }




    public function createOrderItem($order, $item)
    {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'size_id' => $item->size_id,
            'quantity' => $item->quantity,
            'price' => $item->product->prezzo,
        ]);
    }

    public function decrementaTaglie($item)
    {
        ProductSize::where('product_id', $item->product_id)
            ->where('size_id', $item->size_id)
            ->decrement('quantita', $item->quantity);
    }

    public function createOrderFromCart($user_id, $orderData)
    {
        $cartItems = $this->showCart($user_id);
        $total = 0;

        if ($cartItems->count() == 0) {
            throw new CartEmptyException();
        }

        // Controllo disponibilità
        foreach ($cartItems as $item) {

            $quantitaDisponibile = $this->getQuantityProductByIdAndSize($item->product->id, $item->size->id);

            if ($quantitaDisponibile < $item->quantity) {
                CartItem::where('user_id', $user_id)
                    ->where('id', $item->id)
                    ->decrement('quantity', $item->quantity - $quantitaDisponibile);


                $prodottiNonDisponibili[] = "{$item->product->nome}";
            }




        }

        if (!empty($prodottiNonDisponibili)) {
            $messaggio = "Alcuni prodotti non sono disponibili nelle quantità richieste e sono stati rimossi gli elementi in eccesso dal carrello:\n- "
                . implode("\n- ", $prodottiNonDisponibili);

            throw new ProductNotAvailableException($messaggio);
        }

        foreach ($cartItems as $item) {

            $total += $item->product->prezzo * $item->quantity;
        }


        $order = $this->createNewOrder($user_id, $orderData, $total);



        foreach ($cartItems as $item) {
            $this->createOrderItem($order, $item);

            $this->decrementaTaglie($item);

        }


        CartItem::where('user_id', $user_id)->delete();

        return $order;
    }

    public function listOrders($user_id)
    {
        return Order::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function listAllOrders()
    {
        return Order::orderBy('id', 'desc')->get();
    }


    public function findOrderByIdAndUser($id, $user_id)
    {
        $order = Order::where('id', $id)->where('user_id', $user_id)->first();
        return $order;
    }

    public function findOrderById($id)
    {
        $order = Order::find($id);
        return $order;
    }



    public function changeOrderStatus($order_id, $status)
    {
        $order = Order::find($order_id);

        $order->update(['status' => $status]);
    }


    public function findUserByemail($email) {
        $users = User::where('email', $email)->get();
        
        if (count($users) == 0) {
            return false;
        } else {
            return true;
        }
    }
}