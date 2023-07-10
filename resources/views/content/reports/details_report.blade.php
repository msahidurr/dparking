@extends('layouts.app')
@section('title', ' - Add Parking')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center fw-bold">{{ __('application.report.details_report') }}</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.details_report') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="from_date" class="col-form-label ">
                                        {{ __('application.report.from_date') }} :</label>
                                    <input id="from_date" type="text" class="form-control dateTimePicker"
                                        name="from_date" value="{{ old('from_date', request()->get('from_date')) }}"
                                        autocomplete="off">
                                    @if ($errors->has('from_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('from_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="to_date" class="col-form-label ">
                                        {{ __('application.report.to_date') }} :</label>
                                    <input id="to_date" type="text" class="form-control dateTimePicker" name="to_date"
                                        value="{{ old('to_date', request()->get('to_date')) }}" autocomplete="off">
                                    @if ($errors->has('to_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('to_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="place_id" class="col-form-label ">
                                        {{ __('application.report.place') }} :</label>

                                    <select name="place_id" id="place_id"
                                        class="select2 form-control{{ $errors->has('place_id') ? ' is-invalid' : '' }}">
                                        <option value="all">{{ __('application.report.all_place') }}</option>
                                        @foreach ($places as $key => $value)
                                        <option value="{{ $value->id }}" {{ (old('place_id', request()->get('place_id'))
                                            == $value->id ? 'selected' : '') }}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('place_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('place_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="floor_id" class="col-form-label ">
                                        {{ __('application.report.floor') }} :</label>

                                    <select name="floor_id" id="floor_id"
                                        class="select2 form-control{{ $errors->has('floor_id') ? ' is-invalid' : '' }}">

                                    </select>

                                    @if ($errors->has('floor_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('floor_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="category_id" class="col-form-label ">
                                        {{ __('application.report.category') }} :</label>

                                    <select name="category_id" id="category_id"
                                        class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">

                                    </select>

                                    @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="car_no" class="col-form-label ">{{ __('application.report.vehicle_no')
                                        }} :</label>
                                    <input id="car_no" type="text"
                                        class="form-control {{ $errors->has('car_no') ? ' is-invalid' : '' }}"
                                        name="car_no" value="{{ old('car_no', request()->get('car_no')) }}"
                                        autocomplete="off">
                                    @if ($errors->has('car_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('car_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="driver_name" class="col-form-label ">
                                        {{ __('application.report.driver_name') }} :</label>
                                    <input id="driver_name" type="text"
                                        class="form-control {{ $errors->has('driver_name') ? ' is-invalid' : '' }}"
                                        name="driver_name"
                                        value="{{ old('driver_name', request()->get('driver_name')) }}"
                                        autocomplete="off">

                                    @if ($errors->has('driver_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driver_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="driver_mobile" class="col-form-label ">
                                        {{ __('application.report.driver_mobile') }} :</label>
                                    <input id="driver_mobile" type="number"
                                        class="form-control {{ $errors->has('driver_mobile') ? ' is-invalid' : '' }}"
                                        name="driver_mobile"
                                        value="{{ old('driver_mobile', request()->get('driver_mobile')) }}"
                                        autocomplete="off">
                                    @if ($errors->has('driver_mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driver_mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 pull-right">
                            <div class="col-md-12">
                                <a class="btn-secondary btn" href="{{ route('reports.summary') }}" class="btn"
                                    id="frmClear">
                                    {{ __('application.report.clear') }}
                                </a>
                                <button type="submit" class="btn btn-success">
                                    {{ __('application.report.filter') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if (count($request))
        <div class="col-md-12 mt50">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            {{ __('application.report.report_view') }}
                        </div>
                        <div class="col-6">
                            @foreach ($request as $key => $value)
                            <input type="hidden" name="data[{{ $key }}]" value="{{ $value }}">
                            @endforeach
                            <button class="btn btn-primary btn-sm pull-right" onclick="printDiv()">{{
                                __('application.report.download')
                                }} /
                                {{ __('application.report.print') }}</button>
                        </div>
                    </div>
                </div>
                <div class="card-body"  id="printBlock">
                    @include('content.reports.pdf_details_report')
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')

<script>
    var floors = @json($floors);
    var categories = @json($categories);
</script>
<script src="{{ assetz('js/custom/reports.js') }}"></script>

@endpush