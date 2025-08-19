@extends('layouts.master')

@section('title', 'Prodotti | JerseyShop')

@section('active_prodotti', 'active')

@section('contenuto_principale')
    <script>
        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                var searchTerm = $(this).val().toLowerCase();

                $('.row > div.col-6, .row > div.col-lg-4, .row > div.col-xl-3').each(function () {
                    var productText = $(this).text().toLowerCase();

                    if (productText.indexOf(searchTerm) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>




    <div class="row">
        <div class="col-10 offset-1 my-4">
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="flex-grow-1 me-2" role="search">
                    <input id="searchInput" class="form-control" type="search" placeholder="Cerca prodotto..."
                        aria-label="Search" />

                </div>
                <!-- Bottone per aprire i filtri -->
                <button class="btn btn-red" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtroOffcanvas"
                    aria-controls="filtroOffcanvas">
                    <i class="bi bi-funnel-fill"></i><span class="d-none d-lg-inline"> Filtri</span>
                </button>
            </div>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filtroOffcanvas"
                aria-labelledby="filtroOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 id="filtroOffcanvasLabel">Filtri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Chiudi"></button>
                </div>
                <div class="offcanvas-body">

                    <!-- ORDINA PER -->
                    <h6>Ordina per</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordine" id="AZ" checked />
                        <label class="form-check-label" for="AZ">Nome (A-Z)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordine" id="ZA" />
                        <label class="form-check-label" for="ZA">Nome (Z-A)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordine" id="prezzo_crescente" />
                        <label class="form-check-label" for="prezzo_crescente">Prezzo crescente</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ordine" id="prezzo_decrescente" />
                        <label class="form-check-label" for="prezzo_decrescente">Prezzo decrescente</label>
                    </div>

                    <hr>

                    <!-- Squadre -->
                    <h6>Squadra</h6>
                    @foreach ($team_list as $team)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="teams[]" id="team_{{ $team->id }}"
                                value="{{ $team->id }}">
                            <label class="form-check-label" for="team_{{ $team->id }}">{{ $team->nome }}</label>
                        </div>
                    @endforeach

                    <hr>

                    <!-- Marche -->
                    <h6>Marca</h6>
                    @foreach ($brand_list as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="brands[]" id="brand_{{ $brand->id }}"
                                value="{{ $brand->id }}">
                            <label class="form-check-label" for="brand_{{ $brand->id }}">{{ $brand->nome }}</label>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="row">
                @foreach ($products_list as $product)
                    <div class="col-6 col-lg-4 col-xl-3 my-4">
                        <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none h-100">
                            <div class="card h-100 position-relative">

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

                                <div class="card-body {{ $opacity }}">
                                    <h5 class="card-title nome-maglia">{{ $product->brand->nome }} - {{ $product->nome }}
                                    </h5>
                                    <p class="card-text prezzo-maglia text-end">{{ $product->prezzo }} €</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection