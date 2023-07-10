@extends('layouts.app')
@section('title', ' - Create New State')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('application.state.add_state') }}
                    @can("states.index")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('states.index') }}">{{
                        __('application.state.state_list') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('states.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="text-md-right">{{ __('application.state.name') }}<span
                                            class="tcr text-danger">*</span></label>
                                    <input type="text" required
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        value="{{ old('name') }}" name="name">
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_id" class="text-md-right">{{ __('application.state.country') }} <span
                                            class="tcr text-danger">*</span></label>
                                    <select name="country_id" id="country_id" required
                                        class="form-control {{ $errors->has('country_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ ( old('country_id')==$country->id ? ' selected' : ($country->default ? ' selected' : ''))  }}>
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
                            <div class="col-12">
                                <div class="pull-right d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                        {{ __('application.state.clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('application.state.create_new') }}
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