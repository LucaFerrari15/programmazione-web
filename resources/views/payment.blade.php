@extends('layouts.master')

@section('title', 'Payment | JerseyShop')

@section('active_utente', 'active')

@section('breadcrumb')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-10 offset-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pagamento</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('contenuto_principale')

    <script>
        $(document).ready(function() {
            var cardRegexes = {
                amex: /^3[47][0-9]{13}$/,
                bcglobal: /^(6541|6556)[0-9]{12}$/,
                carteBlanche: /^389[0-9]{11}$/,
                dinersClub: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
                discover: /^(65[4-9][0-9]{13}|64[4-9][0-9]{13}|6011[0-9]{12}|(622(?:12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])[0-9]{10}))$/,
                instaPayment: /^63[7-9][0-9]{13}$/,
                jcb: /^(?:2131|1800|35\d{3})\d{11}$/,
                koreanLocal: /^9[0-9]{15}$/,
                laser: /^(6304|6706|6709|6771)[0-9]{12,15}$/,
                maestro: /^(5018|5020|5038|5893|6304|6759|6761|6762|6763)[0-9]{8,15}$/,
                mastercard: /^5[1-5][0-9]{14}$/,
                solo: /^((6334|6767)[0-9]{12}|(6334|6767)[0-9]{14}|(6334|6767)[0-9]{15})$/,
                switch: /^((4903|4905|4911|4936|6333|6759)[0-9]{12}|(4903|4905|4911|4936|6333|6759)[0-9]{14}|(4903|4905|4911|4936|6333|6759)[0-9]{15}|564182[0-9]{10}|564182[0-9]{12}|564182[0-9]{13}|633110[0-9]{10}|633110[0-9]{12}|633110[0-9]{13})$/,
                unionPay: /^(62[0-9]{14,17})$/,
                visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
                visaMaster: /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/
            };

            var regexCAP = /^\d{5}$/;
            var regexCVV = /^\d{3,4}$/;

            function isValidCard(number) {
                var number = number.replace(/[^\d]/g, ""); // rimuove spazi e trattini

                for (const [name, regex] of Object.entries(cardRegexes)) {
                    if (regex.test(number)) {
                        return true;
                    }
                }
                return false;
            }

            $("#payment-form").submit(function(event) {
                var error = false;

                var nome = $("#payment-form input[name='nome_spedizione']").val();
                var cognome = $("#payment-form input[name='cognome_spedizione']").val();
                var via = $("#payment-form input[name='via']").val();
                var civico = $("#payment-form input[name='civico']").val();
                var cap = $("#payment-form input[name='cap']").val();
                var comune = $("#payment-form input[name='comune']").val();
                var provincia = $("#payment-form input[name='provincia']").val();
                var paese = $("#payment-form input[name='paese']").val();
                var mese = $("#payment-form select[name='mese']").val();
                var anno = $("#payment-form select[name='anno']").val();
                var numero = $("#payment-form input[name='numero']").val();
                var cvv = $("#payment-form input[name='cvv']").val();
                var nome_carta = $("#payment-form input[name='nome_carta']").val();

                // VALIDAZIONE DATI SPEDIZIONE
                if (nome.trim() === "") {
                    error = true;
                    $("#invalid-nome").text("Il nome è obbligatorio.");
                    $("input[name='nome_spedizione']").focus();
                } else {
                    $("#invalid-nome").text("");
                }

                if (cognome.trim() === "") {
                    error = true;
                    $("#invalid-cognome").text("Il cognome è obbligatorio.");
                    if (!error) $("input[name='cognome_spedizione']").focus();
                } else {
                    $("#invalid-cognome").text("");
                }

                if (via.trim() === "") {
                    error = true;
                    $("#invalid-via").text("La via è obbligatoria.");
                    if (!error) $("input[name='via']").focus();
                } else {
                    $("#invalid-via").text("");
                }

                if (civico.trim() === "") {
                    error = true;
                    $("#invalid-civico").text("Il numero civico è obbligatorio.");
                    if (!error) $("input[name='civico']").focus();
                } else {
                    $("#invalid-civico").text("");
                }

                if (cap.trim() === "") {
                    error = true;
                    $("#invalid-cap").text("Il CAP è obbligatorio.");
                    if (!error) $("input[name='cap']").focus();
                } else if (!regexCAP.test(cap)) {
                    error = true;
                    $("#invalid-cap").text("Il CAP deve essere di 5 cifre.");
                    if (!error) $("input[name='cap']").focus();
                } else {
                    $("#invalid-cap").text("");
                }

                if (comune.trim() === "") {
                    error = true;
                    $("#invalid-comune").text("Il comune è obbligatorio.");
                    if (!error) $("input[name='comune']").focus();
                } else {
                    $("#invalid-comune").text("");
                }

                if (provincia.trim() === "") {
                    error = true;
                    $("#invalid-provincia").text("La provincia è obbligatoria.");
                    if (!error) $("input[name='provincia']").focus();
                } else {
                    $("#invalid-provincia").text("");
                }

                if (paese.trim() === "") {
                    error = true;
                    $("#invalid-paese").text("Il paese è obbligatorio.");
                    if (!error) $("input[name='paese']").focus();
                } else {
                    $("#invalid-paese").text("");
                }

                // VALIDAZIONE DATI PAGAMENTO
                if (numero.trim() === "") {
                    error = true;
                    $("#invalid-numero-carta").text("Il numero della carta è obbligatorio.");
                    if (!error) $("input[name='numero']").focus();
                } else if (!isValidCard(numero)) {
                    error = true;
                    $("#invalid-numero-carta").text("Il numero della carta non è valido.");
                    if (!error) $("input[name='numero']").focus();
                } else {
                    $("#invalid-numero-carta").text("");
                }

                // Validazione data scadenza
                var currentDate = new Date();
                var currentYear = currentDate.getFullYear();
                var currentMonth = currentDate.getMonth() + 1;

                if (parseInt(anno) < currentYear || (parseInt(anno) === currentYear && parseInt(mese) <
                        currentMonth)) {
                    error = true;
                    $("#invalid-data").text("La data di scadenza non può essere nel passato.");
                } else {
                    $("#invalid-data").text("");
                }

                if (cvv.trim() === "") {
                    error = true;
                    $("#invalid-cvv").text("Il CVV è obbligatorio.");
                    if (!error) $("input[name='cvv']").focus();
                } else if (!regexCVV.test(cvv)) {
                    error = true;
                    $("#invalid-cvv").text("Il CVV deve essere di 3 o 4 cifre.");
                    if (!error) $("input[name='cvv']").focus();
                } else {
                    $("#invalid-cvv").text("");
                }

                if (nome_carta.trim() === "") {
                    error = true;
                    $("#invalid-nome-carta").text("Il nome sulla carta è obbligatorio.");
                    if (!error) $("input[name='nome_carta']").focus();
                } else {
                    $("#invalid-nome-carta").text("");
                }

                // Se ci sono errori, previeni l'invio del form
                if (error) {
                    event.preventDefault();
                }
            });
        });
    </script>

    <div class="row">
        <div class="col-10 offset-1 col-md-5 offset-md-1 my-2 my-md-4">
            <div class="row">
                <form id="payment-form" method="POST" action="{{ route('orders.checkout') }}">
                    @csrf
                    <!-- SPEDIZIONE -->
                    <div class="row">
                        <h2 class="mb-4">Indirizzo di spedizione</h2>


                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nome" name="nome_spedizione"
                                    placeholder="nome" />
                                <label for="nome">Nome</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-nome"></span>

                        </div>


                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="cognome" name="cognome_spedizione"
                                    placeholder="cognome" />
                                <label for="cognome">Cognome</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-cognome"></span>

                        </div>


                        <div class="col-md-8 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="via" name="via"
                                    placeholder="via" />
                                <label for="via">Via</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-via"></span>

                        </div>


                        <div class="col-6 col-md-4 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="civico" name="civico"
                                    placeholder="numero_civico" />
                                <label for="civico">Civico</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-civico"></span>

                        </div>


                        <div class="col-6 col-md-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="cap" name="cap"
                                    placeholder="cap" />
                                <label for="cap">CAP</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-cap"></span>

                        </div>


                        <div class="col-md-9 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="comune" name="comune"
                                    placeholder="comune" />
                                <label for="comune">Comune</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-comune"></span>

                        </div>


                        <div class="col-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="provincia" name="provincia"
                                    placeholder="provincia" />
                                <label for="provincia">Provincia</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-provincia"></span>

                        </div>


                        <div class="col-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="paese" name="paese"
                                    placeholder="paese" />
                                <label for="paese">Paese</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-paese"></span>

                        </div>
                    </div>

                    <!-- PAGAMENTO -->
                    <div class="row">
                        <h2 class="mb-4">Estremi di pagamento</h2>

                        <!-- Numero carta -->

                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="numero" name="numero"
                                    placeholder="numero" />
                                <label for="numero">Numero (Visa o Mastercard)</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-numero-carta"></span>

                        </div>

                        <!-- Mese e anno -->

                        <div class="col-md-6 mb-3 ">
                            <div class="d-flex gap-2">
                                <!-- Mese -->
                                <div class="form-floating flex-grow-1">
                                    <select class="form-select" id="mese" name="mese">
                                        @foreach (range(1, 12) as $m)
                                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                                {{ old('mese', '06') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="mese">Mese</label>
                                </div>

                                <!-- Anno -->
                                <div class="form-floating flex-grow-1">
                                    <select class="form-select" id="anno" name="anno">
                                        @foreach (range(date('Y'), date('Y') + 10) as $a)
                                            <option value="{{ $a }}"
                                                {{ old('anno', '2030') == $a ? 'selected' : '' }}>
                                                {{ $a }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="anno">Anno</label>
                                </div>


                            </div>
                            <span class="invalid-input text-danger d-block w-100" id="invalid-data"></span>
                        </div>

                        <!-- CVV -->

                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="cvv" name="cvv"
                                    placeholder="CVV" />
                                <label for="cvv">CVV</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-cvv"></span>

                        </div>

                        <!-- Nome sulla carta -->

                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nome_carta" name="nome_carta"
                                    placeholder="Nome" />
                                <label for="nome_carta">Nome sulla carta di credito</label>
                            </div>
                            <span class="invalid-input text-danger d-block " id="invalid-nome-carta"></span>

                        </div>
                    </div>

                    <input id="mySubmitPagamento" class="d-none" type="submit" value="Pagamento">
                </form>

            </div>
        </div>
        <!--RIEPILOGO-->
        <div class="col-10 offset-1 col-md-4 my-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Riepilogo Ordine</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach (auth()->user()->cartItems()->get() as $singleItem)
                            <li class="list-group-item d-flex justify-content-between align-items-top">
                                <a href="{{ route('product.show', $singleItem->product->id) }}">
                                    <p>{{ $singleItem->product->brand->nome }} -
                                        {{ $singleItem->product->nome }} - {{ $singleItem->quantity }} x
                                        {{ $singleItem->size->nome }}
                                    </p>
                                </a>
                                <p>
                                    {{ number_format($singleItem->product->prezzo * $singleItem->quantity, 2) }}
                                    €
                                </p>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between fw-bold">
                        <p>Totale</p>
                        @php
                            $sum = 0;
                            foreach (auth()->user()->cartItems()->get() as $singleItem) {
                                $sum += $singleItem->product->prezzo * $singleItem->quantity;
                            }
                        @endphp
                        <p>{{ number_format($sum, 2) }} €</p>
                    </div>
                    <label for="mySubmitPagamento" class="btn btn-success w-100"><i class="bi bi-bank"></i> Conferma
                        Pagamento</label>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert mt-4 alert-danger text-pre-line">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>


@endsection
