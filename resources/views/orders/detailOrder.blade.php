@extends('layouts.master')

@section('title', "Ordine N° {$order->id} | JerseyShop")

@section('active_utente', 'active')

@section('contenuto_principale')
    <div class="row mt-4">
        <div class="col offset-1">
            <a class="btn btn-red" href="{{ route('orders') }}"><i class="bi bi-arrow-left"></i> Torna
                Indietro</a>
        </div>
    </div>
    @if(isset($message_success))
        <div class="row mt-4">
            <div class="col offset-1">
                <div class="alert alert-success">
                    {{ $message_success }}
                </div>
            </div>
        </div>
    @endif
    <div class="row my-4">
        <div class="col-10 offset-1 mb-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-3 col-5 fw-bold">
                            Codice ordine:
                        </div>
                        <div class="col-md-9 col-7">
                            {{ $order->id }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 col-5 fw-bold">
                            Spedito a:
                        </div>
                        <div class="col-md-9 col-7">
                            {{ $order->nome_spedizione }} {{ $order->cognome_spedizione }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 col-5 fw-bold">
                            Indirizzo:
                        </div>
                        <div class="col-md-9 col-7">
                            {{ $order->via }} {{ $order->civico }},
                            {{ $order->cap }}, {{ $order->comune }}, {{ $order->provincia }}, {{ $order->paese }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 col-5 fw-bold">
                            Riepilogo:
                        </div>
                        <div class="col-md-9 col-7">
                            <ul class="list-group list-group-flush">
                                @foreach ($order->items()->get() as $singleItem)
                                                            <li class="p-0 list-group-item">
                                                                <p>{{$singleItem->product->brand->nome}} -
                                                                    {{$singleItem->product->nome}} - {{$singleItem->quantity}} x
                                                                    {{$singleItem->size->nome}} - <strong>{{number_format(
                                        $singleItem->product->prezzo * $singleItem->quantity,
                                        2
                                    )}} €</strong>
                                                                </p>
                                                            </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 col-5 fw-bold">
                            Totale:
                        </div>
                        <div class="col-md-9 col-7">
                            {{ $order->total }} €
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-3 col-5 fw-bold">
                            Stato:
                        </div>
                        <div class="col-md-9 col-7">
                            {{ $order->status }}
                        </div>
                    </div>

                </div>

                <div class="card-footer d-none d-flex flex-column flex-md-row justify-content-between">
                    <a class="btn btn-primary mb-2 mb-md-0 w-100 me-md-2" href="">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a class="btn btn-danger mb-2 mb-md-0 w-100 me-md-2" href="">
                        <i class="bi bi-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>



    </div>
@endsection