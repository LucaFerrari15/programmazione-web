<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use App\Exceptions\ProductNotAvailableException;
use App\Exceptions\CartEmptyException;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dl = new DataLayer();
        $orderStatus = $dl->getOrderStatus();
        if (auth()->user()->role != 'admin')
            $ordersList = $dl->listOrders(auth()->user()->id);
        else
            $ordersList = $dl->listAllOrders();
        return view('orders.orders')->with('order_list', $ordersList)->with('order_status', $orderStatus);
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

        try {
            $order = $dl->createOrderFromCart(auth()->user()->id, $orderData);
        } catch (ProductNotAvailableException $e) {
            return back()->withErrors(['cart_error' => $e->getMessage()]);
        } catch (CartEmptyException $e) {
            return back()->withErrors(["Il carrello è vuoto!"]);
        }


        return view('orders.detailOrder')->with('order', $order)->with('message_success', "Acquisto avvenuto con successo");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $dl = new DataLayer();



        if (auth()->user()->role != 'admin')
            $order = $dl->findOrderByIdAndUser($id, auth()->user()->id);
        else
            $order = $dl->findOrderById($id);

        if ($order != null) {
            return view('orders.detailOrder')->with('order', $order);
        } else {
            return view('errors.wrongID');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dl = new DataLayer();


        if (auth()->user()->role != 'admin')
            $order = $dl->findOrderByIdAndUser($id, auth()->user()->id);
        else
            $order = $dl->findOrderById($id);



        if ($order != null) {

            if (auth()->user()->role != 'admin')
                $dl->changeOrderStatus($order->id, 'pending');
            else {
                switch ($order->status) {
                    case 'pending':
                        $dl->changeOrderStatus($order->id, 'cancelled');
                        break;
                    case 'paid':
                        $dl->changeOrderStatus($order->id, 'shipped');
                        break;
                    case 'shipped':
                        $dl->changeOrderStatus($order->id, 'completed');
                        break;
                }
            }

            return Redirect::to(route('orders'));
        } else {
            return view('errors.wrongID');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function ajaxCheckForOrders(Request $request)
    {
        $dl = new DataLayer();

        if ($dl->$dl->findOrderByTerm($request->input('term'))) {
            $response = array('found' => true);
        } else {
            $response = array('found' => false);
        }
        return response()->json($response);
    }
}
