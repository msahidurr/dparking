@extends('layouts.app')
@section('title', ' - Parking Slot List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.slot.slot_list') }}
                    @can("slots.create")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.create') }}">{{ __('application.slot.create_new') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="parkingSlotDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.slot.category')}}</th>
                                    <th>{{__('application.slot.place')}}</th>
                                    <th>{{__('application.slot.floor')}}</th>
                                    <th>{{__('application.slot.name')}}</th>
                                    <th>{{__('application.slot.identity')}}</th>
                                    <th>{{__('application.slot.status')}}</th>
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
    {{--  <script src="{{ assetz('js/custom/settings/parking_setting.js') }}"></script>  --}}
    <script>
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
                                $return = '';
                                @can("slots.status")
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
                                @can("slots.edit")
                                $return +=
                                    '<a href="' +
                                    editURL +
                                    '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Slot"></i></a>';
                                @endcan
                                @can("slots.delete")    
                                $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#parkingSlotDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Slot"></i></button>';
                                @endcan
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
        
    </script>
@endpush