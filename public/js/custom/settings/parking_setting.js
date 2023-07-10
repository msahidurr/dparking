(function ($) {
    "use strict";
    var parkingSetupDataTableEl = null;
    let $return;
    $(document).ready(function () {
        
        if(!$(document).find('input[name=id').length){
            $(document).find('#place_id').trigger('change');
        }

        parkingSetupDataTableEl = $("#parkingSlotDatatable").DataTable({
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
                        var pageInfo = parkingSetupDataTableEl.page.info();
                        return col.row + 1 + pageInfo.start;
                    },
                },
                {
                    class: "no-sort",
                    name: "category.type",
                    data: "category.type",
                },
                {
                    class: "no-sort",
                    name: "place.name",
                    data: "place.name",
                },
                {
                    class: "no-sort",
                    name: "floor.name",
                    data: "floor.name",
                },
                { name: "slot_name", data: "slot_name" },
                { name: "slotId", data: "slotId" },
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
                        var editURL = route("parking_settings.edit", {
                            parking_setting: data,
                        });
                        var delURL = route("parking_settings.destroy", {
                            parking_setting: data,
                        });
                        var statusURL = route(
                            "parking_settings.status_changes",
                            { parking_setting: data }
                        );
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
                            '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Parking Slot"></i></a>';

                        $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL + '\', \'#parkingSlotDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Parking Slot"></i></button>';

                        return $return;
                    },
                },
            ],

            ajax: {
                url: route("parking_settings.index"),
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
                    targets: [0, 1, 2, 5, 6, 7],
                },
            ],
            responsive: true,
            autoWidth: false,
            serverSide: true,
            processing: true,
        });
    });

    $(document).on('change', '#place_id', function(){
        let floor = floors.filter(val => val.place_id == $(this).val());
        let category = categories.filter(val => val.place_id == $(this).val());
        let html = '';
        $.each(floor, function(ind,val){
            html += `<option value="${val.id}">${val.name}</option>`;
        });
        
        $(document).find('#floor_id').html(html);
        
        html = '';
        $.each(category, function(ind,val){
            html += `<option value="${val.id}">${val.type}</option>`;
        });

        $(document).find('#category_id').html(html);
    });
})(jQuery);
