@extends('layouts.app')
@section('title', ' - All Language')
@section('content')
    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.language.all_language_list') }}
                        @can("languages.create")
                        <a class="btn btn-sm btn-primary pull-right" href="{{ route('languages.create') }}">{{ __('application.language.add_language') }}</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderd table-condenced w-100" id="languageDataTable">
                                <thead>
                                    <tr>
                                        <th>{{__('application.table.serial')}}</th>
                                        <th>{{__('application.language.country')}}</th>
                                        <th>{{__('application.language.language_name')}}</th>
                                        <th>{{__('application.language.language_code')}}</th>
                                        <th>{{__('application.language.flag')}}</th>
                                        <th>{{__('application.language.status')}}</th>
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
    {{--  <script src="{{ assetz('js/custom/languages.js') }}"></script>  --}}
    <script>
        (function ($) {
            "use strict";
        
            let languageDataTable = null;
            let $return;
            $(document).ready(function () {
                languageDataTable = $("#languageDataTable").DataTable({
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
                                var pageInfo = languageDataTable.page.info();
                                return col.row + 1 + pageInfo.start;
                            },
                        },
                        {
                            name: "name",
                            data: "country",
                            render: function (data, type, row, col) {
                                return data.name;
                            }
                        },
                        {
                            name: "name",
                            data: "name",
                        },
                        { name: "code", data: "code" },
                        {
                            data: "country",
                            name: "country",
                            render: function (data, type, row, col) {
                                return `<img src="https://countryflagsapi.com/png/${data.code}" alt="${data.name}">`
                            }
                        },
                        {
                            data: "status",
                            name: "status",
                            render: function (data, type, row, col) {
                                if(data == 0){
                                    return 'Deactivated'
                                }
                                else if(data == 1){
                                    return 'Activated'
                                }
                                else if(data == 2){
                                    return 'Default'
                                }
                            }
                        },
                        {
                            data: "id",
                            class: "text-end width-5-per",
                            render: function (data, type, row, col) {
                                var delURL = route("languages.destroy", { language: data });
                                var setDefaultlURL = route("languages.set_languages", { language: data });

                                $return = '';
                                @can("languages.delete")    
                                $return += `<button class="btn btn-sm btn-danger" onclick="deleteData(\'' + delURL + '\', \'#languageDataTable\')">Delete language</button>&nbsp;`;
                                @endcan
                                @can("languages.config")    
                                $return += `&nbsp;<a class="btn btn-sm btn-primary" href="${route('language.language_change', { 'language': data })}">Edit language</a>`;
                                @endcan
                                @can("languages.edit")
                                $return +=  `&nbsp;<a class="btn btn-sm btn-info" href="${route('languages.edit', { 'language': data })}">Config language</a>`;
                                @endcan

                                return $return;
                            },
                        },
                    ],
                    ajax: {
                        url: route("languages.index"),
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
                            targets: [0, 4, 5, 6],
                        },
                    ],
                    responsive: true,
                    autoWidth: false,
                    serverSide: true,
                    processing: true,
                });
        
                // collapse
                $('#myAccordino').collapse();
        
        
            });
        
        })(jQuery);
        
    </script>
@endpush
