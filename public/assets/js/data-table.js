$(function () {
    "use strict";
    initDataTable();
});

let datatableIds = ["#dataTableExample", "#dataTableExample2", "#dataTableExample3", "#dataTableExample4", "#dataTableExample5"];

function initDataTable() {
    datatableIds.forEach(function (id) {
        $(id).DataTable({
            aLengthMenu: [
                [10, 30, 50, -1],
                [10, 30, 50, "All"],
            ],
            iDisplayLength: 10,
            language: {
                search: "",
            },
        });
        $(id).each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
            search_input.attr("placeholder", "Search");
            search_input.attr("tabindex", "-1");
            //remove focus
            //off autocomplete
            search_input.attr("autocomplete", "off");

            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });
    });
}
