@extends('layouts.app')
@section('title', ' - Edit Category')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    {{ __('application.category.edit_category') }}
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('category.index') }}">{{
                        __('application.category.category_list') }}</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('category.update', ['category' => $category->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_edit" value="1">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="place_id" class="col-form-label">{{ __('application.category.place')
                                        }}<span class="tcr text-danger">*</span></label>
                                    <select name="place_id" required id="place_id"
                                        class="form-control{{ $errors->has('place_id') ? ' is-invalid' : '' }}"
                                        required>
                                        @foreach ($places as $place)
                                        <option value="{{ $place->id }}" {{ old('place_id', $category->place_id)==$place->id ? ' selected' :
                                            ''
                                            }}>
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type" class="col-form-label text-md-right">{{
                                        __('application.category.type') }} <span class="tcr i-req">*</span></label>

                                    <input id="type" type="text"
                                        class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type"
                                        value="{{ old('type') ?? $category->type }}" autocomplete="off" required>

                                    @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status" class="col-form-label text-md-right">{{ __('Status') }} <span
                                            class="tcr i-req">*</span></label>
                                    <select name="status" id="status"
                                        class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                                        <option value="1" {{ ($category->status == 1) ? ' selected' : '' }}>{{
                                            __('application.category.enable') }}</option>
                                        <option value="0" {{ ($category->status == '0') ? ' selected' : '' }}>{{
                                            __('application.category.disable') }}</option>
                                    </select>
                                    @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="description" class="col-form-label text-md-right">{{
                                        __('application.category.description') }}<span class="tcr i-req">*</span>
                                    </label>
                                    <textarea name="description" id="description" cols="5" rows="5"
                                        class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                        required>{{ old('description') ?? $category->description }}</textarea>

                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 d-flex justify-content-end">

                            <div class="col-md-4 d-flex justify-content-end">
                                <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                    {{ __('application.category.clear') }}
                                </button>
                                <button type="submit" class="btn btn-success">
                                    {{ __('application.category.update') }}
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