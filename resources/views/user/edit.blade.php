@extends('layouts.app')
@section('title', ' - Edit User')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('application.user.edit_user') }}
                    @can("users.index")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('user.list') }}">{{
                        __('application.user.user_list') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', ['user' => $user->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right"> {{ __('Name') }}
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
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.email_address') }} <span class="tcr i-req">*</span> </label>
                            <div class="col-md-9">
                                <input id="email" type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                    value="{{ old('email') ?? $user->email }}" autocomplete="off" required>
                                <span class="form-text text-muted">
                                    {{ __('application.user.this_email_will_be_used_as_your_login_email') }}
                                </span>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.phone_number') }}</label>
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
                            <label for="address" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.address') }}</label>
                            <div class="col-md-9">

                                <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" autocomplete="off">{{ old('address') ?? $user->address }}</textarea>

                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="language_div">
                            <label for="language_id" class="col-md-3 col-form-label text-md-right">
                                {{ __('application.user.language') }}<span class="tcr i-req"></span></label>

                            <div class="col-md-9">
                                <select id="language_id" name="language_id"
                                    class="form-control{{ $errors->has('language_id') ? ' is-invalid' : '' }}" required>
                                    @foreach ($languages as $language)
                                    <option value="{{ $language->id }}" @if (old('language_id')==$language->id) {{ '
                                        selected' }} @endif>
                                        {{ ucfirst($language->name) }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('language_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('language_id') }}</strong>
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
                                __('application.user.state') }}<span class="tcr i-req"></span></label>
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
                                __('application.user.city') }}<span class="tcr i-req"></span></label>
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

                        <div class="form-group row">
                            <label for="role" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.role') }} <span class="tcr i-req">*</span></label>

                            <div class="col-md-9">
                                <select id="role" name="role" onchange="role_select()"
                                    class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if ($user->hasRole($role->name)) selected @endif>
                                        {{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="required_role" value="true">
                                @if ($errors->has('role'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.password') }}<span class="tcr i-req">*</span></label>

                            <div class="col-md-9">
                                <input id="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{
                                __('application.user.confirm_password') }}
                                <span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation">
                            </div>
                        </div>
                        @if (!auth()->user()->hasAllPermissions(allpermissions()))
                        <div class="form-group row">
                            <label for="currentPassword" class="col-md-3 col-form-label text-md-right">
                                {{ __('Old Password') }} <span class="tcr i-req">*</span></label>
                            <div class="col-md-9">
                                <input id="currentPassword" type="password"
                                    class="form-control{{ $errors->has('currentPassword') ? ' is-invalid' : '' }}"
                                    name="currentPassword">
                                <span class="form-text text-muted">
                                    You need to provide your current password to update profile
                                </span>
                                @if ($errors->has('currentPassword'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('currentPassword') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    @foreach ($sections as $section)
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>{{ $section->name }}</h5>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="checkbox" class="permission_checkbox" /> Select All
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach ($section->permissions as $permission)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ str_replace('_', ' ', $permission->name)}}</label>
                                                        <input type="checkbox" data-toggle="toggle"
                                                            class="checkbox_package permission_assign"
                                                            name="permissions[]" data-onstyle="primary" {{
                                                            in_array($permission->id,$user->permissions->pluck('id')->toArray())?
                                                        "checked":'' }} value="{{ $permission->id }}">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
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


    setTimeout(() => {
        $('#place_id').trigger('change');
        $('#country_id').trigger('change');

        setTimeout(() => {
            $('#floor_id').trigger('change');
            $('#state_id').trigger('change');
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
</script>
@endpush