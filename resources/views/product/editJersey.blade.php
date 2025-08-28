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
    <script>
        $(document).ready(function() {
            $("input[name='image_path']").on("change", function() {
                var foto = this.files[0];
                if (foto) {
                    var allowedTypes = ['image/jpeg', 'image/png'];
                    if ($.inArray(foto.type, allowedTypes) !== -1) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(".foto-maglia").attr("src", e.target.result);
                        };
                        reader.readAsDataURL(foto);
                    } else {
                        $("#invalid-foto").text("Tipo di file non valido. Seleziona un file JPG o PNG.");
                        $(this).val(""); // reset input file
                    }
                }
            });

            function validateForm() {
                var error = false;
                var numericRegex = /^-?\d+(\.\d+)?$/;
                var intRegex = /^\d+$/;

                var brand = $("#jersey-form select[name='floatingSelectMarca']").val();
                var nome = $("#jersey-form input[name='nome_maglia']").val();
                var descrizione = $("#jersey-form textarea[name='descrizione']").val();
                var team = $("#jersey-form select[name='floatingSelectTeam']").val();
                var prezzo = $("#jersey-form input[name='prezzo']").val();

                var quantita_taglie = {};
                $("#jersey-form input[name^='size-']").each(function() {
                    var inputName = $(this).attr('name');
                    var sizeId = inputName.split('-')[1];
                    var quantita = $(this).val();
                    quantita_taglie[sizeId] = quantita;
                });

                var foto = $("#jersey-form input[name='image_path']")[0].files[0];

                // BRAND
                if (!brand || brand.trim() === "") {
                    error = true;
                    $("#invalid-brand").text("La marca è obbligatoria.");
                    $("select[name='floatingSelectMarca']").focus();
                } else {
                    $("#invalid-brand").text("");
                }

                // NOME
                if (!nome || nome.trim() === "") {
                    error = true;
                    $("#invalid-nome").text("Il nome è obbligatorio.");
                    $("input[name='nome_maglia']").focus();
                } else {
                    $("#invalid-nome").text("");
                }

                // DESCRIZIONE
                if (!descrizione || descrizione.trim() === "") {
                    error = true;
                    $("#invalid-descrizione").text("La descrizione è obbligatoria.");
                    $("textarea[name='descrizione']").focus();
                } else {
                    $("#invalid-descrizione").text("");
                }

                // TEAM
                if (!team || team.trim() === "") {
                    error = true;
                    $("#invalid-team").text("La squadra è obbligatoria.");
                    $("select[name='floatingSelectTeam']").focus();
                } else {
                    $("#invalid-team").text("");
                }

                // PREZZO
                if (!prezzo || prezzo.trim() === "") {
                    error = true;
                    $("#invalid-prezzo").text("Il prezzo è obbligatorio.");
                    $("input[name='prezzo']").focus();
                } else if (!numericRegex.test(prezzo)) {
                    error = true;
                    $("#invalid-prezzo").text("Il prezzo deve essere un numero.");
                    $("input[name='prezzo']").focus();
                } else {
                    $("#invalid-prezzo").text("");
                }

                // TAGLIE
                var errorTaglie = false;
                for (var sizeId in quantita_taglie) {
                    if (quantita_taglie[sizeId].trim() === "" || !intRegex.test(quantita_taglie[sizeId])) {
                        error = true;
                        errorTaglie = true;
                        $("#invalid-taglie").text("Le taglie devono essere un intero maggiore o uguale a 0.");
                        $("input[name='size-" + sizeId + "']").focus();
                    }
                }
                if (!errorTaglie) {
                    $("#invalid-taglie").text("");
                }

                // FOTO
                if (foto) {
                    var allowedTypes = ['image/jpeg', 'image/png'];
                    if ($.inArray(foto.type, allowedTypes) === -1) {
                        error = true;
                        $("#invalid-foto").text("Tipo di file non valido. Seleziona un file JPG o PNG.");
                        $("input[name='image_path']").focus();
                    } else {
                        $("#invalid-foto").text("");
                    }
                } else {
                    $("#invalid-foto").text("");
                }

                return !error;
            }

            // intercetto il click su "Conferma"
            $("#confirmModal button[type='submit']").on('click', function(e) {
                e.preventDefault(); // blocca invio immediato

                if (validateForm()) {
                    // se è valido --> invia il form
                    $("#jersey-form").off('submit').submit();
                } else {
                    // se NON valido --> chiudo modale
                    $("#confirmModal").modal('hide');
                }
            });
        });
    </script>







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
                <form class="form-horizontal" id="jersey-form" name="jersey" method="post"
                    action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form class="form-horizontal" id="jersey-form" name="jersey" method="post"
                        action="{{ route('product.store') }}" enctype="multipart/form-data">
            @endif
            @csrf

            <div class="row">
                <div class="col-12 col-lg-6">
                    {{-- BRAND --}}
                    <span class="invalid-input text-danger d-block" id="invalid-brand"></span>
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
                    <span class="invalid-input text-danger d-block" id="invalid-nome"></span>
                    <div class="form-floating mb-2">
                        @if (isset($product))
                            <input class="form-control" type="text" name="nome_maglia" value="{{ $product->nome }}" />
                        @else
                            <input class="form-control" type="text" name="nome_maglia" />
                        @endif
                        <label for="nome_maglia">Nome maglia</label>
                    </div>


                    {{-- DESCRIZIONE --}}
                    <span class="invalid-input text-danger d-block" id="invalid-descrizione"></span>
                    <div class="form-floating mb-2">
                        @if (isset($product))
                            <textarea class="form-control h-auto" type="text" name="descrizione">{{ $product->descrizione }}</textarea>
                        @else
                            <textarea class="form-control" type="text" name="descrizione"></textarea>
                        @endif
                        <label for="nome_maglia">Descrizione</label>
                    </div>


                    {{-- SQUADRA --}}
                    <span class="invalid-input text-danger d-block" id="invalid-team"></span>
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
                    <span class="invalid-input text-danger d-block" id="invalid-prezzo"></span>
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
                    <span class="invalid-input text-danger d-block" id="invalid-taglie"></span>
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
                    <span class="invalid-input text-danger d-block" id="invalid-foto"></span>
                    <div class="form-floating mb-2">


                        <input class="form-control" type="file" name="image_path" accept=".jpg, .png" />
                        <label for="image_path">Immagine Maglia (JPG o PNG)</label>
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
