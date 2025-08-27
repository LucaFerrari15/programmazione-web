$(document).ready(function () {
    var currentPage = 1;
    var rowsPerPage = parseInt($("#rowsPerPage").val());
    var $rowContainer = $("#row-container");
    var $allCards = $(".cardSearch");
    var lastFilteredCards; // Questa variabile ora viene inizializzata in un secondo momento

    function hasFilterScript() {
        var events = $._data(document, "events");
        return (
            events &&
            events.applyFiltersAndSort &&
            events.applyFiltersAndSort.length > 0
        );
    }

    function updateView() {
        var searchText = $("#searchInput").val().toLowerCase().trim();
        var $searchFilteredCards = lastFilteredCards.filter(function () {
            return $(this)
                .find(".searchable")
                .text()
                .toLowerCase()
                .includes(searchText);
        });
        showPage(currentPage, $searchFilteredCards);
    }

    function showPage(page, cardsToShow) {
        var totalPages = Math.ceil(cardsToShow.length / rowsPerPage);
        currentPage = page;
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
        }

        $rowContainer.empty();
        cardsToShow
            .slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage)
            .appendTo($rowContainer);
        updatePaginationControls(cardsToShow.length, totalPages);
    }

    function updatePaginationControls(totalItems, totalPages) {
        $("#paginationNav").show();
        $(".page-item.pageNumber").remove();

        var startPage = Math.max(1, currentPage - 1);
        var endPage = Math.min(startPage + 2, totalPages);

        for (var i = startPage; i <= endPage; i++) {
            var $li = $("<li>", { class: "page-item pageNumber" });
            var $link = $("<a>", { class: "page-link", href: "#", text: i });
            if (i === currentPage) $li.addClass("active");
            $li.append($link).insertBefore("#nextPage");
        }
    }

    // Eventi
    $("#rowsPerPage").on("change", function () {
        rowsPerPage = parseInt($(this).val());
        currentPage = 1;
        updateView();
    });

    $("#previousPage").click(function (e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            updateView();
        }
    });

    $("#nextPage").click(function (e) {
        e.preventDefault();
        var totalPages = Math.ceil(lastFilteredCards.length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updateView();
        }
    });

    $(document).on("click", ".pageNumber", function (e) {
        e.preventDefault();
        currentPage = parseInt($(this).text());
        updateView();
    });

    $("#searchInput").on("keyup", function () {
        currentPage = 1;
        updateView();
    });

    // Questo evento viene gestito solo se uno script di filtri è presente
    $(document).on("updateView", function (e, filteredCards) {
        lastFilteredCards = filteredCards;
        updateView();
    });

    // Avvio iniziale, decide se delegare i filtri o agire da solo
    function initialize() {
        if (hasFilterScript()) {
            $(document).trigger("applyFiltersAndSort");
        } else {
            lastFilteredCards = $allCards;
            updateView();
        }
    }

    initialize();
});
