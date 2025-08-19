<?php

namespace App\Http\Controllers;

use App\Models\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
        $dl->removeFromCart($id, auth()->id());

        // Prendo la request usando il helper globale
        $redirectTo = request()->input('redirect') ?? url()->previous() ?? '/';

        return redirect()->intended($redirectTo);
    }

}
