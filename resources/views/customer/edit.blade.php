@extends('layouts.app')
@section('title', ' - Edit Customer')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('application.customer.edit_customer') }}
                    @can("users.index")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('customer.list') }}">{{
                        __('application.customer.edit_customer') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.update', ['user' => $user->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right"> {{ __('application.customer.driver_name') }}
                                <span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                <input id="name" type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                    value="{{ old('name') ?? $user->name }}" autocomplete="off" autofocus required>
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="phone_number" class="col-md-3 col-form-label text-md-right">{{
                                __('application.customer.driver_phone_no') }}</label>
                            <div class="col-md-9">
                                <input id="phone_number" type="text"
                                    class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number"
                                    value="{{ old('phone_number') ?? $user->phone_number }}" autocomplete="off">

                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_number" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.id_number') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="id_number" id="id_number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="{{ old('phone_number') ?? $user->id_number }}"/>
                                @if ($errors->has('id_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('id_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vehicle_no" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.vehicle_no') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="vehicle_no" id="vehicle_no" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="{{ old('phone_number') ?? $user->vehicle_no }}" />
                                @if ($errors->has('vehicle_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vehicle_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="driver_owner_name" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.owner_name') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                
                                <input type="text" name="driver_owner_name" id="driver_owner_name" class="form-control{{ $errors->has('driver_owner_name') ? ' is-invalid' : '' }}" value="{{ old('driver_owner_name', $user->driver_owner_name)}}">

                                {{-- <select name="driver_owner_id" id="driver_owner_name" class="form-control{{ $errors->has('driver_owner_id') ? ' is-invalid' : '' }}" >
                                    <option value="0">Select</option>
                                    @foreach($owners as $owner)
                                        <option value="{{$owner->id}}" @if($owner->id == $user->driver_owner_id) selected @endif>{{$owner->name}}</option>
                                    @endforeach
                                </select> --}}

                                @if ($errors->has('driver_owner_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driver_owner_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="owner_phone_no" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.owner_phone_no') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                <input type="text" name="owner_phone_no" id="owner_phone_no" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="{{ old('phone_number') ?? $user->phone_number }}"/>
                                @if ($errors->has('owner_phone_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('owner_phone_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="country_div">
                            <label for="country_id" class="col-md-3 col-form-label text-md-right">
                                {{ __('application.user.country') }}<span class="tcr i-req"></span></label>

                            <div class="col-md-9">
                                <select id="country_id" name="country_id"
                                    class="form-control{{ $errors->has('country_id') ? ' is-invalid' : '' }}" required>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @if (old('country_id',$user->country_id) ==
                                        $country->id) {{ ' selected' }} @endif>
                                        {{ ucfirst($country->name) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state_id" class="col-md-3 col-form-label text-md-right">{{
                                __('application.customer.state') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">
                                <select id="state_id" name="state_id"
                                    class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">

                                </select>
                                @if ($errors->has('state_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city_id" class="col-md-3 col-form-label text-md-right">{{
                                __('application.customer.city') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">
                                <select id="city_id" name="city_id"
                                    class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">

                                </select>
                                @if ($errors->has('city_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row district_id_row">
                            <label for="district_id" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.district') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">                                
                                <select id="district_id" name="district_id" class="select2 form-control{{ $errors->has('district_id') ? ' is-invalid' : '' }}">
                                    <option value="">Select</option>
                                    @foreach($districts as $district)
                                        <option value="{{$district->id}}" @if($district->id == $user->district_id) selected @endif>{{$district->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('district_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('district_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row commune_id_row">
                            <label for="commune_id" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.commune') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">                                
                                <select id="commune_id" name="commune_id" class="select2 form-control{{ $errors->has('commune_id') ? ' is-invalid' : '' }}">       
                                    <option value="">Select</option>
                                </select>
                                @if ($errors->has('commune_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('commune_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="place_div">
                            <label for="place_id" class="col-md-3 col-form-label text-md-right">
                                {{ __('application.user.place') }}<span class="tcr i-req"></span></label>

                            <div class="col-md-9">
                                <select id="place_id" name="place_id"
                                    class="form-control{{ $errors->has('place_id') ? ' is-invalid' : '' }}" required>
                                    @foreach ($places as $place)
                                    <option value="{{ $place->id }}" @if (old('place_id',$user->place_id) == $place->id)
                                        {{ ' selected' }} @endif>
                                        {{ ucfirst($place->name) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('place_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('place_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="floor_id" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.floor') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">
                                <select id="floor_id" name="floor_id"
                                    class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">

                                </select>
                                @if ($errors->has('floor_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('floor_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_id" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.type') }}<span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                <select name="category_id" id="category_id" class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" required>

                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="slot_id" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.slot') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">
                                <select id="slot_id" name="category_wise_floor_slot_id"
                                    class="select2 form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">

                                </select>
                                @if ($errors->has('slot_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('slot_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="tariff_id" class="col-md-3 col-form-label text-md-right">{{ __('application.parking.tariff') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">                             
                                <select id="tariff_id" name="tariff_id" class="select2 form-control{{ $errors->has('tariff_id') ? ' is-invalid' : '' }}">
                                </select>
                                @if ($errors->has('tariff_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tariff_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_at" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.start_at') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">                             
                                <input type="date" id="start_at" name="start_at" class="form-control{{ $errors->has('start_at') ? ' is-invalid' : '' }}" value="{{old('start_at', $user->start_at)}}" />
                                @if ($errors->has('start_at'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('start_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_at" class="col-md-3 col-form-label text-md-right">{{ __('application.customer.end_at') }}<span class="tcr i-req"></span></label>
                            <div class="col-md-9">                             
                                <input type="date" id="end_at" name="end_at" class="form-control{{ $errors->has('end_at') ? ' is-invalid' : '' }}" value="{{old('start_at', $user->end_at)}}" />
                                @if ($errors->has('end_at'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('end_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0 d-flex justify-content-end">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-end">
                                <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                    {{ __('application.user.clear') }}
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    {{ __('application.user.update') }}
                                </button>
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
<script>
    var floors = @json($floors);
    var slots = @json($slots);
    var countries = @json($countries);
    var states = @json($states);
    var cities = @json($cities);
    var categories = @json($categories);
    var tariffs = @json([]);
    var tariffs = @json($tariffs);
    var driverId = 0;
    var tariff_id = "{{$user->tariff_id}}";
    var communes = @json($communes);
    var communeid = "{{$user->commune_id}}";

    setTimeout(() => {
        $('#place_id').trigger('change');
        $('#country_id').trigger('change');

        setTimeout(() => {
            $('#floor_id').trigger('change');
            $('#state_id').trigger('change');
            $('#district_id').trigger('change');
        }, 200);
    }, 100);
    {{--  role_select();
    function role_select(){
        if($('#role').val() == 1){
            $('#place_div').addClass('d-none');
        }
        else{
            $('#place_div').removeClass('d-none');
        }
    }  --}}
    $(document).ready(function() {
        $(".permission_assign").click(function() {
            var checked=true;
            $(this).parent().parent().parent().parent().parent().find(".permission_assign").each(function() {
                if ($(this).is(':checked')==false) {
                    checked=false;
                }
            });
            if(checked)
            {
                $(this).parent().parent().parent().parent().parent().find(".permission_checkbox").prop('checked', true);
            }
            else
            {
                $(this).parent().parent().parent().parent().parent().find(".permission_checkbox").prop('checked', false);
            }
    
        });
    
        $(".permission_checkbox").click(function() {
            if ($(this).is(':checked')) {
                $(this).parent().parent().parent().find(".permission_assign").each(function() {
                    $(this).prop('checked', true);
                });
    
            } else {
                $(this).parent().parent().parent().find(".permission_assign").each(function() {
                    $(this).prop('checked', false);
                });
            }
        });
    });

    $(document).on('change', '#country_id', function(){
        let state = states.filter(val => val.country_id == $(this).val());
        var html = '';
        var selected_state = "{{isset($user) ? $user->state_id : null}}";
        $.each(state, function(ind,val){
            var selected = "";
            if(selected_state == val.id )
            {
                selected = "selected";
            }
            html += `<option value="${val.id}" ${selected}>${val.name}</option>`;
        });

        $(document).find('#state_id').html(html);

        $('#state_id').trigger('change');
    });
    $(document).on('change', '#state_id', function(){
        let city = cities.filter(val => val.state_id == $(this).val());
        var html = '';
        var selected_city = "{{isset($user) ? $user->city_id : null}}";

        $.each(city, function(ind,val){
            var selected = "";
            if(selected_city == val.id )
            {
                selected = "selected";
            }
            html += `<option value="${val.id}" ${selected}>${val.name}</option>`;
        });

        $(document).find('#city_id').html(html);

        $('#city_id').trigger('change');
    });


    $(document).on('change', '#place_id', function(){
        let floor = floors.filter(val => val.place_id == $(this).val());
        var html = '';
        var selected_floor = "{{isset($user) ? $user->floor_id : null}}";
        $.each(floor, function(ind,val){
            var selected = "";
            if(selected_floor == val.id )
            {
                selected = "selected";
            }
            html += `<option value="${val.id}" ${selected}>${val.name}</option>`;
        });

        $(document).find('#floor_id').html(html);

        $('#floor_id').trigger('change');
    });
    $(document).on('change', '#floor_id', function(){
        let slot = slots.filter(val => val.floor_id == $(this).val());
        var html = '';
        var selected_slot = "{{isset($user) ? $user->slot_id : null}}";

        $.each(slot, function(ind,val){
            var selected = "";
            if(selected_slot == val.id )
            {
                selected = "selected";
            }
            html += `<option value="${val.id}" ${selected}>${val.slot_name}</option>`;
        });

        $(document).find('#slot_id').html(html);

        $('#slot_id').trigger('change');
    });

    $(document).on('change', '#district_id', function(){
        let commune = communes.filter(val => val.district_id == $(this).val());
        var html = '<option value="">Select</option>';
        $.each(commune, function(ind,val){
            html += `<option value="${val.id}" ${communeid == val.id ? 'selected' : ''}>${val.name}</option>`;
        });

        $(document).find('#commune_id').html(html);

        $('#commune_id').trigger('change');
    });

    const districtId = $(".district_id_row")
    const communeId = $(".commune_id_row")
    districtId.hide()
    communeId.hide()
    
    $(document).on('change', '#state_id', function(){
        let city = cities.filter(val => val.state_id == $(this).val());

        console.log($(this).val())

        if($(this).val() == 828) {
            districtId.show()
            communeId.show()
        } else {
            districtId.hide()
            communeId.hide()
        }
        var html = '';
        $.each(city, function(ind,val){
            html += `<option value="${val.id}">${val.name}</option>`;
        });

        $(document).find('#city_id').html(html);

        $('#city_id').trigger('change');
    });
</script>
    <script src="{{ assetz('js/custom/settings/parking.js') }}"></script>
@endpush