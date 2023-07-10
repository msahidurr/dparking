@extends('layouts.app')
@section('title', ' - Add Languages')
@section('content')
    <div class="container-fluid mb100">

        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.language.add_language') }}
                        <a class="btn btn-sm btn-primary pull-right"
                            href="{{ route('languages.index') }}">{{ __('application.language.all_language_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('languages.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name" class="col-form-label">{{ __('application.language.language_name') }}<span
                                            class="tcr i-req">*</span> </label>
                                    <input placeholder="Language Name" id="name" type="text"
                                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        name="name" value="{{ old('name') }}" autocomplete="off" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="code" class="col-form-label">{{ __('application.language.language_code') }}<span
                                            class="tcr i-req">*</span> </label>
                                    <input placeholder="Language Code" id="code" type="text"
                                        class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}"
                                        name="code" value="{{ old('code') }}" autocomplete="off" required>
                                    @if ($errors->has('code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="country_id" class="col-form-label">{{ __('application.language.country') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <select name="country_id" required id="country_id"
                                            class="form-control {{ $errors->has('country_id') ? ' is-invalid' : '' }}"
                                            required>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id') == $country->id ? ' selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('country_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label">{{ __('application.language.status') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <select name="status" required id="status"
                                            class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            required>
                                           
                                            <option value="0"
                                                {{ old('status') == 0 ? ' selected' : '' }}>
                                                {{ __('application.language.deactivated') }}
                                            </option>
                                            <option value="1"
                                                {{ old('status') == 1 ? ' selected' : '' }}>
                                                {{ __('application.language.active') }}
                                            </option>
                                            <option value="2"
                                                {{ old('status') == 2 ? ' selected' : '' }}>
                                                {{ __('application.language.default') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3 text-end">
                                <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                    {{ __('application.language.clear') }}
                                </button>
                                <button type="submit" class="btn btn-success">
                                    {{ __('application.language.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
