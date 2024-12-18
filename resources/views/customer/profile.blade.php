@extends('layouts.app')
@section('title', ' - User Profile')
@section('content')
    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('application.profile.user_profile') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.profile.update', ['user' => Auth::user()->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('application.profile.name') }} <span
                                        class="tcr i-req">*</span></label>
                                <div class="col-md-7">
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
                                <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('application.profile.email') }}
                                    <span class="tcr i-req">*</span></label>
                                <div class="col-md-7">
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ old('email') ?? $user->email }}" autocomplete="off"
                                        required>
                                    <span class="form-text text-muted">
                                        {{ __('application.profile.this_email_will_be_used_as_your_login_email') }}
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

                                <div class="col-md-7">
                                    <select id="language_id" name="language_id"
                                        class="form-control{{ $errors->has('language_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}"
                                                @if (old('language_id', $user->language_id) == $language->id) {{ ' selected' }} @endif>
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
                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-3 col-form-label text-md-right">{{ __('application.profile.password') }}</label>
                                <div class="col-md-7">
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
                                    class="col-md-3 col-form-label text-md-right">{{ __('application.profile.confirm_password') }}</label>

                                <div class="col-md-7">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="currentPassword"
                                    class="col-md-3 col-form-label text-md-right">{{ __('application.profile.current_password') }}
                                    <span class="tcr i-req">*</span></label>
                                <div class="col-md-7">
                                    <input id="currentPassword" type="password"
                                        class="form-control{{ $errors->has('currentPassword') ? ' is-invalid' : '' }}"
                                        name="currentPassword" required>
                                    <span class="form-text text-muted">
                                        {{ __('application.profile.you_need_to_provide_your_current_password_to_update_profile') }}
                                    </span>
                                    @if ($errors->has('currentPassword'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('currentPassword') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-10 text-end">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('application.profile.update') }}
                                    </button>
                                    <button type="reset" class="btn btn-secondary" id="frmClear">
                                        {{ __('application.profile.clear') }}
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
