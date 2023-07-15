@extends('layouts.app')
@section('title', ' - Add Parking')
@push('css')
<link rel="stylesheet" href="{{ asset('css/custom/parking.css') }}">
@endpush

@section('content')
<div class="container-fluid mb100">
    <div class="row customEqual">
        <div class="col-sm-12 col-md-4 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('application.parking.total_parking_space') }}</h5>
                </div>
                <div class="card-body">
                    <h1>{{ $total_slots }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('application.parking.total_booked') }}</h5>
                </div>
                <div class="card-body">
                    <h1>{{ $currently_parking }}</h1>
                </div>
            </div>
        </div>
        {{--  <div class="col-sm-12 col-md-3 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('application.parking.total_available') }}</h5>
                </div>
                <div class="card-body">
                    <h1>{{ $total_slots - $currently_parking }}</h1>
                </div>
            </div>
        </div>  --}}
        <div class="col-md-3 col-sm-12 mb-2">
            <div class="card customEqualEl">
                <div class="card-header">{{ __('application.parking.quick_checkout') }}</div>
                <div class="card-body p-2">
                    <form action="{{ route('parking.quick_end') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" name="barcode" id="barcode" class="form-control" tabindex="1" placeholder="{{__('application.parking.barcode')}}" autocomplete="off">
                            </div>
                            <div class="col-md-12">
                                <input value="{{__('application.parking.find')}}" class="btn btn-sm btn-outline-info pull-right mt-2" type="submit">                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('application.parking.add_parking') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('parking.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label for="driver_id" class="col-form-label text-md-right"><span class="tcr i-req">*</span>{{ __('application.parking.driver_name') }}</label>
                                        </div>
                                        <select id="driver_id" type="text"
                                            class="form-control {{ $errors->has('driver_id') ? ' is-invalid' : '' }}" name="driver_id" value="{{ old('driver_id') }}" required>
                                            <option value="">Select</option>
                                            @isset($drivers)
                                                @foreach($drivers as $driver)
                                                    <option value="{{$driver->id}}" @if($driver->id == old('driver_id')) selected @endif>{{ $driver->name }}</option>
                                                @endforeach
                                            @endisset
                                        </select>

                                        @if ($errors->has('driver_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('driver_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="agent_id" class="col-form-label text-md-right">{{
                                                __('application.parking.agent_name') }}</label>
                                            
                                            <select id="agent_id" type="text"
                                                class="form-control {{ $errors->has('agent_id') ? ' is-invalid' : '' }}" name="agent_id" value="{{ old('agent_id') }}">
                                                <option value="">Select</option>
                                                @isset($agents)
                                                    @foreach($agents as $agent)
                                                        <option value="{{$agent->id}}">{{$agent->name}}</option>
                                                    @endforeach
                                                    
                                                @endisset
                                            </select>

                                            @if ($errors->has('agent_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('agent_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label for="place_id"
                                                class="col-md-4 col-form-label col-form-label text-md-right"><span
                                                    class="tcr i-req">*</span>{{ __('application.parking.place')
                                                }}</label>
                                            <input type="text" id="place_id_name" class="form-control" required readonly />
                                            
                                            <input id="place_id" name="place_id" type="hidden" />
                                        </div>
                                    </div>

                                    {{-- <div class="col-12">
                                        @if(auth()->user()->hasAllPermissions(allpermissions()))
                                        <div class="form-group mb-1">
                                            <label for="place_id"
                                                class="col-md-4 col-form-label col-form-label text-md-right"><span
                                                    class="tcr i-req">*</span>{{ __('application.parking.place')
                                                }}</label>
                                            <select name="place_id" id="place_id"
                                                class="select2 form-control{{ $errors->has('place_id') ? ' is-invalid' : '' }}"
                                                required readonly>
                                                <?php
                                                    foreach ($places as $key => $value) {
                                                        echo '<option value="' . $value->id . '" ' . (old('place_id') == $value->id ? ' selected' : '') . '>' . $value->name . '</option>';
                                                    }
                                                    ?>
                                            </select>

                                            @if ($errors->has('place_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('place_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        @else
                                        <input type="hidden" id="place_id" name="place_id" value="{{auth()->user()->place_id}}">
                                        @endif
                                    </div> --}}

                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label for="category_id"
                                                class="col-md-4 col-form-label col-form-label text-md-right"><span class="tcr i-req">*</span>{{ __('application.parking.type')
                                                }}</label>
                                            <select name="category_id" id="category_id"
                                                class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                                required readonly>

                                            </select>

                                            @if ($errors->has('category_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label for="tariff_id"
                                                class="col-md-4 col-form-label col-form-label text-md-right"><span
                                                    class="tcr i-req">*</span>{{ __('application.parking.tariff')
                                                }}</label>
                                            <select name="tariff_id" id="tariff_id"
                                                class="select2 form-control{{ $errors->has('tariff_id') ? ' is-invalid' : '' }}"
                                                required readonly>

                                            </select>

                                            @if ($errors->has('tariff_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tariff_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">                    
                                        <label for="floor_id" class="col-form-label text-md-right">{{ __('application.customer.floor') }}<span class="tcr i-req"></span></label>
                                            <select id="floor_id" name="floor_id" class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" readonly>       
                                                       
                                            </select>
                                            @if ($errors->has('floor_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('floor_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="slot_id" class="col-md-12 col-form-label text-md-right">{{ __('application.customer.lot') }}<span class="tcr i-req"></span></label>
                                        <div class="col-md-12">                                
                                            <select id="slot_id" name="category_wise_floor_slot_id" class="select2 form-control{{ $errors->has('slot_id') ? ' is-invalid' : '' }}" readonly>       
                                                       
                                            </select>
                                            @if ($errors->has('slot_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('slot_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-1">
                                            <label for="vehicle_no" class="col-form-label text-md-right"><span
                                                    class="tcr i-req">*</span>{{ __('application.parking.vehicle_no')
                                                }}</label>
                                            <input id="vehicle_no" type="text"
                                                class="form-control {{ $errors->has('vehicle_no') ? ' is-invalid' : '' }}"
                                                name="vehicle_no" value="{{ old('vehicle_no') }}" autocomplete="off"
                                                required readonly>

                                            @if ($errors->has('vehicle_no'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('vehicle_no') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="driver_mobile" class="col-form-label text-md-right">{{
                                                __('application.parking.driver_mobile') }}</label>
                                            <input id="driver_mobile" type="number"
                                                class="form-control {{ $errors->has('driver_mobile') ? ' is-invalid' : '' }}"
                                                name="driver_mobile" value="{{ old('driver_mobile') }}"
                                                autocomplete="off" readonly>

                                            @if ($errors->has('driver_mobile'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('driver_mobile') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="id_number" class="col-form-label text-md-right">{{
                                                __('application.parking.id_number') }}</label>
                                            <input id="id_number" type="text"
                                                class="form-control {{ $errors->has('id_number') ? ' is-invalid' : '' }}"
                                                name="id_number" value="{{ old('id_number') }}"
                                                autocomplete="off" readonly>

                                            @if ($errors->has('id_number'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('id_number') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="pull-right">
                                    <button type="reset" class="btn btn-secondary" id="frmClear">
                                        {{ __('application.parking.clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        {{ __('application.parking.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('application.parking.all_parking_list') }}</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderd table-condenced w-100 f12" id="parkingDatatable">
                            <thead>
                                <tr>
                                    <th>{{__('application.table.serial')}}</th>
                                    <th>{{__('application.parking.barcode')}}</th>
                                    <th>{{__('application.parking.vehicle_no')}}</th>
                                    <th>{{__('application.parking.type')}}</th>
                                    <th>{{__('application.parking.in_time')}}</th>
                                    <th>{{__('application.parking.out_time')}}</th>
                                    <th>{{__('application.parking.paid_amount')}}</th>
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
<script>
    var categories = @json($categories);
    var tariffs = @json($tariffs);
    var drivers = @json($drivers);
    var driverId = @json(old('driver_id'));
    var owners = @json($agents);
    var floors = @json($floors);
    var slots = @json($slots);
</script>
<script src="{{ assetz('js/custom/settings/parking.js') }}"></script>
@endpush