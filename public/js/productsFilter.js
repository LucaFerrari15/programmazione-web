$(document).ready(function () {
    var $allCards = $(".cardSearch");

    function applyFiltersAndSort() {
        var selectedTeams = $('input[name="teams[]"]:checked')
            .map(function () {
                return this.value;
            })
            .get();
        var selectedBrands = $('input[name="brands[]"]:checked')
            .map(function () {
                return this.value;
            })
            .get();
        var sortOrder = $('input[name="ordine"]:checked').attr("id");

        var $filteredCards = $allCards.filter(function () {
            var $card = $(this);
            var cardTeamId = $card.data("team-id");
            var cardBrandId = $card.data("brand-id");

            var matchesTeam =
                selectedTeams.length === 0 ||
                selectedTeams.includes(String(cardTeamId));
            var matchesBrand =
                selectedBrands.length === 0 ||
                selectedBrands.includes(String(cardBrandId));

            return matchesTeam && matchesBrand;
        });

        $filteredCards.sort(function (a, b) {
            var aVal, bVal;
            if (sortOrder === "AZ") {
                aVal = $(a).find(".nome-maglia").text().toLowerCase();
                bVal = $(b).find(".nome-maglia").text().toLowerCase();
                return aVal.localeCompare(bVal);
            } else if (sortOrder === "ZA") {
                aVal = $(a).find(".nome-maglia").text().toLowerCase();
                bVal = $(b).find(".nome-maglia").text().toLowerCase();
                return bVal.localeCompare(aVal);
            } else if (sortOrder === "prezzo_crescente") {
                aVal = parseFloat(
                    $(a).find(".prezzo-maglia").text().replace(" €", "")
                );
                bVal = parseFloat(
                    $(b).find(".prezzo-maglia").text().replace(" €", "")
                );
                return aVal - bVal;
            } else if (sortOrder === "prezzo_decrescente") {
                aVal = parseFloat(
                    $(a).find(".prezzo-maglia").text().replace(" €", "")
                );
                bVal = parseFloat(
                    $(b).find(".prezzo-maglia").text().replace(" €", "")
                );
                return bVal - aVal;
            }
            return 0;
        });

        $(document).trigger("updateView", [$filteredCards]);
    }

    $('input[name="teams[]"], input[name="brands[]"], input[name="ordine"]').on(
        "change",
        function () {
            $(document).trigger("applyFiltersAndSort");
        }
    );

    $(document).on("applyFiltersAndSort", function () {
        applyFiltersAndSort();
    });

    applyFiltersAndSort();
});
