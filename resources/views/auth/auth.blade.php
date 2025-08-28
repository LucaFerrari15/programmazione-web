@extends('layouts.master')

@section('title', 'Authentication | JerseyShop')

@section('contenuto_principale')
    <script>
        $(document).ready(function() {
            // Gestione della visibilità dei tab all'avvio
            $("#login-tab").show();
            $("#register-tab").hide();

            $("#show-register").click(function() {
                $("#login-tab").hide();
                $("#register-tab").show();
            });

            $("#show-login").click(function() {
                $("#register-tab").hide();
                $("#login-tab").show();
            });

            $("#login-form").submit(function(event) {
                // Ottenere i valori dei campi email e password
                var email = $("#login-form input[name='email']").val();
                var password = $("#login-form input[name='password']").val();
                var error = false;
                // Verifica se il campo "password" è vuoto
                if (password.trim() === "") {
                    error = true;
                    $("#invalid-password").text("La password è obbligatoria.");
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("#login-form input[name='password']").focus();
                } else {
                    $("#invalid-password").text("");
                }

                // Verifica se il campo "email" è vuoto
                if (email.trim() === "") {
                    error = true;
                    $("#invalid-email").text("L'indirizzo email è obbligatorio.");
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("#login-form input[name='email']").focus();
                } else {
                    $("#invalid-email").text("");
                }
            });

            $("#register-form").submit(function(event) {
                // Ottenere i valori dei campi per la registrazione
                var name = $("input[name='name']").val();
                var email = $("#register-form input[name='email']").val();
                var password = $("#register-form input[name='password']").val();
                // Espressione regolare per la password (almeno 8 caratteri, almeno una cifra, almeno
                // un carattere speciale tra ! - * [ ] $ & /)
                var passwordRegex = /^(?=.*[0-9])(?=.*[!-\*\[\]\$&\/]).{8,}$/;
                var confirmPassword = $("input[name='password_confirmation']").val();
                var error = false;

                // Verifica se il campo "confirm-password" è vuoto
                if (confirmPassword.trim() === "") {
                    error = true;
                    $("#invalid-confirmPassword").text("La re-immissione della password è obbligatoria.");
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("input[name='password_confirmation']").focus();
                } else {
                    $("#invalid-confirmPassword").text("");
                }

                // Verifica se il campo "password" è vuoto
                if (password.trim() === "") {
                    error = true;
                    $("#invalid-registrationPassword").text("La password è obbligatoria.");
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("#register-form input[name='password']").focus();
                } else if (!passwordRegex.test(password)) {
                    error = true;
                    $("#invalid-registrationPassword").text(
                        "Il formato della password è sbagliato (almeno 8 caratteri, di cui almeno una cifra e un carattere tra ! * [ ] $ & /)."
                    );
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("#register-form input[name='password']").focus();
                } else {
                    $("#invalid-registrationPassword").text("");
                }

                // Verifica se il campo "email" è vuoto
                if (email.trim() === "") {
                    error = true;
                    $("#invalid-registrationEmail").text("L'indirizzo email è obbligatorio.");
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("#register-form input[name='email']").focus();
                } else {
                    $("#invalid-registrationEmail").text("");
                }

                // Verifica se il campo "name" è vuoto
                if (name.trim() === "") {
                    error = true;
                    $("#invalid-name").text("Il nome è obbligatorio.");
                    event.preventDefault(); // Impedisce l'invio del modulo
                    $("input[name='name']").focus();
                } else {
                    $("#invalid-name").text("");
                }

                if (!error) {
                    // Verifica che la password sia state editata due volte correttamente
                    if (confirmPassword.trim() !== password.trim()) {
                        $("#invalid-confirmPassword").text("Immettere la stessa password due volte.");
                        event.preventDefault(); // Impedisce l'invio del modulo
                        $("input[name='password_confirmation']").focus();
                    } else {
                        $("#invalid-confirmPassword").text("");
                    }

                    // effettua chiamata AJAX per verificare che l'email dell'utente non sia già presente nel DB
                    event
                        .preventDefault(); // Impedisce preventivamente l'invio del modulo prima del controllo
                    $.ajax({

                        type: 'GET',

                        url: '/ajaxUser',

                        data: {
                            email: email.trim()
                        },

                        success: function(data) {

                            if (data.found) {
                                error = true;
                                $("#invalid-registrationEmail").text(
                                    "L'email esiste già nel database.");
                            } else {
                                $("#register-form")[0].submit();
                            }
                        }
                    });
                }
            });
        });
    </script>

    <div class="row mt-4">
        <div class="col-10 offset-1 col-md-6 offset-md-3 mt-4">

            <div id="login-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"><i class="bi bi-door-open"></i> Login</h4>
                    </div>
                    <div class="card-body">
                        <form id="login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <span class="invalid-input text-danger d-block" id="invalid-email"></span>
                            <div class="form-floating mb-2">
                                <input type="email" name="email" class="form-control" id="login_email"
                                    placeholder="Email" autofocus>
                                <label for="login_email">E-Mail</label>
                            </div>

                            <span class="invalid-input text-danger d-block" id="invalid-password"></span>
                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="login_password"
                                    placeholder="Password">
                                <label for="login_password">Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">
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

            <div id="register-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"><i class="bi bi-person-plus-fill"></i> Registrazione</h4>
                    </div>
                    <div class="card-body">
                        <form id="register-form" action="{{ route('register') }}" method="post">
                            @csrf
                            <span class="invalid-input text-danger d-block" id="invalid-name"></span>
                            <div class="form-floating mb-2">
                                <input type="text" name="name" class="form-control" id="nome_registrazione"
                                    placeholder="Nome">
                                <label for="nome_registrazione">Nome</label>
                            </div>

                            <span class="invalid-input text-danger d-block" id="invalid-registrationEmail"></span>
                            <div class="form-floating mb-2">
                                <input type="email" name="email" class="form-control" id="email_registrazione"
                                    placeholder="Email">
                                <label for="email_registrazione">E-Mail</label>
                            </div>

                            <span class="invalid-input text-danger d-block" id="invalid-registrationPassword"></span>
                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="password_registrazione"
                                    placeholder="Password">
                                <label for="password_registrazione">Password</label>
                            </div>

                            <span class="invalid-input text-danger d-block" id="invalid-confirmPassword"></span>
                            <div class="form-floating mb-2">
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" placeholder="Conferma Password">
                                <label for="password_confirmation">Conferma Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">
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
