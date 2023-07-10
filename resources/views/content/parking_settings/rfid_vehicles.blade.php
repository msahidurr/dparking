@extends('layouts.app')
@section('title', ' - '.__('application.rfid_vehicles.list'))
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.rfid_vehicles.list') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.rfid_vehicles.create') }}">{{ __('application.rfid_vehicles.create_new') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="parkingRfidDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.rfid_vehicles.place')}}</th>
                                    <th>{{__('application.rfid_vehicles.category')}}</th>
                                    <th>{{__('application.rfid_vehicles.vehicle_no')}}</th>
                                    <th>{{__('application.rfid_vehicles.rfid_no')}}</th>
                                    <th>{{__('application.rfid_vehicles.driver_name')}}</th>
                                    <th>{{__('application.rfid_vehicles.driver_mobile')}}</th>
                                    <th>{{__('application.rfid_vehicles.status')}}</th>
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
    <script src="{{ assetz('js/custom/settings/parking_setting_rfid_vehicle.js') }}"></script>
@endpush