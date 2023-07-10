@extends('layouts.app')
@section('title', ' - Edit Floor')
@section('content')
<div class="container-fluid mb100">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('application.role.edit_role') }}
                    @can("roles.index")
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('roles.index') }}">{{ __('application.role.role_list') }}</a>
                    @endcan
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('roles.update',['role' => $role->id]) }}">
                        @csrf   
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="text-md-right">{{ __('application.role.name') }} <span class="tcr text-danger">*</span></label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ (old('name')) ?? $role->name }}" autocomplete="off" required autofocus>
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
                                                                <input type="checkbox" data-toggle="toggle" class="checkbox_package permission_assign" name="permissions[]" data-onstyle="primary" {{ in_array($permission->id,$role->permissions->pluck('id')->toArray())? "checked":'' }} value="{{ $permission->id }}">
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
                            <div class="col-12 d-flex justify-content-end">
                                <div class="pull-right d-flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary me-2" id="frmClear">
                                        {{ __('application.role.clear') }}
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        {{ __('application.role.update') }}
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