@extends('layouts.app')
@section('title', ' - '.__('application.rfid_vehicles.list'))
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.rfid_vehicles.list') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.rfid_vehicles.create') }}">{{ __('application.rfid_vehicles.create_new') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="parkingRfidDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.rfid_vehicles.place')}}</th>
                                    <th>{{__('application.rfid_vehicles.category')}}</th>
                                    <th>{{__('application.rfid_vehicles.vehicle_no')}}</th>
                                    <th>{{__('application.rfid_vehicles.rfid_no')}}</th>
                                    <th>{{__('application.rfid_vehicles.driver_name')}}</th>
                                    <th>{{__('application.rfid_vehicles.driver_mobile')}}</th>
                                    <th>{{__('application.rfid_vehicles.status')}}</th>
                                    <th>{{__('application.table.option')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{--  <script src="{{ assetz('js/custom/settings/parking_setting_rfid_vehicle.js') }}"></script>  --}}
    <script>
        (function ($) {
            "use strict";
            var parkingRFIDDataTableEl = null;
            let $return;
            $(document).ready(function () {       
        
                parkingRFIDDataTableEl = $("#parkingRfidDatatable").DataTable({
                    dom: '<"row"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>><"row"<"col-12 col-sm-12"t><"col-12 col-sm-6"i><"col-12 col-sm-6"p>>',
                    lengthMenu: [
                        [10, 50, 100, 200, -1],
                        [10, 50, 100, 200, "All"],
                    ],
                    buttons: [],
                    columns: [
                        {
                            title: "#SL",
                            data: "id",
                            class: "no-sort",
                            width: "50px",
                            render: function (data, row, type, col) {
                                var pageInfo = parkingRFIDDataTableEl.page.info();
                                return col.row + 1 + pageInfo.start;
                            },
                        },
                        {
                            title: "Place",
                            class: "no-sort",
                            name: "place",
                            data: "category.place.name",
                        },
                        {
                            title: "Category",
                            class: "no-sort",
                            name: "category",
                            data: "category.type",
                        },
                        {
                            title: "Vehicle No",
                            class: "no-sort",
                            name: "vehicle_no",
                            data: "vehicle_no",
                        },
                        {
                            title: "RFID No",
                            class: "no-sort",
                            name: "rfid_no",
                            data: "rfid_no",
                        },
                        {
                            title: "Driver Name",
                            class: "no-sort",
                            name: "driver_name",
                            data: "driver_name",
                        },
                        {
                            title: "Driver Mobile",
                            class: "no-sort",
                            name: "driver_mobile",
                            data: "driver_mobile",
                        },               
                        {
                            title: "Status",
                            name: "status",
                            data: "status",
                            render: function (data, type, row) {
                                return data == 1 ? "Active" : "Inactive";
                            },
                        },
                        {
                            title: "Option",
                            data: "id",
                            class: "text-end width-5-per",
                            render: function (data, type, row, col) {
                                var editURL = route("parking_settings.rfid_vehicles.edit", {
                                    rfidVehicle: data,
                                });
                                var delURL = route("parking_settings.rfid_vehicles.destroy", {
                                    rfidVehicle: data,
                                });
                                var statusURL = route(
                                    "parking_settings.rfid_vehicles.status_changes",
                                    { rfidVehicle: data }
                                );
                                $return = '';
                                @can("rfids.status")
                                if (row.status == 1) {
                                    $return +=
                                        '<a href="' +
                                        statusURL +
                                        '"><i class="fa fa-window-close-o text-danger" aria-hidden="true" title="Deactivate"></i></a> | ';
                                } else {
                                    $return +=
                                        '<a href="' +
                                        statusURL +
                                        '"><i class="fa fa-check text-info" aria-hidden="true" title="Active"></i></a> | ';
                                }
                                @endcan
                                @can("rfids.edit")
                                $return +=
                                    '<a href="' +
                                    editURL +
                                    '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit RFID"></i></a>';
                                @endcan
                                @can("rfids.delete")    
                                $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#parkingRfidDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete RFID"></i></button>';
                                @endcan
                                return $return;
                            },
                        },
                    ],
        
                    ajax: {
                        url: route("parking_settings.rfid_vehicles.index"),
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
                            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        },
                    ],
                    responsive: true,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                });
            });
            
        })(jQuery);
        
    </script>
@endpush