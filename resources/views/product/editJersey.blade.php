@extends('layouts.master')

@if (isset($product))
    @section('title', "Edit - {$product->nome} | JerseyShop")
@else
    @section('title', 'Crea Nuova Maglia | JerseyShop')
@endif

@section('active_prodotti', 'active')

@section('breadcrumb')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-10 offset-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('product.products') }}">Prodotti</a></li>
                        @if (isset($product))
                            <li class="breadcrumb-item"><a
                                    href="{{ route('product.show', $product->id) }}">{{ $product->brand->nome }} -
                                    {{ $product->nome }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">Crea Nuova Maglia</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('contenuto_principale')
    <div class="row mt-4">
        <div class="col offset-1">
            @if (isset($product))
                <a class="btn btn-red" href="{{ route('product.show', $product->id) }}"><i class="bi bi-arrow-left"></i>
                    Torna
                    Indietro</a>
            @else
                <a class="btn btn-red" href="{{ route('product.products') }}"><i class="bi bi-arrow-left"></i>
                    Torna
                    Indietro</a>
            @endif
        </div>
    </div>

    <div class="col-10 offset-1 my-4">
        <div class="row">
            @if (isset($product))
                <form class="form-horizontal" name="jersey" method="post"
                    action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form class="form-horizontal" name="jersey" method="post" action="{{ route('product.store') }}"
                        enctype="multipart/form-data">
            @endif
            @csrf

            <div class="row">
                <div class="col-12 col-lg-6">
                    {{-- BRAND --}}
                    <div class="form-floating mb-2">
                        <select class="form-select" id="floatingSelectMarca" name="floatingSelectMarca">

                            @foreach ($list_brands as $brand)
                                @if (isset($product) && $product->brand->id == $brand->id)
                                    <option value="{{ $brand->id }}" selected="selected">{{ $brand->nome }}</option>
                                @else
                                    <option value="{{ $brand->id }}">{{ $brand->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="floatingSelectMarca">Marca</label>
                    </div>


                    {{-- NOME --}}
                    <div class="form-floating mb-2">
                        @if (isset($product))
                            <input class="form-control" type="text" name="nome_maglia" value="{{ $product->nome }}" />
                        @else
                            <input class="form-control" type="text" name="nome_maglia" />
                        @endif
                        <label for="nome_maglia">Nome maglia</label>
                    </div>


                    {{-- DESCRIZIONE --}}
                    <div class="form-floating mb-2">
                        @if (isset($product))
                            <textarea class="form-control h-auto" type="text" name="descrizione">{{ $product->descrizione }}</textarea>
                        @else
                            <textarea class="form-control" type="text" name="descrizione"></textarea>
                        @endif
                        <label for="nome_maglia">Descrizione</label>
                    </div>


                    {{-- SQUADRA --}}
                    <div class="form-floating mb-2">
                        <select class="form-select" id="floatingSelectTeam" name="floatingSelectTeam">

                            @foreach ($list_teams as $team)
                                @if (isset($product) && $product->team->id == $team->id)
                                    <option value="{{ $team->id }}" selected="selected">{{ $team->nome }}</option>
                                @else
                                    <option value="{{ $team->id }}">{{ $team->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="floatingSelectTeam">Squadra</label>
                    </div>


                    {{-- PREZZO --}}
                    <div class="form-floating mb-2">
                        @if (isset($product))
                            <input class="form-control" type="number" name="prezzo" value="{{ $product->prezzo }}"
                                step="0.01" min="0" />
                        @else
                            <input class="form-control" type="number" name="prezzo" step="0.01" min="0" />
                        @endif
                        <label for="prezzo">Prezzo in Euro</label>
                    </div>


                    {{-- TAGLIE --}}
                    <div class="d-flex flex-wrap">
                        @foreach ($list_sizes as $size)
                            <div class="form-floating mb-2 me-2 col-3 col-lg">
                                @if (isset($product))
                                    <input class="form-control" type="number" name="size-{{ $size->id }}"
                                        value="{{ $quantities[$size->id] ?? '' }}" min="0" />
                                @else
                                    <input class="form-control" type="number" name="size-{{ $size->id }}"
                                        min="0" value="0" />
                                @endif
                                <label for="nome_maglia">{{ $size->nome }}</label>
                            </div>
                        @endforeach
                    </div>


                    {{-- CARICAMENTO FOTO --}}
                    <div class="form-floating mb-2">


                        <input class="form-control" type="file" name="image_path" />
                        <label for="image_path">Immagine Maglia</label>
                    </div>
                </div>



                {{-- FOTO --}}
                <div class="col-12 offset-lg-1 col-lg-4">
                    <div class="mb-2">
                        @if (isset($product) && $product->image_path != null)
                            <img src="{{ asset($product->image_path) }}" class="card-img-top foto-maglia w-100 mt-4"
                                alt="..." />
                        @else
                            <img src="{{ asset('img/products/null.png') }}" class="card-img-top foto-maglia w-100 mt-4"
                                alt="..." />
                        @endif


                    </div>
                </div>
            </div>

            <!-- Bottone principale -->
            @if (isset($product))
                <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal"
                    data-bs-target="#confirmModal">
                    <i class="bi bi-pencil"></i> Modifica
                </button>
            @else
                <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal"
                    data-bs-target="#confirmModal">
                    <i class="bi bi-database"></i> Salva
                </button>
            @endif

            <!-- Modal di conferma -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">Conferma azione</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Chiudi"></button>
                        </div>
                        <div class="modal-body">
                            Sei sicuro di voler {{ isset($product) ? 'modificare' : 'salvare' }} questo prodotto?
                        </div>
                        <div class="modal-footer">
                            @if (isset($product))
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Conferma modifica
                                </button>
                            @else
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-database"></i> Conferma creazione
                                </button>
                            @endif

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i
                                    class="bi bi-ban"></i> No</button>
                        </div>
                    </div>
                </div>
            </div>



            </form>
        </div>

    </div>



@endsection
