@extends('layouts.app')
@section('title', ' - Set languages')
@section('content')
<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('application.language.set_languages') }}
                        @if ($language->code)
                        for
                        <span class="text-danger font-weight-bold"> ( {{ $language->code }} )</span>
                        @endif
                    </div>
                    <span class="font-weight-bold text-youtube">{{ __('application.language.all_the_fields_are_required')}} (*)</span>
                    @can("languages.index")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('languages.index') }}">{{
                        __('application.language.all_language_list') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('languages.update', ['language' => $language->id]) }}">

                        @csrf

                        @method('PUT')

                        <div class="accordion">
                            @php
                            $oldMenu = NULL
                            @endphp

                            @foreach ($master as $langKey => $langVal)
                            @php
                            $menu = explode('.', $langKey)[0];
                            @endphp
                            @if($oldMenu && ($menu != $oldMenu))
                        </div>
                </div>
            </div>
        </div>
        @endif

        @if($menu != $oldMenu)
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button text-uppercase" type="button" data-bs-toggle="collapse"
                    data-bs-target="#{{ $menu }}" aria-expanded="false" aria-controls="{{ $menu }}">
                    {{ $menu }}
                </button>
            </h2>
            <div id="{{ $menu }}" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#{{ $menu }}">
                <div class="accordion-body">
                    <div class="row">
                        @endif
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="mb-1 text-capitalize" for="{{ $langKey }}">{{ str_replace('_', ' ',
                                    substr($langKey, strpos($langKey, ".")+1)) }} <span
                                        class="text-danger">*</span></label>
                                <input
                                    value="{{ old(str_replace('.', '_', $langKey), (isset($items[$langKey]) ? $items[$langKey] : $langVal)) }}"
                                    id="{{ $langKey }}" name="{{ $langKey }}" type="text" class="form-control">
                                @error(str_replace('.', '_', $langKey))
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @php
                        $oldMenu = $menu;
                        @endphp
                        @if($loop->last)
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    <div class="form-group mb-0 d-flex justify-content-end mt-3">
        <div class="d-flex justify-content-end">
            <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                {{ __('application.language.clear') }}
            </button>
            <button type="submit" class="btn btn-success">
                {{ __('application.language.update') }}
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
<script src="{{ asset('js/custom/languages.js') }}"></script>
@endpush