<!DOCTYPE html>
<html lang="it">

<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

    <!-- Fogli di stile -->
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.min.css">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">

    <!-- jQuery e plugin JavaScript  -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="d-flex flex-column min-vh-100">
    <script>
        $(document).ready(function () {
            $('#modal_carrello').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // bottone che ha triggerato il modal
                var itemId = button.data('id'); // prendi id

                var form = $('#deleteForm');
                form.attr('action', '/card/' + itemId);
            });
        });
    </script>




    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid col-10 offset-1 bg-dark">
            <a class="navbar-brand col-lg-2 mx-0" href="{{route('home')}}">🏀 JerseyShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse col-lg-10" id="navbarNav">
                <ul class="navbar-nav col-lg-6 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link @yield('active_home')" href="{{route('home')}}"><i class="bi bi-house"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('active_prodotti')" href="{{route('product.products')}}"><i
                                class="bi bi-shop"></i> Prodotti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('active_faq')" href="{{route('faq')}}"><i
                                class="bi bi-question-circle"></i>
                            F.A.Q.</a>
                    </li>
                </ul>
                <ul class="navbar-nav col-lg-6 justify-content-end">
                    @if (auth()->check())
                        <!-- Bottone per aprire il modal logout -->
                        <li class="nav-item dropdown">
                            <button class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-box-seam"></i> I miei ordini</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-heart"></i> I miei preferiti</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <i class="bi bi-box-arrow-left"></i> Logout
                                    </button></li>
                            </ul>

                        </li>
                    @else
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="modal" data-bs-target="#login">
                                <i class="bi bi-person-circle"></i> Login
                            </button>
                        </li>
                    @endif

                    <li class="nav-item">
                        <div class="position-relative d-inline-block">
                            <button class="btn btn-outline-light" type="button"
                                data-bs-toggle="{{ auth()->check() ? 'offcanvas' : 'modal' }}"
                                data-bs-target="{{ auth()->check() ? '#offcanvasCarrello' : '#login' }}"
                                aria-controls="offcanvasCarrello">
                                <i class="bi bi-cart"></i> Carrello
                            </button>
                            @if (auth()->check() && auth()->user()->cartItems()->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->cartItems()->sum('quantity') }}
                                </span>
                            @endif
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </nav>



    @if (auth()->check())
        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Conferma Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler uscire?
                    </div>
                    <div class="modal-footer">
                        <!-- Form per fare logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-red"><i class="bi bi-box-arrow-left"></i> Logout</button>
                        </form>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-ban"></i>
                            Annulla</button>



                    </div>
                </div>
            </div>
        </div>

        <!-- Offcanvas carrello -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrello" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">
                    Carrello
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row">
                    @foreach (auth()->user()->cartItems()->get() as $singleItem)
                        <div class="mb-4 col-8 offset-2">
                            <a href="" class="text-decoration-none">
                                <div class="card">
                                    <img src="{{ asset('storage/' . ($singleItem->product->image_path ?? 'immagini_prodotti/logo senza sfondo.png')) }}"
                                        alt="{{ $singleItem->product->nome }}" class="foto-maglia mt-4">

                                    <div class="card-body">
                                        <h5 class="card-title nome-maglia">{{$singleItem->product->brand->nome}} -
                                            {{$singleItem->product->nome}}
                                        </h5>
                                        <div class="d-flex justify-content-end align-items-baseline">
                                            <p class="card-text prezzo-maglia">{{$singleItem->product->prezzo}}</p>
                                            <p class="card-text offset-1">
                                                {{$singleItem->quantity}} x {{$singleItem->size->nome}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <span class="btn btn-red my-2 w-100 btn-delete-item" data-bs-toggle="modal"
                                data-bs-target="#modal_carrello" data-id="{{ $singleItem->id }}">
                                <i class="bi bi-trash"></i>
                            </span>

                        </div>
                    @endforeach

                </div>
            </div>
            <div class="offcanvas-footer sticky-bottom p-5 border-top">
                <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
                    <div class="btn btn-outline-dark disabled">
                        @php
                            $sum = 0;
                            foreach (auth()->user()->cartItems()->get() as $singleItem) {
                                $sum += $singleItem->product->prezzo * $singleItem->quantity;
                            }
                        @endphp
                        Totale: {{number_format($sum, 2)}}€
                    </div>
                    <a href="{{route('payment')}}" class="btn btn-success"><i class="bi bi-bank"></i> Paga</a>
                </div>
            </div>
        </div>

        <!-- Modal per cancellare elemento -->
        <div class="modal fade " id="modal_carrello" tabindex="-1" aria-labelledby="modalCarrello" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalCarrello">
                            Attenzione!
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare questo elemento?
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" method="POST" action="">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-red">
                                <i class="bi bi-trash"></i> Si
                            </button>
                        </form>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-ban"></i>
                            No
                        </button>



                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Modal per il login -->
        <div class="modal fade" id="login" tabindex="-1" aria-labelledby="modalLogin" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLogin">Login</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-floating">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                    required autofocus>
                                <label for="email">E-Mail</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" name="password" class="form-control my-2" id="password"
                                    placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-door-open"></i> Accedi
                            </button>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <p role="button" class="c-red" data-bs-toggle="modal" data-bs-target="#registrazione">
                            Non sei registrato?
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal per la registrazione -->
        <div class="modal fade " id="registrazione" tabindex="-1" aria-labelledby="modalRegistrazione" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalRegistrazione">
                            Registrazione
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-floating">
                                <input type="text" name="name" class="form-control" id="nome_registrazione"
                                    placeholder="Nome" required>
                                <label for="nome_registrazione">Nome</label>
                            </div>

                            <div class="form-floating">
                                <input type="email" name="email" class="form-control" id="email_registrazione"
                                    placeholder="Email" required>
                                <label for="email_registrazione">E-Mail</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" name="password" class="form-control mt-2" id="password_registrazione"
                                    placeholder="Password" required>
                                <label for="password_registrazione">Password</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" name="password_confirmation" class="form-control my-2"
                                    id="conferma_password" placeholder="Conferma Password" required>
                                <label for="conferma_password">Conferma Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus-fill"></i> Registrati
                            </button>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <p role="button" class="c-red" data-bs-toggle="modal" data-bs-target="#login">
                            Sei registrato?
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif




    <!-- Contenuto principale -->
    <div class="container-fluid flex-grow-1">
        @yield('contenuto_principale')
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3 mt-auto" id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-7 offset-1">
                    <p>Via San Zeno, 116 - 25124 Brescia</p>
                    <p>
                        <a href="tel:+393485997687" class="text-white mb-2 text-decoration-none">Tel: +39 348 599
                            7687</a>
                    </p>
                    <p>
                        <a href="mailto:ferrariluca2002@gmail.com" class="text-white text-decoration-none">Email:
                            ferrariluca2002@gmail.com</a>
                    </p>
                </div>
                <div class="col-3 text-end">
                    <p>
                        &copy; 2025 JerseyShop - Tutti i diritti riservati
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>