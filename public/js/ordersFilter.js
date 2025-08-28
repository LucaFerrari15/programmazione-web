$(document).ready(function () {
    // La classe da usare per la selezione delle card è .card, come da HTML
    var $allCards = $(".cardSearch");

    function applyFiltersAndSort() {
        var selectedStatus = $('input[name="status[]"]:checked')
            .map(function () {
                return this.value;
            })
            .get();

        var sortOrder = $('input[name="ordineOrdine"]:checked').val();

        var $filteredCards = $allCards.filter(function () {
            var $card = $(this);
            var cardStatusText = $card
                .find(".card-text.searchable:contains('Stato')")
                .text();
            var cardStatus = cardStatusText
                .substring(cardStatusText.indexOf(":") + 1)
                .trim();

            if (selectedStatus.length === 0) {
                return true;
            }

            return selectedStatus.includes(cardStatus);
        });

        // Logica di ordinamento
        $filteredCards.sort(function (a, b) {
            var aId = parseInt(
                $(a)
                    .find(".card-title.searchable")
                    .text()
                    .replace("Cod. Ordine: ", "")
            );
            var bId = parseInt(
                $(b)
                    .find(".card-title.searchable")
                    .text()
                    .replace("Cod. Ordine: ", "")
            );

            if (sortOrder === "piuRecente") {
                return bId - aId;
            } else if (sortOrder === "piuVecchio") {
                return aId - bId;
            }
            return bId - aId; // Default: ordina per ID più alto
        });

        // L'evento 'updateView' viene triggerato passando le card filtrate e ordinate
        $(document).trigger("updateView", [$filteredCards]);
    }

    // Eventi di ascolto per i filtri e l'ordinamento
    $('input[name="status[]"], input[name="ordineOrdine"]').on(
        "change",
        function () {
            // Ogni volta che un filtro o un'opzione di ordinamento cambia, riapplica tutto
            $(document).trigger("applyFiltersAndSort");
        }
    );

    $(document).on("applyFiltersAndSort", function () {
        applyFiltersAndSort();
    });

    // Avvio iniziale
    applyFiltersAndSort();
});
