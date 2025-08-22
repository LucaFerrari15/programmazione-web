@extends('layouts.master')

@section('title', 'I tuoi ordini | JerseyShop')

@section('active_utente', 'active')

@section('contenuto_principale')
    <div class="my-4">

        <div class="row">
            <div class="col-10 offset-1 my-4">

                {{-- versione tabella su desktop --}}
                <div class="d-none d-md-block">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Cod. Ordine</th>
                                <th>Data di Acquisto</th>
                                <th>Indirizzo di Spedizione</th>
                                <th>Stato Ordine</th>
                                <th>Quantità</th>
                                <th>Totale</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_list as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->dataDiCreazioneOrdineFormattata() }}</td>
                                    <td>{{ $order->via }} {{ $order->civico }}, {{ $order->cap }}, {{ $order->comune }},
                                        {{ $order->provincia }}, {{ $order->paese }}
                                    </td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                    
                                    
                                    
                                    
                                    {{ $order->quantitaTotale() }}</td>
                                    <td>{{ $order->total }} €</td>
                                    <td><a class="btn btn-success" href="{{ route('orders.show', $order->id) }}"><i class=" bi
                                                                                            bi-search"></i>
                                            Dettagli</a></td>
                                    <td>
                                        @if ($order->status == 'completed')
                                            <a class="btn btn-red" href=""><i class="bi bi-cart-x"></i> Reso</a>
                                        @else
                                            <a class="btn btn-danger disabled" href=""><i class="bi bi-cart-x"></i> Reso</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- versione "card" su mobile --}}
                <div class="d-block d-md-none">
                    @foreach ($order_list as $order)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Cod. Ordine: {{ $order->id }}</h5>
                                <p class="card-text"><strong>Data:</strong> {{ $order->dataDiCreazioneOrdineFormattata() }}
                                </p>
                                <p class="card-text"><strong>Spedizione:</strong> {{ $order->via }} {{ $order->civico }},
                                    {{ $order->cap }}, {{ $order->comune }}, {{ $order->provincia }}, {{ $order->paese }}
                                </p>
                                <p class="card-text"><strong>Stato:</strong> {{ $order->status }}</p>
                                <p class="card-text"><strong>Quantità:</strong> {{ $order->quantitaTotale() }}</p>
                                <p class="card-text"><strong>Totale:</strong> {{ $order->total }} €</p>

                                <div class="d-flex justify-content-between mt-3">
                                    <a class="btn btn-success" href="{{ route('orders.show', $order->id) }}"><i
                                            class="bi bi-search"></i> Dettagli</a>
                                    @if ($order->status == 'completed')
                                        <a class="btn btn-red" href=""><i class="bi bi-cart-x"></i> Reso</a>
                                    @else
                                        <a class="btn btn-danger disabled" href=""><i class="bi bi-cart-x"></i> Reso</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
@endsection