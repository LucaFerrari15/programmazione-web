<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Exceptions\CartItemNotFoundException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $sizeId = $request->input('size_id');

        $dl = new DataLayer();
        $dl->addToCart($productId, $sizeId, auth()->user()->id);

        // Imposto la sessione per aprire l'offcanvas
        session()->flash('open_cart_offcanvas', true);

        $redirectTo = $request->input('redirect') ?? url()->previous() ?? '/';
        return redirect()->intended($redirectTo);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dl = new DataLayer();
        try {
            $dl->removeFromCart($id, auth()->id());
        } catch (CartItemNotFoundException $e) {
            session()->flash('open_cart_offcanvas', true);
            return back()->withErrors(['cart_error' => $e->getMessage()]);
        }

        // Apri comunque l'offcanvas
        session()->flash('open_cart_offcanvas', true);

        $redirectTo = request()->input('redirect') ?? url()->previous() ?? '/';
        return redirect()->intended($redirectTo);
    }


}
