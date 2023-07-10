@extends('layouts.app')
@section('title', ' - Create New Place')
@section('content')
    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.place.add_place') }}
                        <a class="btn btn-sm btn-info pull-right"
                            href="{{ route('places.index') }}">{{ __('application.place.place_list') }}</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('places.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="text-md-right">{{ __('application.place.name') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <input id="name" type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" value="{{ old('name') }}" autocomplete="off" autofocus>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name"
                                            class="text-md-right">{{ __('application.place.description') }}</label>
                                        <textarea name="description" id="description"
                                            class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="2"></textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="pull-right">
                                        <button type="reset" class="btn  btn-secondary me-2" id="frmClear">
                                            {{ __('application.place.clear') }}
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('application.place.save') }}
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
