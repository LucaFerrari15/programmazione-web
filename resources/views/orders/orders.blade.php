@extends('layouts.master')

@section('title', 'I tuoi ordini | JerseyShop')

@section('my_script')
    <script src="{{ url('/') }}/js/ordersFilter.js"></script>
    <script src="{{ url('/') }}/js/paginationSearchFilter.js"></script>

@endsection

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
        $(document).ready(function() {





            $('#modal_popup_stato').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Bottone che apre il modal
                var orderId = button.data('id'); // Prendi l'id
                var status = button.data('status'); // Prendi lo stato
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
        <div class="col-10 offset-1 d-flex justify-content-between align-items-center mt-4">
            <div class="flex-grow-1 me-2" role="search">
                <input id="searchInput" class="form-control" type="search" placeholder="Cerca ordine..."
                    aria-label="Search" />

            </div>
            <!-- Bottone per aprire i filtri -->
            <button class="btn btn-red" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroOffcanvas"
                aria-controls="filtroOffcanvas">
                <i class="bi bi-funnel-fill"></i><span class="d-none d-lg-inline"> Filtri</span>
            </button>
        </div>

        <nav aria-label="Page navigation example" id="paginationNav" class="col-10 offset-1 mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item" id="previousPage"><a class="page-link" href="#">Previous</a></li>
                <!-- Numeri di pagina -->
                <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
                <li>
                    <select id="rowsPerPage" class="form-control justify-content-end">
                        <option value="5">5 orders per page</option>
                        <option value="10">10 orders per page</option>
                        <option value="15">15 orders per page</option>
                        <option value="20">20 orders per page</option>
                        <option value="25">25 orders per page</option>
                        <option value="30">30 orders per page</option>
                    </select>
                </li>
            </ul>
        </nav>


        <div class="row">
            <div class="col-10 offset-1 my-4">


                <div id="row-container" class="row g-3">
                    @foreach ($order_list as $order)
                        <div class="col-12 mb-3">
                            <div class="card cardSearch pagination-card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title searchable">Cod. Ordine: {{ $order->id }}</h5>
                                    @if (auth()->user()->role == 'admin')
                                        <p class="card-text searchable"><strong>Utente:</strong>
                                            {{ $order->user->name }}, {{ $order->user->email }}
                                        </p>
                                    @endif
                                    <p class="card-text searchable"><strong>Data:</strong>
                                        {{ $order->dataDiCreazioneOrdineFormattata() }}
                                    <p class="card-text searchable"><strong>Spedito a:</strong>
                                        {{ $order->nome_spedizione }} {{ $order->cognome_spedizione }}</p>
                                    <p class="card-text searchable"><strong>Indirizzo:</strong> {{ $order->via }}
                                        {{ $order->civico }}, {{ $order->cap }}, {{ $order->comune }},
                                        {{ $order->provincia }}, {{ $order->paese }}</p>
                                    <p class="card-text searchable"><strong>Stato:</strong> {{ $order->status }}</p>
                                    <p class="card-text searchable"><strong>Quantità:</strong>
                                        {{ $order->quantitaTotale() }}</p>
                                    <p class="card-text searchable"><strong>Totale:</strong> {{ $order->total }} €</p>

                                    <div class="d-flex justify-content-between mt-3">
                                        <a class="btn btn-success" href="{{ route('orders.show', $order->id) }}"><i
                                                class="bi bi-search"></i> Dettagli</a>

                                        @php
                                            $role = auth()->user()->role;
                                            $status = $order->status;
                                            $canReturn = $order->canReturn();

                                            if ($role != 'admin') {
                                                $btn = match ($status) {
                                                    'pending' => ['danger', 'In attesa reso', 'bi-cart-x', true],
                                                    'cancelled' => [
                                                        'secondary',
                                                        'Reso completato',
                                                        'bi-check2-circle',
                                                        true,
                                                    ],
                                                    'completed' => ['red', 'Reso', 'bi-cart-x', !$canReturn],
                                                    default => [
                                                        'secondary',
                                                        'In attesa',
                                                        'bi-fast-forward-fill',
                                                        true,
                                                    ],
                                                };
                                                if ($status == 'completed' && !$canReturn) {
                                                    $btn = [
                                                        'secondary',
                                                        'Operazione completata',
                                                        'bi-check2-circle',
                                                        true,
                                                    ];
                                                }
                                            } else {
                                                $btn = match ($status) {
                                                    'pending' => ['red', 'Accetta reso', 'bi-cart-x', false],
                                                    'cancelled', 'completed' => [
                                                        'secondary',
                                                        'Operazione completata',
                                                        'bi-check2-circle',
                                                        true,
                                                    ],
                                                    default => [
                                                        'primary',
                                                        'Aggiorna stato',
                                                        'bi-fast-forward-fill',
                                                        false,
                                                    ],
                                                };
                                            }
                                        @endphp

                                        <button class="btn btn-{{ $btn[0] }}"
                                            @unless ($btn[3]) data-bs-toggle="modal" data-bs-target="#modal_popup_stato" data-id="{{ $order->id }}" data-status="{{ $status }}" @endunless
                                            {{ $btn[3] ? 'disabled' : '' }}>
                                            <i class="bi {{ $btn[2] }}"></i> {{ $btn[1] }}
                                        </button>
                                    </div>
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




    <!-- OFFCANVAS FILTRI -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="filtroOffcanvas" aria-labelledby="filtroOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 id="filtroOffcanvasLabel">Filtri</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Chiudi"></button>
        </div>
        <div class="offcanvas-body">
            <h6>Ordina per</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="ordineOrdine" id="piuRecente" value="piuRecente"
                    checked />
                <label class="form-check-label" for="piuRecente">Più Recente</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="ordineOrdine" id="piuVecchio"
                    value="piuVecchio" />
                <label class="form-check-label" for="piuVecchio">Più Vecchio</label>
            </div>
            <hr>

            <h6>Stato ordine</h6>
            @foreach ($order_status as $status)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="status[]" id="status{{ $status }}"
                        value="{{ $status }}">
                    <label class="form-check-label" for="status{{ $status }}">{{ $status }}</label>
                </div>
            @endforeach

        </div>
    </div>
@endsection
