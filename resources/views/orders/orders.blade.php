@extends('layouts.master')

@section('title', 'I tuoi ordini | JerseyShop')

@section('active_utente', 'active')

@section('contenuto_principale')
    <script>
        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                var searchTerm = $(this).val().toLowerCase();

                // Filtro righe tabella (desktop)
                $('table tbody tr').each(function () {
                    var rowText = $(this).find('.searchable').text().toLowerCase();
                    $(this).toggle(rowText.indexOf(searchTerm) !== -1);
                });

                // Filtro card (mobile)
                $('.card').each(function () {
                    var cardText = $(this).find('.searchable').text().toLowerCase();
                    $(this).toggle(cardText.indexOf(searchTerm) !== -1);
                });
            });





            $('#modal_reso').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Bottone che apre il modal
                var orderId = button.data('id');     // Prendi l'id
                var form = $(this).find('#resoForm');
                form.attr('action', '/orders/' + orderId + '/reso');
            });
        });

    </script>



    <div class="my-4">
        <div class="row">
            <div class="col-10 offset-1 mt-4">
                <div role="search">
                    <input id="searchInput" class="form-control" type="search" placeholder="Cerca ordine..."
                        aria-label="Search" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-10 offset-1 my-4">

                {{-- Tabella desktop --}}
                <div class="d-none d-lg-block">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Cod. Ordine</th>
                                <th>Data di Acquisto</th>
                                <th>Spedito a</th>
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
                                    <td class="searchable">{{ $order->id }}</td>
                                    <td class="searchable">{{ $order->dataDiCreazioneOrdineFormattata() }}</td>
                                    <td class="searchable">{{ $order->nome_spedizione }} {{ $order->cognome_spedizione }}</td>
                                    <td class="searchable">{{ $order->via }} {{ $order->civico }}, {{ $order->cap }},
                                        {{ $order->comune }}, {{ $order->provincia }}, {{ $order->paese }}
                                    </td>
                                    <td class="searchable">{{ $order->status }}</td>
                                    <td class="searchable">{{ $order->quantitaTotale() }}</td>
                                    <td class="searchable">{{ $order->total }} €</td>
                                    <td><a class="btn btn-success" href="{{ route('orders.show', $order->id) }}"><i
                                                class="bi bi-search"></i> Dettagli</a></td>
                                    <td>
                                        @if (auth()->user()->role != 'admin')
                                            @if ($order->status == 'completed')
                                                <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#modal_reso"
                                                    data-id="{{ $order->id }}">
                                                    <i class="bi bi-cart-x"></i> Reso
                                                </button>
                                            @else
                                                <button class="btn btn-danger" disabled><i class="bi bi-cart-x"></i> Reso</button>
                                            @endif
                                        @else
                                            @if ($order->status == 'pending')
                                                <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#modal_reso"
                                                    data-id="{{ $order->id }}">
                                                    <i class="bi bi-cart-x"></i> Accetta reso
                                                </button>
                                            @else
                                                <button class="btn btn-danger" disabled><i class="bi bi-cart-x"></i> Accetta
                                                    reso</button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Card mobile --}}
                <div class="d-block d-lg-none">
                    @foreach ($order_list as $order)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title searchable">Cod. Ordine: {{ $order->id }}</h5>
                                <p class="card-text searchable"><strong>Data:</strong>
                                    {{ $order->dataDiCreazioneOrdineFormattata() }}</p>
                                <p class="card-text searchable"><strong>Spedito a:</strong> {{ $order->nome_spedizione }}
                                    {{ $order->cognome_spedizione }}
                                </p>
                                <p class="card-text searchable"><strong>Indirizzo di Spedizione:</strong> {{ $order->via }}
                                    {{ $order->civico }}, {{ $order->cap }}, {{ $order->comune }}, {{ $order->provincia }},
                                    {{ $order->paese }}
                                </p>
                                <p class="card-text searchable"><strong>Stato:</strong> {{ $order->status }}</p>
                                <p class="card-text searchable"><strong>Quantità:</strong> {{ $order->quantitaTotale() }}</p>
                                <p class="card-text searchable"><strong>Totale:</strong> {{ $order->total }} €</p>

                                <div class="d-flex justify-content-between mt-3">
                                    <a class="btn btn-success" href="{{ route('orders.show', $order->id) }}"><i
                                            class="bi bi-search"></i> Dettagli</a>
                                    @if (auth()->user()->role != 'admin')
                                        @if ($order->status == 'completed')
                                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#modal_reso"
                                                data-id="{{ $order->id }}">
                                                <i class="bi bi-cart-x"></i> Reso
                                            </button>
                                        @else
                                            <button class="btn btn-danger" disabled><i class="bi bi-cart-x"></i> Reso</button>
                                        @endif
                                    @else
                                        @if ($order->status == 'pending')
                                            <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#modal_reso"
                                                data-id="{{ $order->id }}">
                                                <i class="bi bi-cart-x"></i> Accetta reso
                                            </button>
                                        @else
                                            <button class="btn btn-danger" disabled><i class="bi bi-cart-x"></i> Accetta reso</button>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_reso" tabindex="-1" aria-labelledby="modalReso" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalReso">Attenzione!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ auth()->user()->role != 'admin' ? 'Sei sicuro di voler fare il reso di questo ordine?' : 'Accettare il reso di questo ordine?'}}
                    </div>
                    <div class="modal-footer">
                        <form id="resoForm" method="POST" action="">
                            @csrf
                            <button type="submit" class="btn btn-red"><i class="bi bi-cart-x"></i> Si</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-ban"></i>
                            No</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection