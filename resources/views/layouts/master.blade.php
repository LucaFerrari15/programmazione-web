<!DOCTYPE html>
<html lang="it">

<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

    <link rel="icon" href="{{ url('/') }}/img/favicon.ico" type="image/x-icon">

    <!-- Fogli di stile -->
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.min.css">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">

    <!-- jQuery e plugin JavaScript  -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>

    @yield('my_script')

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="d-flex flex-column min-vh-100">

    @if (auth()->check())
        <x-carrello></x-carrello>
    @endif



    @if (session('open_cart_offcanvas'))
        <script>
            $(document).ready(function() {
                var cartOffcanvasEl = $('#offcanvasCarrello')[0];
                var cartOffcanvas = new bootstrap.Offcanvas(cartOffcanvasEl);
                cartOffcanvas.show();
            });
        </script>
    @endif




    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid col-10 offset-1 bg-dark">
            <a class="navbar-brand col-lg-2 mx-0" href="{{ route('home') }}">🏀 JerseyShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse col-lg-10" id="navbarNav">
                <ul class="navbar-nav col-lg-6 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link @yield('active_home')" href="{{ route('home') }}"><i class="bi bi-house"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('active_prodotti')" href="{{ route('product.products') }}"><i
                                class="bi bi-shop"></i> Prodotti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('active_faq')" href="{{ route('faq') }}"><i
                                class="bi bi-question-circle"></i>
                            F.A.Q.</a>
                    </li>
                </ul>
                <ul class="navbar-nav col-lg-6 justify-content-end">
                    @if (auth()->check())
                        <!-- Bottone per aprire il modal logout -->
                        <li class="nav-item dropdown">
                            <button class="dropdown-toggle nav-link @yield('active_utente')" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('orders') }}"><i class="bi bi-box-seam"></i>
                                        {{ auth()->user()->role != 'admin' ? ' I miei ordini' : ' Storico ordini' }}
                                    </a></li>
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

                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-person-circle"></i> Login
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <div class="position-relative d-inline-block">
                            @if (auth()->check())
                                @if (auth()->user()->role != 'admin')
                                    <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasCarrello" aria-controls="offcanvasCarrello">
                                        <i class="bi bi-cart"></i> Carrello
                                    </button>
                                    @if (auth()->user()->cartItems()->count() > 0)
                                        <span id="total-items"
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ auth()->user()->cartItems()->sum('quantity') }}
                                        </span>
                                    @endif
                                @endif
                            @else
                                <a class="btn btn-outline-light" href="{{ route('login') }}"><i class="bi bi-cart"></i>
                                    Carrello</a>
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
                            <button type="submit" class="btn btn-red"><i class="bi bi-box-arrow-left"></i>
                                Logout</button>
                        </form>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="bi bi-ban"></i>
                            Annulla</button>



                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Breadcrumb -->
    @yield('breadcrumb')



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
                        <a href="tel:+393485997687" class="text-white mb-2 text-decoration-none">Tel:
                            +39 348 599
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
