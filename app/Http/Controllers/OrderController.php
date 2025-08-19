<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;

class OrderController extends Controller
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

        $dl = new DataLayer();


        $request->validate([
            'nome_spedizione' => 'required|string',
            'cognome_spedizione' => 'required|string',
            'via' => 'required|string',
            'civico' => 'required|string',
            'cap' => 'required|string',
            'comune' => 'required|string',
            'provincia' => 'required|string',
            'paese' => 'required|string',
            // campi pagamento (solo validazione fittizia)
            'numero' => 'required|digits_between:13,19',
            'mese' => 'required',
            'anno' => 'required',
            'cvv' => 'required|digits_between:3,4',
            'nome_carta' => 'required|string',
        ]);


        $orderData = $request->only([
            'nome_spedizione',
            'cognome_spedizione',
            'via',
            'civico',
            'cap',
            'comune',
            'provincia',
            'paese'
        ]);


        if ($dl->createOrderFromCart(auth()->user()->id, $orderData) == null) {
            return view('faq');
        }


        return view('index');
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
        //
    }


}
