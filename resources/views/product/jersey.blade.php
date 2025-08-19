@extends('layouts.master')

@section('title', 'Prodotti | JerseyShop')

@section('active_prodotti', 'active')

@section('contenuto_principale')
    <script>
        $(document).ready(function () {
            $('#add-to-cart-form-{{ $product->id }}').submit(function (e) {
                if (!$('input[name="size_id"]:checked').length) {
                    e.preventDefault();
                    $('#size-error').text('Seleziona una taglia prima di aggiungere al carrello!').show();
                } else {
                    $('#size-error').hide();
                }
            });
        });
    </script>





    <div class="row mt-4">
        <div class="col offset-1">
            <a class="btn btn-red" href="{{ route('product.products') }}"><i class="bi bi-box-arrow-left"></i> Torna
                Indietro</a>
        </div>
    </div>
    <div class="row">
        <div class="col-10 col-lg-5 offset-1 my-4">
            <div class=" h-100 position-relative">

                @php
                    $opacity = "";
                @endphp

                @if ($product->soldOut())
                    @php
                        $opacity = "opacity-50";
                    @endphp
                    <div class="sold-out-overlay"></div>
                @endif



                @if (!$product->image_path)
                    <img src="{{ asset('storage/immagini_prodotti/logo senza sfondo.png') }}"
                        class="card-img-top foto-maglia w-100 mt-4 {{ $opacity }}" alt="..." />
                @else
                    <img src="{{ asset('storage/' . $product->image_path) }}"
                        class="card-img-top foto-maglia w-100 mt-4 {{ $opacity }}" alt="..." />
                @endif
            </div>
        </div>
        <div class="col-10 offset-1 col-lg-5 offset-lg-0 my-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        {{$product->brand->nome}} - {{$product->nome}}
                    </h5>
                    <p class="card-text">
                        {{$product->descrizione}}
                    </p>
                    <form id="add-to-cart-form-{{ $product->id }}" action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="btn-group" role="group" aria-label="Seleziona taglia">
                            @foreach ($product->sizes as $size)
                                @if ($size->pivot->quantita == 0)
                                    <input type="radio" class="btn-check" name="size_id" id="size_{{ $size->id }}"
                                        value="{{ $size->id }}" autocomplete="off" disabled>
                                    <label class="btn btn-outline-secondary" for="size_{{ $size->id }}">{{ $size->nome }}</label>
                                @else
                                    <input type="radio" class="btn-check" name="size_id" id="size_{{ $size->id }}"
                                        value="{{ $size->id }}" autocomplete="off">
                                    <label class="btn btn-outline-dark" for="size_{{ $size->id }}">{{ $size->nome }}</label>
                                @endif
                            @endforeach
                        </div>

                        <div class="text-end mt-2">
                            @if (!$product->soldOut())
                                @if(auth()->check())
                                    <div id="size-error" class="c-red mb-2"></div>

                                    <button id="add-to-cart-btn-{{ $product->id }}" type="submit" class="btn btn-red">
                                        <i class="bi bi-cart-plus-fill"></i> Aggiungi al carrello
                                    </button>



                                @else
                                    <button type="button" class="btn btn-red" data-bs-toggle="modal" data-bs-target="#login">
                                        <i class="bi bi-cart-plus-fill"></i>
                                        Aggiungi al carrello
                                    </button>
                                @endif
                                <p class="mt-2">{{ $product->prezzo }} €</p>
                            @else
                                <button type="button" class="btn btn-red">
                                    <i class="bi bi-bell-fill"></i> Avvisami quando torna disponibile
                                </button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection