@extends('layouts.master')

@section('title', 'Prodotti | JerseyShop')

@section('my_script')
    <script src="{{ url('/') }}/js/productsFilter.js"></script>
    <script src="{{ url('/') }}/js/paginationSearchFilter.js"></script>

@endsection

@section('active_prodotti', 'active')


@section('breadcrumb')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-10 offset-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Prodotti</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('contenuto_principale')




    <div class="row">
        <div class="col-10 offset-1">
            @if (auth()->check() && auth()->user()->role == 'admin')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('product.create') }}" class="btn btn-success align-left">
                        <i class="bi bi-database"></i>
                        Crea Maglia
                    </a>
                </div>
            @endif
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





            <nav aria-label="Page navigation example" id="paginationNav" class="col-10 offset-1 mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item" id="previousPage"><a class="page-link" href="#">Previous</a></li>
                    <!-- Numeri di pagina -->
                    <li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>
                    <li>
                        <select id="rowsPerPage" class="form-control justify-content-end">
                            <option value="4">4 products per page</option>
                            <option value="8">8 products per page</option>
                            <option value="12">12 products per page</option>
                            <option value="16">16 products per page</option>
                        </select>
                    </li>
                </ul>
            </nav>




            <div id="row-container" class="row g-3 my-4">
                @foreach ($products_list as $product)
                    <div class="cardSearch col-12 col-md-6 col-lg-3 d-flex" data-team-id="{{ $product->team->id }}"
                        data-brand-id="{{ $product->brand->id }}">
                        <div class="card pagination-card equal-card position-relative w-100 shadow-sm d-flex flex-column">
                            <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none w-100 h-100">
                                {{-- gestione opacity --}}
                                @php $opacity = $product->soldOut() ? 'opacity-50' : ''; @endphp
                                @if ($product->soldOut())
                                    <div class="sold-out-overlay"></div>
                                @endif

                                {{-- immagine --}}
                                <img src="{{ $product->image_path ? asset($product->image_path) : asset('img/products/null.png') }}"
                                    class="card-img-top foto-maglia mt-4 {{ $opacity }}" alt="..." />



                                {{-- testo --}}
                                <div class="card-body {{ $opacity }}">
                                    <h5 class="card-title nome-maglia searchable">{{ $product->brand->nome }} -
                                        {{ $product->nome }}
                                    </h5>
                                    <p class="card-title nome-maglia searchable">{{ $product->team->nome }}
                                    </p>
                                    <p class="card-text prezzo-maglia text-end">{{ $product->prezzo }} €</p>
                                </div>


                            </a>
                        </div>
                    </div>
                @endforeach
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
@endsection
