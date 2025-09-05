<script>
    $(document).ready(function() {
        function updateTotalItems() {
            var total = 0;
            $('.card-text.qta').each(function() {
                var text = $(this).text().trim();
                var quantity = parseInt(text.split(' x ')[0]);
                total += quantity;
            });

            if (total <= 0) {
                $('#total-items').text("");
            } else {
                $('#total-items').text(total);
            }
        }

        function updateCartTotal() {
            var total = 0;
            $('.card-text.qta').each(function() {
                var text = $(this).text().trim();
                var quantity = parseInt(text.split(' x ')[0]);
                var price = parseFloat($(this).closest('.card-body').find('.prezzo-maglia').text());
                total += quantity * price;
            });

            total = total.toFixed(2);
            $('#cart-total').text('Totale: ' + total + '€');

            if (total == 0) {
                $('#btn-paga').addClass('disabled').attr('href', '');
            } else {
                $('#btn-paga').removeClass('disabled').attr('href', '{{ route('payment') }}');
            }
        }


        $('#modal_carrelloDelete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var itemId = button.data('id');


            $("#rm-btn").click(function() {


                $.ajax({
                    url: '/cart/' + itemId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {

                            $("#card-cart-" + itemId).remove()
                            updateCartTotal();
                            updateTotalItems();
                        }
                    }
                })
            });
        });



        $('#modal_carrelloRemoveOne').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var itemId = button.data('id');

            $("#rm-one-btn").off('click').on('click', function() {
                var qtaElement = $("#card-cart-" + itemId).find('.qta');
                var qtaAttuale = parseInt(qtaElement.text().split(' x ')[0]);

                $.ajax({
                    url: '/cart/' + itemId,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (qtaAttuale - 1 > 0) {
                                qtaElement.text((qtaAttuale - 1) + ' x ' +
                                    qtaElement.text().split(' x ')[1]);
                            } else {
                                $("#card-cart-" + itemId).remove();
                            }
                            updateCartTotal();
                            updateTotalItems();
                        }
                    }
                });
            });
        });


    });
</script>



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
                <div id="card-cart-{{ $singleItem->id }}" class="mb-4 col-8 offset-2">
                    <a href="{{ route('product.show', $singleItem->product->id) }}" class="text-decoration-none">
                        <div class="card">
                            <img src="{{ $singleItem->product->image_path ? asset($singleItem->product->image_path) : asset('img/products/null.png') }}"
                                class="foto-maglia mt-4" alt="..." />

                            <div class="card-body">
                                <h5 class="card-title nome-maglia">{{ $singleItem->product->brand->nome }} -
                                    {{ $singleItem->product->nome }}
                                </h5>
                                <div class="d-flex justify-content-end align-items-baseline">
                                    <p class="card-text prezzo-maglia">{{ $singleItem->product->prezzo }}</p>
                                    <p class="card-text qta offset-1">
                                        {{ $singleItem->quantity }} x {{ $singleItem->size->nome }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div class="d-flex justify-content-between w-100 gap-2">
                        <span class="col btn btn-warning my-2 btn-delete-item" data-bs-toggle="modal"
                            data-bs-target="#modal_carrelloRemoveOne" data-id="{{ $singleItem->id }}">
                            <i class="bi bi-dash-circle"></i>
                        </span>
                        <span class="col btn btn-red my-2 btn-delete-item" data-bs-toggle="modal"
                            data-bs-target="#modal_carrelloDelete" data-id="{{ $singleItem->id }}">
                            <i class="bi bi-trash"></i>
                        </span>
                    </div>
                </div>
            @endforeach
            @if ($errors->has('cart_error'))
                <div class="alert alert-danger" style="white-space: pre-line;">
                    {{ $errors->first('cart_error') }}
                </div>
            @endif

        </div>
    </div>
    <div class="offcanvas-footer sticky-bottom p-5 border-top">
        <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
            <div id="cart-total" class="btn btn-outline-dark disabled">
                @php
                    $sum = 0;
                    foreach (auth()->user()->cartItems()->get() as $singleItem) {
                        $sum += $singleItem->product->prezzo * $singleItem->quantity;
                    }
                @endphp
                Totale: {{ number_format($sum, 2) }}€
            </div>
            @if (auth()->user()->cartItems()->sum('quantity') < 1)
                <a id="btn-paga" href="" class="btn btn-success disabled"><i class="bi bi-bank"></i> Paga</a>
            @else
                <a id="btn-paga" href="{{ route('payment') }}" class="btn btn-success"><i class="bi bi-bank"></i>
                    Paga</a>
            @endif
        </div>
    </div>
</div>

<!-- Modal per cancellare elemento -->
<div class="modal fade " id="modal_carrelloDelete" tabindex="-1" aria-labelledby="modalCarrello" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCarrello">
                    Attenzione!
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler tutti questi elementi?
            </div>
            <div class="modal-footer">
                <button id="rm-btn" type="button" data-bs-dismiss="modal" class="btn btn-red">
                    <i class="bi bi-trash"></i> Si
                </button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-ban"></i>
                    No
                </button>
            </div>
        </div>
    </div>
</div>

{{-- REMOVE ONE --}}
<div class="modal fade " id="modal_carrelloRemoveOne" tabindex="-1" aria-labelledby="modalCarrello" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCarrello">
                    Attenzione!
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler rimuovere una quantità di questo elemento?
            </div>
            <div class="modal-footer">
                <button id="rm-one-btn" type="button" class="btn btn-warning" data-bs-dismiss="modal">
                    <i class="bi bi-dash-circle"></i> Si
                </button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-ban"></i>
                    No
                </button>



            </div>
        </div>
    </div>
</div>
