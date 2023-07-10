@extends('layouts.app')
@section('title', ' - Settings')
@section('content')
    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">{{ __('application.setting.general_setting') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">{{ __('application.setting.site_title') }}</label>
                                        <input type="text" name="site_title" class="form-control"
                                            value="{{ old('site_title') ? old('site_title') : $settings->site_title }}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">{{ __('application.setting.login_image') }} <small
                                                class="font-italic text-info">(1366X768 | 1000kb)</small></label>
                                        <input type="file" name="login_image" class="form-control">
                                        @if ($settings->login_image != null && public_path($settings->login_image) && !is_dir($settings->login_image))
                                            <span>{{ __('application.setting.existing') }}: <a target="_blank"
                                                    href="{{ asset($settings->login_image) }}">{{ __('application.setting.view') }}</a></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">{{ __('application.setting.logo') }} <small
                                                class="font-italic text-info">(150X50 | 500kb)</small></label>
                                        <input type="file" name="logo" class="form-control">
                                        @if ($settings->logo != null && public_path($settings->logo) && !is_dir($settings->logo))
                                            <span>{{ __('application.setting.existing') }}: <a target="_blank"
                                                    href="{{ asset($settings->logo) }}">{{ __('application.setting.view') }}</a></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">{{ __('application.setting.favicon') }} <small
                                                class="font-italic text-info">(64X64 | 50kb)</small></label>
                                        <input type="file" name="favicon" class="form-control">
                                        @if ($settings->favicon != null && public_path($settings->favicon) && !is_dir($settings->favicon))
                                            <span>{{ __('application.setting.existing') }}: <a target="_blank"
                                                    href="{{ asset($settings->favicon) }}">{{ __('application.setting.view') }}</a></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success pull-right"
                                        type="submit">{{ __('application.setting.save_change') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
