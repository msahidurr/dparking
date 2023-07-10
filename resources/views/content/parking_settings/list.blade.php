@extends('layouts.app')
@section('title', ' - Parking Slot List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.slot.slot_list') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.create') }}">{{ __('application.slot.create_new') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="parkingSlotDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.slot.category')}}</th>
                                    <th>{{__('application.slot.place')}}</th>
                                    <th>{{__('application.slot.floor')}}</th>
                                    <th>{{__('application.slot.name')}}</th>
                                    <th>{{__('application.slot.identity')}}</th>
                                    <th>{{__('application.slot.status')}}</th>
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
    <script src="{{ assetz('js/custom/settings/parking_setting.js') }}"></script>
@endpush