@extends('layouts.app')
@section('title', ' - All Tariff')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.tariff.tariff_list') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('tariff.create') }}">{{ __('application.tariff.create_new') }}</a>
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

<script src="{{ assetz('js/custom/settings/tariff.js') }}"></script>

@endsection