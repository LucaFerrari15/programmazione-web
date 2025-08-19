@extends('layouts.master')

@section('title', 'Home | JerseyShop')

@section('active_home', 'active')

@section('contenuto_principale')

    <div class="row"><!-- Cover Section -->
        <div class="hero container-fluid d-flex align-items-center justify-content-center text-center">
            <div class="row">
                <div class="col-10 offset-1 col-lg-12 offset-lg-0">
                    <h1 class="fw-bold">Magliette da Basket di Alta Qualità</h1>
                    <p class="lead">
                        Acquista le tue magliette da basket preferite.
                    </p>
                    <a href="{{ route('product.products') }}" class="btn btn-red text-white btn-lg">Scopri i nostri
                        prodotti</a>
                </div>
            </div>
        </div>

        <!-- Testimonial -->
        <div class="container-fluid text-center my-4">
            <h2 class="mb-4">Cosa Dicono i Nostri Clienti</h2>
            <div class="row">
                <div class="col-10 offset-1 col-md-3">
                    <figure class="text-center">
                        <blockquote class="blockquote">
                            <p>⭐️⭐️⭐️⭐️⭐️</p>
                            <p>
                                "Le magliette sono fantastiche! Qualità
                                eccellente e spedizione veloce."
                            </p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            John P.
                        </figcaption>
                    </figure>
                </div>
                <div class="col-10 offset-1 offset-md-0 col-md-4">
                    <figure class="text-center">
                        <blockquote class="blockquote">
                            <p>⭐️⭐️⭐️⭐️⭐️</p>
                            <p>
                                "Spedizione velocissima, ho ricevuto la
                                maglietta in 2 giorni!"
                            </p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            Tim C.
                        </figcaption>
                    </figure>
                </div>
                <div class="col-10 offset-1 offset-md-0 col-md-3">
                    <figure class="text-center">
                        <blockquote class="blockquote">
                            <p>⭐️⭐️⭐️⭐️⭐️</p>
                            <p>
                                "Prezzo giusto per una qualità superiore! Il
                                dettaglio delle stampe è perfetto."
                            </p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                            George F.
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>
@endsection