@extends('layouts.app')
@section('title', ' - Customer List')
@section('content')
    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.customer.customer_list') }}
                        @can("users.create")
                        <a class="btn btn-sm btn-info pull-right"
                            href="{{ route('customer.create') }}">{{ __('application.user.create_new') }}</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="userDataTable" class="table table-borderd table-condenced w-100">
                                <thead>
                                    <tr>
                                        <th>{{__('application.table.serial')}}</th>
                                        <th>{{__('application.customer.driver_name')}}</th>
                                        <th>{{__('application.customer.vehicle_no')}}</th>
                                        <th>{{__('application.customer.driver_phone_no')}}</th>
                                        <th>{{__('application.user.role')}}</th>
                                        <th>{{__('application.user.status')}}</th>
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
    {{--  <script type="text/javascript" src="{{ assetz('js/user.js') }}"></script>  --}}
    <script type="text/javascript">
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
                            data: "vehicle_no",
                            name: "vehicle_no",
                            render: function (data, type, row, index) {
                                return data;
                            },
                        },
                        {
                            data: "phone_number",
                            name: "phone_number",
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
                                var editURL = "{{route('customer.edit')}}/"+ data;
                                var delURL = "{{route('customer.destroy')}}/" + data;
                                var statusURL = "{{route('customer.status')}}/" + data;
                                $return = '';
                                @can("users.status")
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
                                @can("users.edit")
                                $return +=
                                    '<a href="' +
                                    editURL +
                                    '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit User"></i></a>';
                                @endcan
                                @can("users.delete")    
                                $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#userDataTable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete User"></i></button>';
                                @endcan
                                return $return;
        
                                return $return;
                            },
                        },
                    ],
                    ajax: {
                        url: "{{route("customerListJson")}}",
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
        
    </script>
@endpush
