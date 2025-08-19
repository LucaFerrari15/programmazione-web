@extends('layouts.master')

@section('title', 'F.A.Q | JerseyShop')

@section('active_faq', 'active')

@section('contenuto_principale')
    <div class="row mt-4">
        <div class="row">
            <div class="col-md-5 offset-md-1 my-2 my-md-5">
                <div class="row">
                    <form method="POST" action="{{ route('orders.checkout') }}">
                        @csrf
                        <!-- SPEDIZIONE -->
                        <div class="row">
                            <h2 class="mb-4">Indirizzo di spedizione</h2>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome" name="nome_spedizione"
                                        placeholder="nome" required />
                                    <label for="nome">Nome</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cognome" name="cognome_spedizione"
                                        placeholder="cognome" required />
                                    <label for="cognome">Cognome</label>
                                </div>
                            </div>

                            <div class="col-md-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="via" name="via" placeholder="via"
                                        required />
                                    <label for="via">Via</label>
                                </div>
                            </div>

                            <div class="col-6 col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="civico" name="civico"
                                        placeholder="numero_civico" required />
                                    <label for="civico">Numero civico</label>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cap" name="cap" placeholder="cap"
                                        required />
                                    <label for="cap">CAP</label>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="comune" name="comune" placeholder="comune"
                                        required />
                                    <label for="comune">Comune</label>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="provincia" name="provincia"
                                        placeholder="provincia" required />
                                    <label for="provincia">Provincia</label>
                                </div>
                            </div>

                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="paese" name="paese" placeholder="paese"
                                        required />
                                    <label for="paese">Paese</label>
                                </div>
                            </div>
                        </div>

                        <!-- PAGAMENTO -->
                        <div class="row">
                            <h2 class="mb-4">Estremi di pagamento</h2>

                            <!-- Numero carta -->
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="numero" name="numero" placeholder="numero"
                                        required pattern="\d{13,19}" maxlength="19" minlength="13"
                                        title="Inserisci un numero di carta valido (13-19 cifre)" />
                                    <label for="numero">Numero</label>
                                </div>
                            </div>

                            <!-- Mese e anno -->
                            <div class="col-6 mb-3 d-flex gap-2">
                                <!-- Mese -->
                                <div class="form-floating flex-grow-1">
                                    <select class="form-select" id="mese" name="mese" required>
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ old('mese', '06') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="mese">Mese</label>
                                </div>

                                <!-- Anno -->
                                <div class="form-floating flex-grow-1">
                                    <select class="form-select" id="anno" name="anno" required>
                                        @foreach(range(date('Y'), date('Y') + 10) as $a)
                                            <option value="{{ $a }}" {{ old('anno', '2030') == $a ? 'selected' : '' }}>
                                                {{ $a }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="anno">Anno</label>
                                </div>
                            </div>

                            <!-- CVV -->
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" required
                                        pattern="\d{3,4}" maxlength="4" minlength="3"
                                        title="Inserisci un CVV valido (3 o 4 cifre)" />
                                    <label for="cvv">CVV</label>
                                </div>
                            </div>

                            <!-- Nome sulla carta -->
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome_carta" name="nome_carta"
                                        placeholder="Nome" required />
                                    <label for="nome_carta">Nome sulla carta di credito</label>
                                </div>
                            </div>
                        </div>

                        <input id="mySubmitPagamento" class="d-none" type="submit" value="Pagamento">
                    </form>

                </div>
            </div>
            <!--RIEPILOGO-->
            <div class="col col-md-4 offset-md-1 my-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Riepilogo Ordine</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach (auth()->user()->cartItems()->get() as $singleItem)
                                <li class="list-group-item d-flex justify-content-between align-items-top">
                                    <p>{{$singleItem->product->brand->nome}} -
                                        {{$singleItem->product->nome}} - {{$singleItem->quantity}} x {{$singleItem->size->nome}}
                                    </p>
                                    <p>{{$singleItem->product->prezzo}} €</p>
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
                            <p>{{number_format($sum, 2)}} €</p>
                        </div>
                        <label for="mySubmitPagamento" class="btn btn-success w-100"><i class="bi bi-bank"></i> Conferma
                            Pagamento</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pagamento confermato -->
    <div class="modal fade " id="successoPagamento" tabindex="-1" aria-labelledby="successoPagamentoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body align-text-center">
                    <h4>
                        <i class="bi bi-check-all"></i> Pagamento avvenuto
                        con successo!
                    </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection