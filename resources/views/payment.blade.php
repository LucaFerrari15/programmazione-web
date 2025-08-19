@extends('layouts.master')

@section('title', 'F.A.Q | JerseyShop')

@section('active_faq', 'active')

@section('contenuto_principale')
    <div class="row mt-4">
        <div class="row">
            <div class="col-md-5 offset-md-1 my-2 my-md-5">
                <div class="row">
                    <form action="#" method="get">
                        <!-- SPEDIZIONE -->
                        <div class="row">
                            <h2 class="mb-4">Indirizzo di spedizione</h2>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome" placeholder="nome" required /><label
                                        for="">Nome</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cognome" placeholder="cognome"
                                        required /><label for="">Cognome</label>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="via" placeholder="via" required /><label
                                        for="">Via</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="numero_civico" placeholder="numero_civico"
                                        required /><label for="">Numero civico</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cap" placeholder="cap" required /><label
                                        for="">CAP</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="comune" placeholder="comune"
                                        required /><label for="">Comune</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="provincia" placeholder="provincia"
                                        required /><label for="">Provincia</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="paese" placeholder="paese" required /><label
                                        for="">Paese</label>
                                </div>
                            </div>
                        </div>

                        <!--PAGAMENTO-->
                        <div class="row">
                            <h2 class="mb-4">Estremi di pagamento</h2>
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="numero" placeholder="numero"
                                        required /><label for="">Numero</label>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="data" placeholder="data" required /><label
                                        for="">Data di scadenza</label>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cvv" placeholder="cvv" required /><label
                                        for="">CVV</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome_carta" placeholder="Nome"
                                        required /><label for="">Nome sulla carta di credito</label>
                                </div>
                            </div>
                        </div>
                        <!--FATTURAZIONE-->
                        <div>
                            <input type="checkbox" name="toggleFatturazione" id="" />
                            <label for="">L'indirizzo di fatturazione
                                <strong>non</strong> coincide con la
                                spedizione?
                            </label>
                        </div>

                        <div class="row d-none">
                            <h2 class="mb-4">Indirizzo di fatturazione</h2>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nome" placeholder="nome" required /><label
                                        for="">Nome</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cognome" placeholder="cognome"
                                        required /><label for="">Cognome</label>
                                </div>
                            </div>
                            <div class="col-md-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="via" placeholder="via" required /><label
                                        for="">Via</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="numero_civico" placeholder="numero_civico"
                                        required /><label for="">Numero civico</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="cap" placeholder="cap" required /><label
                                        for="">CAP</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="comune" placeholder="comune"
                                        required /><label for="">Comune</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="provincia" placeholder="provincia"
                                        required /><label for="">Provincia</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="paese" placeholder="paese" required /><label
                                        for="">Paese</label>
                                </div>
                            </div>
                        </div>
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
                            <li class="list-group-item d-flex justify-content-between align-items-top">
                                <p>Nike - LeBron James Home Jersey (M)</p>
                                <p>€109,90</p>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-top">
                                <p>
                                    Nike - Stephen Curry Statement Jersey
                                    (XL)
                                </p>
                                <p>€109,90</p>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-between fw-bold">
                            <p>Totale</p>
                            <p>€109,90</p>
                        </div>
                        <a href="#" class="btn btn-success w-100" data-bs-toggle="modal"
                            data-bs-target="#successoPagamento">
                            <i class="bi bi-bank"></i> Conferma Pagamento
                        </a>
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