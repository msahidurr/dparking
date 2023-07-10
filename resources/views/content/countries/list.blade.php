@extends('layouts.app')
@section('title', ' - Countries List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.country.country_list') }}
                    @can("countries.create")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('countries.create') }}">{{ __('application.country.create_new') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="countryDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.country.name')}}</th>
                                    <th>{{__('application.country.short_code')}}</th>
                                    <th>{{__('application.country.phone_code')}}</th>
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
    {{--  <script src="{{ assetz('js/custom/settings/country.js') }}"></script>  --}}
    <script>
        (function ($) {
            "use strict";
            var countryDataTableEl = null;
            let $return;
            
            $(document).ready(function () {
                
                
                countryDataTableEl = $("#countryDatatable").DataTable({
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
                                var pageInfo = countryDataTableEl.page.info();
                                return col.row + 1 + pageInfo.start;
                            },
                        },
                        {
                            class: "no-sort",
                            name: "name",
                            data: "name",
                        },
                        {
                            class: "no-sort",
                            name: "short_code",
                            data: "short_code",
                        },
                        {
                            class: "no-sort",
                            name: "phone_code",
                            data: "phone_code",
                        },
                        {
                            data: "default",
                            class: "text-end width-5-per",
                            render: function (data, type, row, col) {
                                var $return =`<label class="checkbox">
                                    <input type="checkbox" onchange="update_currency_status(this,${row.id})" class="form-control" ${(row.default == 1)? "checked":"" }>
                                    <span></span>
                                </label>`;
                                
                                return $return;
                            },
                        },
                        {
                            data: "id",
                            class: "text-end width-5-per",
                            render: function (data, type, row, col) {
                                var editURL = route("countries.edit", {
                                    country: data,
                                });
                                var delURL = route("countries.destroy", {
                                    country: data,
                                });
                                $return ="";
                                @can("countries.edit")
                                $return +=
                                    '<a href="' +
                                    editURL +
                                    '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Slot"></i></a>';
                                @endcan
                                @can("countries.delete")    
                                $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#countryDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Slot"></i></button>';
                                @endcan
                                return $return;
                            },
                        },
                    ],
        
                    ajax: {
                        url: route("countries.index"),
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
                            targets: [0, 4],
                        },
                    ],
                    responsive: true,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                });
            });
        
        })(jQuery);
        function update_currency_status(el,id)
        {

            $.post('countries/default/'+id, {_token:'{{ csrf_token() }}'}, function(data) {
                location.reload();
            });

        }
    </script>
@endpush