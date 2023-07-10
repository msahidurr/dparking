@extends('layouts.app')
@section('title', ' - All Parking')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('application.parking.ended_parking_list') }}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderd table-condenced w-100 f12" id="parkingDatatableEnded">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.parking.barcode')}}</th>
                                    <th>{{__('application.parking.vehicle_no')}}</th>
                                    <th>{{__('application.parking.type')}}</th>
                                    <th>{{__('application.parking.in_time')}}</th>
                                    <th>{{__('application.parking.out_time')}}</th>
                                    <th>{{__('application.parking.payable_amount')}}</th>
                                    <th>{{__('application.parking.parking_slot')}}</th>
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
    <script src="{{ assetz('js/custom/settings/parking.js') }}"></script>
@endpush