(function ($) {
    "use strict";
    let placeDataTableEl = null;
    let $return;
    $(document).ready(function () {
        placeDataTableEl = $("#placeDataTable").DataTable({
            dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"t><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
            lengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "All"],
            ],
            buttons: [],
            columns: [
                {
                    data: "id",
                    class: "no-sort",
                    width: "50px",
                    render: function (data, row, type, col) {
                        var pageInfo = placeDataTableEl.page.info();
                        return col.row + 1 + pageInfo.start;
                    },
                },
                { name: "db_id", data: "id" },
                { name: "name", data: "name" },
                { name: "description", data: "description" },
                {
                    name: "status",
                    data: "status",
                    render: function (data, type, row) {
                        return data == 1 ? "Active" : "Inactive";
                    },
                },
                {
                    data: "id",
                    class: "text-end width-5-per",
                    render: function (data, type, row, col) {
                        var editURL = route("places.edit", { place: data });
                        var delURL = route("places.destroy", { place: data });
                        var statusURL = route("places.status_changes", {
                            place: data,
                        });
                        if (row.status == 1) {
                            $return =
                                '<a href="' +
                                statusURL +
                                '"><i class="fa fa-window-close-o text-danger" aria-hidden="true" title="Deactivate"></i></a> | ';
                        } else {
                            $return =
                                '<a href="' +
                                statusURL +
                                '"><i class="fa fa-check text-info" aria-hidden="true" title="Active"></i></a> | ';
                        }
                        $return +=
                            '<a href="' +
                            editURL +
                            '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Place"></i></a>';

                        $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#placeDataTable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Place"></i></button>';

                        return $return;
                    },
                },
            ],

            ajax: {
                url: route("places.index"),
                dataSrc: "data",
            },

            language: {
                paginate: {
                    next: "&#8594;", // or '→'
                    previous: "&#8592;", // or '←'
                },
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: [0, 1, 3, 4, 5],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });
})(jQuery);
