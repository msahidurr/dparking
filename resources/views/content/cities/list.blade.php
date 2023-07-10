@extends('layouts.app')
@section('title', ' - Cities List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.city.city_list') }}
                    @can("cities.create")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('cities.create') }}">{{ __('application.city.create_new') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="cityDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.city.name')}}</th>
                                    <th>{{__('application.city.country')}}</th>
                                    <th>{{__('application.city.state')}}</th>
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
    {{--  <script src="{{ assetz('js/custom/settings/city.js') }}"></script>  --}}
    <script>
        (function ($) {
            "use strict";
            var cityDataTableEl = null;
            let $return;
            $(document).ready(function () {
                
        
                cityDataTableEl = $("#cityDatatable").DataTable({
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
                                var pageInfo = cityDataTableEl.page.info();
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
                            name: "state.country.name",
                            data: "state.country.name",
                        },
                        {
                            class: "no-sort",
                            name: "state.name",
                            data: "state.name",
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
                                var editURL = route("cities.edit", {
                                    city: data,
                                });
                                var delURL = route("cities.destroy", {
                                    city: data,
                                });
                                $return ="";
                                @can("cities.edit")
                                $return +=
                                    '<a href="' +
                                    editURL +
                                    '"><i class="fa fa-pencil-square-o text-info" aria-hidden="true" title="Edit Slot"></i></a>';
                                @endcan
                                @can("cities.delete")    
                                $return += '| <button class="btn btn-link p-0" onclick="deleteData(\'' + delURL +'\', \'#cityDatatable\')"><i class="fs-6 fa fa-trash-o text-danger" aria-hidden="true" title="Delete Slot"></i></button>';
                                @endcan
                                return $return;
                            },
                        },
                    ],
        
                    ajax: {
                        url: route("cities.index"),
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
                            targets: [0, 1, 4],
                        },
                    ],
                    responsive: true,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                });
            });
        
            $(document).on('change', '#country_id', function(){
                let state = states.filter(val => val.country_id == $(this).val());
                var html = '';
                $.each(state, function(ind,val){
                    html += `<option value="${val.id}">${val.name}</option>`;
                });
        
                $(document).find('#state_id').html(html);
        
                $('#state_id').trigger('change');
            });
        })(jQuery);
        function update_currency_status(el,id)
        {

            $.post('cities/default/'+id, {_token:'{{ csrf_token() }}'}, function(data) {
                location.reload();
            });

        }
    </script>
@endpush