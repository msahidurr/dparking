@extends('layouts.app')
@section('title', ' - Floor List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.floor.floor_list') }}
                    @can("floors.create")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('floors.create') }}">{{ __('application.floor.create_new') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="floorDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.floor.db_id')}}</th>
                                    <th>{{__('application.floor.place')}}</th>
                                    <th>{{__('application.floor.name')}}</th>
                                    <th>{{__('application.floor.floor_level')}}</th>
                                    <th>{{__('application.floor.remarks')}}</th>
                                    <th>{{__('application.floor.status')}}</th>
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
{{--  <script src="{{ assetz('js/custom/settings/floor.js') }}"></script>  --}}
<script>
    (function ($) {
        "use strict";
        let floorDatatableEl = null;
        let $return;
        $(document).ready(function () {
            floorDatatableEl = $("#floorDatatable").DataTable({
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
                            var pageInfo = floorDatatableEl.page.info();
                            return col.row + 1 + pageInfo.start;
                        },
                    },
                    { name: "db_id", data: "id" },
                    { name: "places.name", data: "place.name" },
                    { name: "name", data: "name" },
                    { name: "level", data: "level" },
                    { title: "Remarks", name: "remarks", data: "remarks" },
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
                            var editURL = route("floors.edit", { floor: data });
                            var delURL = route("floors.destroy", { floor: data });
                            var statusURL = route("floors.status_changes", {
                                floor: data,
                            });
                            $return = '';
                            @can("floors.status")
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
                            @can("floors.edit")
                            $return +=
                                '<a href="' +
                                editURL +
                                '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Floor"></i></a>';
                            @endcan
                            @can("floors.delete")    
                            $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#floorDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Floor"></i></button>';
                            @endcan
                            return $return;
                        },
                    },
                ],
    
                ajax: {
                    url: route("floors.index"),
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
    })(jQuery);
    
</script>
@endpush