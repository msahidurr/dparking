@extends('layouts.app')
@section('title', ' - Create New Floor')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('application.role.create_new') }}
                    @can("roles.index")
                    <a class="btn btn-sm btn-info pull-right" href="{{ route('roles.index') }}">{{
                        __('application.role.role_list') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="text-md-right">{{ __('application.role.name') }} <span
                                            class="tcr text-danger">*</span></label>
                                    <input id="name" type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ old('name') }}" autocomplete="off" autofocus>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach ($sections as $section)
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5>{{ $section->name }}</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="checkbox" class="permission_checkbox" /> Select All
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @foreach ($section->permissions as $permission)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{ str_replace('_', ' ', $permission->name)}}</label>
                                                                <input type="checkbox" data-toggle="toggle" class="checkbox_package permission_assign" name="permissions[]" data-onstyle="primary" value="{{ $permission->id }}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="pull-right">
                                    <button type="reset" class="btn  btn-secondary me-2" id="frmClear">
                                        {{ __('application.role.clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        {{ __('application.role.save') }}
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
    $(document).ready(function() {
        $(".permission_assign").click(function() {
            var checked=true;
            $(this).parent().parent().parent().parent().parent().find(".permission_assign").each(function() {
                if ($(this).is(':checked')==false) {
                    checked=false;
                }
            });
            if(checked)
            {
                $(this).parent().parent().parent().parent().parent().find(".permission_checkbox").prop('checked', true);
            }
            else
            {
                $(this).parent().parent().parent().parent().parent().find(".permission_checkbox").prop('checked', false);
            }
    
        });
    
        $(".permission_checkbox").click(function() {
            if ($(this).is(':checked')) {
                $(this).parent().parent().parent().find(".permission_assign").each(function() {
                    $(this).prop('checked', true);
                });
    
            } else {
                $(this).parent().parent().parent().find(".permission_assign").each(function() {
                    $(this).prop('checked', false);
                });
            }
        });
    });
</script>
@endpush