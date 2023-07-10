@extends('layouts.app')
@section('title', ' - Roles List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.role.role_list') }}
                    @can("roles.create")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('roles.create') }}">{{ __('application.role.create_new') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="roleDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.role.name')}}</th>
                                    <th>{{__('application.role.permissions')}}</th>
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
{{--  <script src="{{ assetz('js/custom/settings/role.js') }}"></script>  --}}
<script>
    (function ($) {
        "use strict";
        let roleDatatableEl = null;
        let $return;
        $(document).ready(function () {
            roleDatatableEl = $("#roleDatatable").DataTable({
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
                            var pageInfo = roleDatatableEl.page.info();
                            return col.row + 1 + pageInfo.start;
                        },
                    },
                    { name: "name", data: "name" },
                    {
                        title: "Perissions",
                        data: "permissions",
                        render: function (data, type, row, col) {
                            var $result = [];
                            if(data.length)
                            {
                                $(data).each(function( index, element ) {
                                    $result[index] = element.name;
                                });
                            }
                            return (($result.toString().length > 100) ? $result.toString().substring(0,100)+"..." : $result.toString()) ;
                        },
                    },
                    {
                        title: "Option",
                        data: "id",
                        class: "text-end width-5-per",
                        render: function (data, type, row, col) {
                            var editURL = route("roles.edit", { role: data });
                            var delURL = route("roles.destroy", { role: data });
                            $return = '';
                            @can("roles.edit")
                            $return +=
                                '<a href="' +
                                editURL +
                                '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Floor"></i></a>';
                            @endcan
                            @can("roles.delete")    
                            $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#roleDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Floor"></i></button>';
                            @endcan
                            return $return;
                        },
                    },
                ],
    
                ajax: {
                    url: route("roles.index"),
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
                        targets: [1],
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