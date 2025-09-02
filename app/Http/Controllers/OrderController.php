<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataLayer;
use App\Exceptions\ProductNotAvailableException;
use App\Exceptions\CartEmptyException;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

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
            // Dati spedizione
            'nome_spedizione' => ['required', 'string', 'max:255'],
            'cognome_spedizione' => ['required', 'string', 'max:255'],
            'via' => ['required', 'string', 'max:255'],
            'civico' => ['required', 'string', 'max:20'],
            'cap' => ['required', 'digits:5'],
            'comune' => ['required', 'string', 'max:255'],
            'provincia' => ['required', 'string', 'max:255'],
            'paese' => ['required', 'string', 'max:255'],

            // Dati pagamento
            'numero' => [
                'required',
                'digits_between:13,19',
                function ($attribute, $value, $fail) {
                    $number = preg_replace('/\D/', '', $value);
                    $regexes = [
                        'amex' => '/^3[47][0-9]{13}$/',
                        'bcglobal' => '/^(6541|6556)[0-9]{12}$/',
                        'carteBlanche' => '/^389[0-9]{11}$/',
                        'dinersClub' => '/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',
                        'discover' => '/^(65[4-9][0-9]{13}|64[4-9][0-9]{13}|6011[0-9]{12}|(622(?:12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[01][0-9]|92[0-5])[0-9]{10}))$/',
                        'instaPayment' => '/^63[7-9][0-9]{13}$/',
                        'jcb' => '/^(?:2131|1800|35\d{3})\d{11}$/',
                        'koreanLocal' => '/^9[0-9]{15}$/',
                        'laser' => '/^(6304|6706|6709|6771)[0-9]{12,15}$/',
                        'maestro' => '/^(5018|5020|5038|5893|6304|6759|6761|6762|6763)[0-9]{8,15}$/',
                        'mastercard' => '/^5[1-5][0-9]{14}$/',
                        'solo' => '/^((6334|6767)[0-9]{12,15})$/',
                        'switch' => '/^((4903|4905|4911|4936|6333|6759)[0-9]{12,15}|564182[0-9]{10,13}|633110[0-9]{10,13})$/',
                        'unionPay' => '/^(62[0-9]{14,17})$/',
                        'visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
                        'visaMaster' => '/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/'
                    ];
                    $valid = false;
                    foreach ($regexes as $regex) {
                        if (preg_match($regex, $number)) {
                            $valid = true;
                            break;
                        }
                    }
                    if (!$valid) {
                        $fail('Il numero della carta non è valido.');
                    }
                },
            ],
            'mese' => ['required', 'integer', 'between:1,12'],
            'anno' => ['required', 'integer', 'min:' . date('Y')],
            'cvv' => ['required', 'digits_between:3,4'],
            'nome_carta' => ['required', 'string', 'max:255'],
        ]);

        $currentYear = date('Y');
        $currentMonth = date('n');
        if ($request->anno == $currentYear && $request->mese < $currentMonth) {
            return back()->withErrors(['data' => 'La data di scadenza non può essere nel passato.']);
        }


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

            $twoWeeksAgo = Carbon::now()->subWeeks(2);

    
            if (auth()->user()->role != 'admin' && $order->updated_at >= $twoWeeksAgo) {
                $dl->changeOrderStatus($order->id, 'pending');
            }
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
