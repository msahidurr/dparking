(function ($) {
    "use strict";
    var userDataTable = null;
    $(document).ready(function () {
        userDataTable = $("#userDataTable").DataTable({
            dom: '<"ptb20"><"row"<"col-md-4 col-12"l><"#userDataTableSearch.col-md-4 col-12"><"col-md-4 col-12"f>>t<"row"<"col-md-6 col-12"i><"col-md-6 col-12"p>>',
            scrollX: true,
            initComplete: function () {
                $("#userDataTableSearch").append(
                    '<div class="dataTableBtnWrap flL">' +
                        '<select class="form-control" id="userDataTableFilterStatus">' +
                        '<option value="">All User</option>' +
                        '<option value="1">Active</option>' +
                        '<option value="0">Deactive</option>' +
                        "</select>" +
                        "</div>"
                );
            },
            processing: true,
            serverSide: true,
            columns: [
                {
                    data: "id",
                    name: "sl",
                    class: "no-sort",
                    render: function (data, type, row, ind) {
                        var pageInfo = userDataTable.page.info();
                        return ind.row + 1 + pageInfo.start;
                    },
                },
                {
                    data: "name",
                    name: "name",
                    render: function (data, type, row, index) {
                        return data;
                    },
                },
                {
                    data: "email",
                    name: "email",
                    render: function (data, type, row, index) {
                        return data;
                    },
                },
                {
                    data: "roles",
                    name: "roles",
                    render: function (data, type, row, index) {
                        var roleHTML = "";
                        for (let role of data) {
                            roleHTML += role.name.toUpperCase() + "<br>";
                        }

                        return roleHTML;
                    },
                },
                {
                    data: "status",
                    render: function (data, type, row) {
                        return data == 1 ? "Active" : "Deactive";
                    },
                },
                {
                    data: "id",
                    name: "id",
                    class: "text-end",
                    render: function (data, type, row, index) {
                        var $return = "";
                        var editURL = route("user.edit", { user: data });
                        var delURL = route("user.destroy", { user: data });
                        var statusURL = route("user.status", {
                            user: data,
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
                url: route("userListJson"),
                dataSrc: "data",
                data: function (d) {
                    d.status = $("#userDataTableFilterStatus").val();
                },
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
                    targets: [0, 2, 3, 4, 5],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });

    $(document).on("change", "#userDataTableFilterStatus", function () {
        userDataTable.draw();
    });
})(jQuery);
