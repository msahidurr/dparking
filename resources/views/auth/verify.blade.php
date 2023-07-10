@extends('layouts.guest')

@section('content')
<div class="container-fluid vh-100">
    <div class="align-content-center h-100 justify-content-center row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('application.verify.verify_your_email_address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('application.verify.a_fresh_verification_link_has_been_sent_to_your_email_address') }}
                        </div>
                    @endif

                    {{ __('application.verify.before_proceeding_please_check_your_email_for_a_verification_link') }}
                    {{ __('application.verify.if_you_did_not_receive_the_email') }}, <a href="{{ route('verification.resend') }}">{{ __('application.verify.click_here_to_request_another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
