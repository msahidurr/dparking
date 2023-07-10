@extends('layouts.app')
@section('title', ' - Edit Country')
@section('content')
    <div class="container-fluid mb100">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.country.edit_country') }}
                        @can("countries.index")
                        <a class="btn btn-sm btn-primary pull-right"
                            href="{{ route('countries.index') }}">{{ __('application.country.country_list') }}</a>
                        @endcan
                    </div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('countries.update', ['country' => $country->id]) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="is_edit" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="text-md-right">{{ __('application.country.name') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <input type="text" required
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            value="{{ old('name', $country->name) }}"
                                            name="name">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="short_code" class="text-md-right">{{ __('application.country.short_code') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <input type="text" required
                                            class="form-control{{ $errors->has('short_code') ? ' is-invalid' : '' }}"
                                            value="{{ old('short_code', $country->short_code) }}"
                                            name="short_code">
                                        @if ($errors->has('short_code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('short_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_code" class="text-md-right">{{ __('application.country.phone_code') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <input type="text" required
                                            class="form-control{{ $errors->has('phone_code') ? ' is-invalid' : '' }}"
                                            value="{{ old('phone_code', $country->phone_code) }}"
                                            name="phone_code">
                                        @if ($errors->has('phone_code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone_code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="pull-right d-flex justify-content-end">
                                        <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                            {{ __('application.country.clear') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('application.country.update') }}
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