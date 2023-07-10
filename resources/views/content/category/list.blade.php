@extends('layouts.app')
@section('title', ' - All Category')
@section('content')
    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.category.category_list') }}
                        @can("categories.create")
                        <a class="btn btn-sm btn-primary pull-right" href="{{ route('category.create') }}">
                            {{ __('application.category.create_new') }}</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderd table-condenced w-100" id="categoryDatatable">
                                <thead>
                                    <tr>
                                        <th>{{__('application.table.serial')}}</th>
                                        <th>{{__('application.category.place')}}</th>
                                        <th>{{__('application.category.type')}}</th>
                                        <th>{{__('application.category.description')}}</th>
                                        <th>{{__('application.category.status')}}</th>
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
    {{--  <script src="{{ assetz('js/custom/settings/category.js') }}"></script>  --}}
    <script>
        (function ($) {
            "use strict";
        
            let categoryDatatable = null;
            let $return;
            $(document).ready(function () {
                categoryDatatable = $("#categoryDatatable").DataTable({
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
                                var pageInfo = categoryDatatable.page.info();
                                return col.row + 1 + pageInfo.start;
                            },
                        },
                        { name: "place.name", data: "place.name" },
                        { name: "type", data: "type" },
                        { name: "description", data: "description" },
                        {
                            title: "Status",
                            name: "status",
                            data: "status",
                            render: function (data, type, row) {
                                return data == 1 ? "Enable" : "Disable";
                            },
                        },
                        {                    
                            data: "id",
                            class: "text-end width-5-per",
                            render: function (data, type, row, col) {
                                let deleteUrl = route('category.destroy', { 'category': data });
                                $return = '';
                                @can("categories.edit")
                                $return += '<a href="' + route('category.edit', { 'category': data })+'"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Category"></i></a>';
                                @endcan
                                @can("categories.delete")
                                $return += '| <button class="btn btn-link p-0" onclick="deleteData(\''+deleteUrl+'\', \'#categoryDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Category"></i></button>';
                                @endcan
                                
                                return $return;
                            },
                        },
                    ],
        
                    ajax: {
                        url: route("category.index"),
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
                            targets: [0, 1, 4, 5],
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
