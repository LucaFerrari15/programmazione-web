@extends('layouts.master')

@section('title', 'F.A.Q | JerseyShop')

@section('active_faq', 'active')

@section('breadcrumb')



    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-10 offset-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">F.A.Q.</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('contenuto_principale')
    <script>
        $(document).ready(function() {
            $("#faq-form").submit(function(e) {
                var nome = $("input[name='nome']").val().trim();
                var email = $("input[name='email']").val().trim();
                var oggetto = $("input[name='oggetto']").val().trim();
                var messaggio = $("textarea[name='messaggio']").val().trim();

                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (nome === "") {
                    e.preventDefault();
                    $("input[name='nome']").focus();
                    $("#invalid-nome").text("Inserire un nome valido");
                } else {
                    $("#invalid-nome").text("");
                }


                if (email === "" || !emailRegex.test(email)) {
                    e.preventDefault();
                    $("input[name='email']").focus();
                    $("#invalid-mail").text("Inserire una mail valida");
                } else {
                    $("#invalid-mail").text("");
                }

                if (oggetto === "") {
                    e.preventDefault();
                    $("input[name='oggetto']").focus();
                    $("#invalid-oggetto").text("Inserire un oggetto valido");
                } else {
                    $("#invalid-oggetto").text("");
                }


                if (messaggio === "") {
                    e.preventDefault();
                    $("textarea[name='messaggio']").focus();
                    $("#invalid-messaggio").text("Inserire un messaggio valido");
                } else {
                    $("#invalid-messaggio").text("");
                }

            });
        });
    </script>


    <div class="row">
        <div class="col-10 offset-1">
            <h2 class="mb-4 text-center">Domande Frequenti</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                            Quali taglie sono disponibili per le maglie da basket?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" aria-labelledby="faq1-heading"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Offriamo taglie dalla XS alla XXL.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            Le maglie sono originali o repliche?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2-heading"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Le nostre maglie sono repliche ufficiali con licenza. Mantengono l'estetica e la qualità delle
                            originali, ma a un prezzo accessibile.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            Quanto tempo ci vuole per la spedizione?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3-heading"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            La spedizione standard impiega 3-5 giorni lavorativi.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq4-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                            Quanto tempo ho per fare un reso?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faq4-heading"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Hai tempo fino a 2 settimane dalla ricezione del tuo ordine per effettuare il reso.
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-5">
                <h2 class="mb-4 text-center">Hai ancora domande?</h2>
                <form id="faq-form" action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="nome" placeholder="Nome">
                                <label>Nome e Cognome</label>
                            </div>
                            <div class="text-danger" id="invalid-nome"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <div class="form-floating flex-grow-1">
                                    <input type="email" class="form-control" name="email" placeholder="tua@email.com">
                                    <label>Email</label>
                                </div>
                            </div>
                            <div class="text-danger" id="invalid-mail"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="oggetto"
                                    placeholder="Oggetto della tua domanda">
                                <label>Oggetto</label>
                            </div>
                            <div class="text-danger" id="invalid-oggetto"></div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control" name="messaggio" rows="5" placeholder="Scrivi qui il tuo messaggio..."></textarea>
                                <label>Messaggio</label>
                            </div>
                            <div class="text-danger" id="invalid-messaggio"></div>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-red">
                                <i class="bi bi-send-fill"></i> Invia
                            </button>
                        </div>

                    </div>
                </form>


                {{-- Messaggi di conferma/errore --}}
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $errore)
                                <li>{{ $errore }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
