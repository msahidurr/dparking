@extends('layouts.app')
@section('title', ' - Edit Parking Slot')
@section('content')
    <div class="container-fluid mb100">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.slot.edit_slot') }}
                        <a class="btn btn-sm btn-primary pull-right"
                            href="{{ route('parking_settings.index') }}">{{ __('application.slot.slot_list') }}</a>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('parking_settings.update', ['parking_setting' => $parking_setting->id]) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="is_edit" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="place_id" class="text-md-right">{{ __('application.slot.place') }} <span
                                                class="tcr text-danger">*</span></label>
                                        <select name="place_id" id="place_id" required
                                            class="form-control {{ $errors->has('place_id') ? ' is-invalid' : '' }}"
                                            required>
                                            @foreach ($places as $place)
                                            <option value="{{ $place->id }}" {{ old('place_id', $parking_setting->place_id) == $place->id ? ' selected' :
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
                                        <label for="category_id"
                                            class="text-md-right">{{ __('application.slot.category') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <select name="category_id" required id="category_id"
                                            class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}"
                                            required>
                                            <option value="{{ $parking_setting->category_id }}">{{ $parking_setting->category->type }}</option>
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
                                        <label for="floor_id" class="text-md-right">{{ __('application.slot.floor') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <select name="floor_id" id="floor_id" required
                                            class="form-control{{ $errors->has('floor_id') ? ' is-invalid' : '' }}"
                                            required>
                                           <option value="{{ $parking_setting->floor_id }}">{{ $parking_setting->floor->name }}</option>
                                        </select>

                                        @if ($errors->has('floor_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('floor_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slot_name" class="text-md-right">{{ __('application.slot.name') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <input type="text" required
                                            class="form-control{{ $errors->has('slot_name') ? ' is-invalid' : '' }}"
                                            value="{{ old('slot_name', $parking_setting->slot_name) }}"
                                            name="slot_name">
                                        @if ($errors->has('slot_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('slot_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="identity"
                                            class="text-md-right">{{ __('application.slot.identity') }}</label>
                                        <input type="text"
                                            class="form-control{{ $errors->has('identity') ? ' is-invalid' : '' }}"
                                            value="{{ old('identity', $parking_setting->identity) }}" name="identity">
                                        @if ($errors->has('identity'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('identity') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remarks"
                                            class="text-md-right">{{ __('application.slot.remarks') }}</label>
                                        <textarea
                                            class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}"
                                            value="{{ old('remarks', $parking_setting->remarks) }}" name="remarks"></textarea>
                                        @if ($errors->has('remarks'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('remarks') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="pull-right d-flex justify-content-end">
                                        <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                            {{ __('application.slot.clear') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('application.slot.update') }}
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
<script>
    var floors = @json($floors);
</script>
<script src="{{ assetz('js/custom/settings/parking_setting.js') }}"></script>
@endpush