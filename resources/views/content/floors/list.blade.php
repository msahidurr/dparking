@extends('layouts.app')
@section('title', ' - Floor List')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('application.floor.floor_list') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('floors.create') }}">{{ __('application.floor.create_new') }}</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="floorDatatable" class="table table-borderd table-condenced w-100">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.floor.db_id')}}</th>
                                    <th>{{__('application.floor.place')}}</th>
                                    <th>{{__('application.floor.name')}}</th>
                                    <th>{{__('application.floor.floor_level')}}</th>
                                    <th>{{__('application.floor.remarks')}}</th>
                                    <th>{{__('application.floor.status')}}</th>
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
<script src="{{ assetz('js/custom/settings/floor.js') }}"></script>
@endpush