@extends('layouts.master')

@section('title', 'Authentication | JerseyShop')

@section('contenuto_principale')
    <script>
        // Si assicura che il codice JQuery venga eseguito solo dopo che il documento è pronto
        $(document).ready(function () {
            // Gestione della visibilità dei tab all'avvio
            $("#login-tab").show();
            $("#register-tab").hide();

            // Quando si clicca su "Non sei registrato?", nasconde il form di login e mostra quello di registrazione
            $("#show-register").click(function () {
                $("#login-tab").hide();
                $("#register-tab").show();
            });

            // Quando si clicca su "Sei già registrato?", nasconde il form di registrazione e mostra quello di login
            $("#show-login").click(function () {
                $("#register-tab").hide();
                $("#login-tab").show();
            });
        });
    </script>

    <div class="row mt-4">
        <div class="col-10 offset-1 col-md-6 offset-md-3 mt-4">

            <!-- LOGIN FORM -->
            <div id="login-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"><i class="bi bi-door-open"></i> Login</h4>
                    </div>
                    <div class="card-body">
                        <form id="login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-floating mb-2">
                                <input type="email" name="email" class="form-control" id="login_email" placeholder="Email"
                                    autofocus>
                                <label for="login_email">E-Mail</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="login_password"
                                    placeholder="Password">
                                <label for="login_password">Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-door-open"></i> Accedi
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">
                            <span role="button" class="text-primary" id="show-register">
                                Non sei registrato?
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- REGISTRATION FORM -->
            <div id="register-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"><i class="bi bi-person-plus-fill"></i> Registrazione</h4>
                    </div>
                    <div class="card-body">
                        <form id="register-form" action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="form-floating mb-2">
                                <input type="text" name="name" class="form-control" id="nome_registrazione"
                                    placeholder="Nome">
                                <label for="nome_registrazione">Nome</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="email" name="email" class="form-control" id="email_registrazione"
                                    placeholder="Email">
                                <label for="email_registrazione">E-Mail</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="password_registrazione"
                                    placeholder="Password">
                                <label for="password_registrazione">Password</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" placeholder="Conferma Password">
                                <label for="password_confirmation">Conferma Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-person-plus-fill"></i> Registrati
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">
                            <span role="button" class="text-primary" id="show-login">
                                Sei già registrato?
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection