@extends('layouts.app')
@section('title', ' - Edit User')
@section('content')
    <div class="container-fluid mb100">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.user.edit_user') }}
                        <a class="btn btn-sm btn-primary pull-right"
                            href="{{ route('user.list') }}">{{ __('application.user.user_list') }}</a>
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
                                <label for="email"
                                    class="col-md-3 col-form-label text-md-right">{{ __('application.user.email_address') }} <span
                                        class="tcr i-req">*</span> </label>
                                <div class="col-md-9">
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ old('email') ?? $user->email }}" autocomplete="off"
                                        required>
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
                            <div class="form-group row" id="language_div">
                                <label for="language_id" class="col-md-3 col-form-label text-md-right">
                                    {{ __('application.user.language') }}<span class="tcr i-req"></span></label>

                                <div class="col-md-9">
                                    <select id="language_id" name="language_id"
                                        class="form-control{{ $errors->has('language_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}"
                                                @if (old('language_id') == $language->id) {{ ' selected' }} @endif>
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
                            <div class="form-group row d-none" id="place_div">
                                <label for="place_id" class="col-md-3 col-form-label text-md-right">
                                    {{ __('application.user.place') }}<span class="tcr i-req"></span></label>

                                <div class="col-md-9">
                                    <select id="place_id" name="place_id"
                                        class="form-control{{ $errors->has('place_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($places as $place)
                                            <option value="{{ $place->id }}"
                                                @if (old('place_id') == $place->id) {{ ' selected' }} @endif>
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
                                <label for="role"
                                    class="col-md-3 col-form-label text-md-right">{{ __('application.user.role') }} <span
                                        class="tcr i-req">*</span></label>

                                <div class="col-md-9">
                                    <select id="role" name="role" onchange="role_select()"
                                        class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if ($user->hasRole($role->name)) selected @endif>
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
                                <label for="password"
                                    class="col-md-3 col-form-label text-md-right">{{ __('application.user.password') }}<span
                                        class="tcr i-req">*</span></label>

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
                                <label for="password-confirm"
                                    class="col-md-3 col-form-label text-md-right">{{ __('application.user.confirm_password') }}
                                    <span class="tcr i-req">*</span></label>
                                <div class="col-md-9">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation">
                                </div>
                            </div>
                            @if (!auth()->user()->hasRole('admin'))
                                <div class="form-group row">
                                    <label for="currentPassword" class="col-md-3 col-form-label text-md-right">
                                        {{ __('Old Password') }} <span class="tcr i-req">*</span></label>
                                    <div class="col-md-9">
                                        <input id="currentPassword" type="password"
                                            class="form-control{{ $errors->has('currentPassword') ? ' is-invalid' : '' }}"
                                            name="currentPassword" required>
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
    role_select();
    function role_select(){
        if($('#role').val() == 1){
            $('#place_div').addClass('d-none');
        }
        else{
            $('#place_div').removeClass('d-none');
        }
    }
</script>
@endpush
