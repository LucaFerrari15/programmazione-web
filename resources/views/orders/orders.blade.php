@extends('layouts.master')

@section('title', 'I tuoi ordini | JerseyShop')

@section('active_utente', 'active')

@section('breadcrumb')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-10 offset-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ auth()->user()->name }}</li>
                        <li class="breadcrumb-item active" aria-current="page">Ordini</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

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





            $('#modal_popup_stato').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Bottone che apre il modal
                var orderId = button.data('id');     // Prendi l'id
                var status = button.data('status');  // Prendi lo stato
                var form = $(this).find('#statoForm');
                var modalBody = $(this).find('.modal-body');
                var submitBtn = form.find('button[type="submit"]');

                // Setto l'action dinamicamente
                form.attr('action', '/orders/' + orderId);

                // Cambia testo e colore in base allo stato
                switch (status) {
                    case 'pending':
                        modalBody.text('Accettare il reso di questo ordine?');
                        submitBtn
                            .removeClass()
                            .addClass('btn btn-red')
                            .html('<i class="bi bi-cart-x"></i> Accetta');
                        break;

                    case 'paid':
                        modalBody.text('Vuoi spedire questo ordine?');
                        submitBtn
                            .removeClass()
                            .addClass('btn btn-primary')
                            .html('<i class="bi bi-truck"></i> Spedisci');
                        break;

                    case 'shipped':
                        modalBody.text('Vuoi segnare questo ordine come completato?');
                        submitBtn
                            .removeClass()
                            .addClass('btn btn-success')
                            .html('<i class="bi bi-check-circle"></i> Completa');
                        break;

                    default:
                        modalBody.text('Sei sicuro di voler fare il reso di questo ordine?');
                        submitBtn
                            .removeClass()
                            .addClass('btn btn-red')
                            .html('<i class="bi bi-cart-x"></i> Reso');
                        break;
                }
            });

        });

    </script>



    <div class="">
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
                                        @php
                                            $role = auth()->user()->role;
                                            $status = $order->status;
                                            $canReturn = $order->canReturn(); // true/false

                                            if ($role != 'admin') {
                                                $btn = match($status) {
                                                    'pending'   => ['danger', 'In attesa reso', 'bi-cart-x', true],
                                                    'cancelled' => ['secondary', 'Reso completato', 'bi-check2-circle', true],
                                                    'completed' => ['red', 'Reso', 'bi-cart-x', !$canReturn],
                                                    default     => ['secondary', 'In attesa', 'bi-fast-forward-fill', true],
                                                };
                                                // Se non può fare il reso, override del bottone
                                                if ($status == 'completed' && !$canReturn) {
                                                    $btn = ['secondary', 'Operazione completata', 'bi-check2-circle', true];
                                                }
                                            } else {
                                                $btn = match($status) {
                                                    'pending'                => ['red', 'Accetta reso', 'bi-cart-x', false],
                                                    'cancelled', 'completed' => ['secondary', 'Operazione completata', 'bi-check2-circle', true],
                                                    default                  => ['primary', 'Aggiorna stato', 'bi-fast-forward-fill', false],
                                                };
                                            }
                                        @endphp

                                        <button class="btn btn-{{ $btn[0] }} w-100"
                                                @unless($btn[3]) data-bs-toggle="modal" data-bs-target="#modal_popup_stato"
                                                data-id="{{ $order->id }}" data-status="{{ $status }}" @endunless
                                                {{ $btn[3] ? 'disabled' : '' }}>
                                            <i class="bi {{ $btn[2] }}"></i> {{ $btn[1] }}
                                        </button>


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
                                        @php
                                            $role = auth()->user()->role;
                                            $status = $order->status;
                                            $canReturn = $order->canReturn(); // true/false

                                            if ($role != 'admin') {
                                                $btn = match($status) {
                                                    'pending'   => ['danger', 'In attesa reso', 'bi-cart-x', true],
                                                    'cancelled' => ['secondary', 'Reso completato', 'bi-check2-circle', true],
                                                    'completed' => ['red', 'Reso', 'bi-cart-x', !$canReturn],
                                                    default     => ['secondary', 'In attesa', 'bi-fast-forward-fill', true],
                                                };
                                                // Se non può fare il reso, override del bottone
                                                if ($status == 'completed' && !$canReturn) {
                                                    $btn = ['secondary', 'Operazione completata', 'bi-check2-circle', true];
                                                }
                                            } else {
                                                $btn = match($status) {
                                                    'pending'                => ['red', 'Accetta reso', 'bi-cart-x', false],
                                                    'cancelled', 'completed' => ['secondary', 'Operazione completata', 'bi-check2-circle', true],
                                                    default                  => ['primary', 'Aggiorna stato', 'bi-fast-forward-fill', false],
                                                };
                                            }
                                        @endphp

                                        <button class="btn btn-{{ $btn[0] }}"
                                                @unless($btn[3]) data-bs-toggle="modal" data-bs-target="#modal_popup_stato"
                                                data-id="{{ $order->id }}" data-status="{{ $status }}" @endunless
                                                {{ $btn[3] ? 'disabled' : '' }}>
                                            <i class="bi {{ $btn[2] }}"></i> {{ $btn[1] }}
                                        </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_popup_stato" tabindex="-1" aria-labelledby="modalPopPupStato" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalPopPupStato">Attenzione!</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <form id="statoForm" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <button type="submit" class=""></button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-ban"></i>
                            No</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection