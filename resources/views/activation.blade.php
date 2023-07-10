@extends('layouts.app')
@section('title', ' - Activation')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Product Activation
                </div>

                <div class="card-body">
                    <form method="POST" id="licenseForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="domain" class="col-form-label">Domain Name<span
                                            class="tcr i-req">*</span> </label>
                                    <input id="domain" type="url"
                                        class="form-control {{ $errors->has('domain') ? ' is-invalid' : '' }}"
                                        name="domain" value="{{ old('domain') }}" autocomplete="off" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code" class="col-form-label">Codecanyon Purchase Code<span
                                            class="tcr i-req">*</span> </label>
                                    <input id="code" type="text"
                                        class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" name="code"
                                        value="{{ old('code') }}" autocomplete="off" required>
                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" id="submitBtn" class="pull-right btn btn-success">
                                Active
                            </button>
                            <button type="reset" class="pull-right btn btn-secondary me-2" id="frmClear">
                                Clear
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ assetz('js/custom/activation.js') }}"></script>
@endpush
