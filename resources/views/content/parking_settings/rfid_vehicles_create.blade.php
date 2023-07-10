@extends('layouts.app')
@section('title', ' - '.__('application.rfid_vehicles.create'))
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('application.rfid_vehicles.add') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.rfid_vehicles.index') }}">{{
                        __('application.rfid_vehicles.list') }}</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('parking_settings.rfid_vehicles.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="place_id" class="text-md-right">{{ __('application.rfid_vehicles.place') }} <span
                                            class="tcr text-danger">*</span></label>
                                    <select name="place_id" id="place_id" required
                                        class="form-control {{ $errors->has('place_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($places as $place)
                                        <option value="{{ $place->id }}" {{ old('place_id')==$place->id ? ' selected' :
                                            '' }}>
                                            {{ $place->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('place_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('place_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="text-md-right">{{ __('application.rfid_vehicles.category') }} <span
                                            class="tcr text-danger">*</span></label>
                                    <select name="category_id" id="category_id" required
                                        class="form-control {{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($categories as $category)
                                        <option data-place-id="{{$category->place_id}}" value="{{ $category->id }}" {{ old('category_id')==$category->id ? ' selected' :
                                            '' }}>
                                            {{ $category->type }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_no" class="text-md-right">{{ __('application.rfid_vehicles.vehicle_no') }}<span
                                            class="tcr text-danger">*</span></label>
                                    <input type="text" required
                                        class="form-control{{ $errors->has('vehicle_no') ? ' is-invalid' : '' }}"
                                        value="{{ old('vehicle_no') }}" name="vehicle_no">
                                    @if ($errors->has('vehicle_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vehicle_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfid_no" class="text-md-right">{{ __('application.rfid_vehicles.rfid_no') }}<span
                                            class="tcr text-danger">*</span></label>
                                    <input type="text" required
                                        class="form-control{{ $errors->has('rfid_no') ? ' is-invalid' : '' }}"
                                        value="{{ old('rfid_no') }}" name="rfid_no">
                                    @if ($errors->has('rfid_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rfid_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="driver_name" class="text-md-right">{{ __('application.rfid_vehicles.driver_name')
                                        }}</label>
                                    <input type="text" required
                                        class="form-control{{ $errors->has('driver_name') ? ' is-invalid' : '' }}"
                                        value="{{ old('driver_name') }}" name="driver_name">
                                    @if ($errors->has('driver_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driver_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="driver_mobile" class="text-md-right">{{ __('application.rfid_vehicles.driver_mobile')
                                        }}</label>
                                    <input type="text" required
                                        class="form-control{{ $errors->has('driver_mobile') ? ' is-invalid' : '' }}"
                                        value="{{ old('driver_mobile') }}" name="driver_mobile">
                                    @if ($errors->has('driver_mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driver_mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="pull-right d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                        {{ __('application.rfid_vehicles.clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('application.rfid_vehicles.create_new') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    var categories = @json($categories);
    function update_category_list(){
        $('#category_id').empty();
        $.each(categories, function(ind, item){
            if(item.place_id == $('#place_id').val())
                $('#category_id').append('<option value="'+item.id+'">'+item.type+'</option>');
        });        
    }
    $(window).on("load",function(){
        update_category_list();
    })
    $('#place_id').on("change",function(){
        update_category_list();
    });
</script>
@endpush