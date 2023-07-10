@extends('layouts.app')
@section('title', ' - All Tariff')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.tariff.tariff_list') }}
                    @can("tariffs.create")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('tariff.create') }}">{{ __('application.tariff.create_new') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderd table-condenced w-100" id="tariffDatatable">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.tariff.place')}}</th>
                                    <th>{{__('application.tariff.name')}}</th>
                                    <th>{{__('application.tariff.type')}}</th>
                                    <th>{{__('application.tariff.start_date')}}</th>
                                    <th>{{__('application.tariff.end_date')}}</th>
                                    <th>{{__('application.tariff.min_amount')}}</th>
                                    <th>{{__('application.tariff.amount')}}</th>
                                    <th>{{__('application.tariff.status')}}</th>
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
@push("scripts")
{{--  <script src="{{ assetz('js/custom/settings/tariff.js') }}"></script>  --}}

    <script>
        (function ($) {
            "use strict";
            let tariffDatatable = null;
            let $return;
            $(document).ready(function () {
                if(!$(document).find('input[name=id').length){
                    $(document).find('#place_id').trigger('change');
                }
        
                tariffDatatable = $("#tariffDatatable").DataTable({
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
                                var pageInfo = tariffDatatable.page.info();
                                return col.row + 1 + pageInfo.start;
                            },
                        },
                        { name: "place.name", data: "place.name" },
                        { name: "name", data: "name" },
                        { name: "category.type", data: "category.type" },
                        { name: "start_date", data: "start_date" },
                        { name: "end_date", data: "end_date" },
                        { name: "min_amount", data: "min_amount" },
                        { name: "amount", data: "amount" },
                        {
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
                                var editURL = route("tariff.edit", { tariff: data });
                                var delURL = route("tariff.destroy", { tariff: data });
                                $return = '';
                                @can("tariffs.edit")
                                    $return += '<a href="' + editURL + '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Tariff"></i></a>';
                                @endcan
                                @can("tariffs.delete")    
                                    $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#tariffDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Tariff"></i></button>';
                                @endcan
                                return $return;
                            },
                        },
                    ],
        
                    ajax: {
                        url: route("tariff.index"),
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
                            targets: [0,1, 3, 8,9],
                        },
                    ],
                    responsive: true,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                });
            });
        
            $(document).on('change', '#place_id', function(){
                let category = categories.filter(val => val.place_id == $(this).val());
                let html = '';
                $.each(category, function(ind,val){
                    html += `<option value="${val.id}">${val.type}</option>`;
                });
        
                $(document).find('#category_id').html(html);
            });
        
        })(jQuery);
        
    </script>
@endpush