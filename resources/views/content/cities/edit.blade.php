@extends('layouts.app')
@section('title', ' - Edit City')
@section('content')
    <div class="container-fluid mb100">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.city.edit_city') }}
                        @can("cities.index")
                        <a class="btn btn-sm btn-primary pull-right"
                            href="{{ route('cities.index') }}">{{ __('application.city.city_list') }}</a>
                        @endcan
                    </div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('cities.update', ['city' => $city->id]) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="is_edit" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="text-md-right">{{ __('application.city.name') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <input type="text" required
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            value="{{ old('name', $city->name) }}"
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
                                        <label for="country_id" class="text-md-right">{{ __('application.city.country') }} <span
                                                class="tcr text-danger">*</span></label>
                                        <select name="country_id" id="country_id" required
                                            class="form-control {{ $errors->has('country_id') ? ' is-invalid' : '' }}"
                                            required>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country_id', $city->state->country_id) == $country->id ? ' selected' :
                                                '' }}>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state_id"
                                            class="text-md-right">{{ __('application.city.state') }}<span
                                                class="tcr text-danger">*</span></label>
                                        <select name="state_id" required id="state_id"
                                            class="form-control{{ $errors->has('state_id') ? ' is-invalid' : '' }}"
                                            required>
                                            <option value="{{ $city->state_id }}">{{ $city->state->name }}</option>
                                        </select>

                                        @if ($errors->has('state_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('state_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="pull-right d-flex justify-content-end">
                                        <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                            {{ __('application.city.clear') }}
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('application.city.update') }}
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
    var states = @json($states);
    setTimeout(() => {
        $('#country_id').trigger('change');
    }, 100);

    $(document).on('change', '#country_id', function(){
        let state = states.filter(val => val.country_id == $(this).val());
        var html = '';
        var selected_state = "{{isset($city) ? $city->state_id : null}}";
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
</script>
@endpush