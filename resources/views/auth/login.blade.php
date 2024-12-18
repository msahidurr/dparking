@extends('layouts.guest')

@section('content')
<section class="landing_page">
    <div class="top_bar">
      <div class="container">
        <img class="sidebar-brand-logo" src="{{asset($settings->logo)}}" alt="" />
        

        <div class="sign_in_wrapper">
          <a class="btn btn-outline-light px-4" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">{{__('application.login.login')}}</a>
          <div class="collapse sign_in_collapse multi-collapse" id="multiCollapseExample1">
            <div class="card card-body">
           
              
              <div id="login-page">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <h1 class="title">{{ __('application.login.admin_login') }}</h1>
        
                            <form method="POST" id="loginForm" action="{{ route('login') }}">
                                @csrf
    
                                <div class="form-group">
                                    <label for="email" class="col-form-label text-md-right">{{ __('application.login.email_address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                        value="{{ old('email') ? old('email') : (env('DEMO', false) ? env('ADMIN_EMAIL', NULL) : '') }}" placeholder="{{ __('application.login.email_address') }}" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
    
                                <div class="form-group">
                                    <label for="password" class="text-md-right">{{ __('application.login.password') }}</label>
                                    <input id="password" type="password" value="{{ env('DEMO', false) ? env('ADMIN_PASSWORD', NULL) : '' }}" placeholder="*****"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                        required>
    
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
    
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input m-1" type="checkbox" name="remember" id="remember" {{
                                            old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('application.login.remember_me') }}
                                        </label>
                                    </div>
                                </div>
    
                                <div class="form-group mb-0">
                                    <button type="submit" class="col-12 f18 btn btn-car">
                                        {{ __('application.login.login') }}
                                    </button>
                                    @if(env('DEMO', false))
                                    <div class="pt-2 text-center text-danger">{{ __('application.login.just_click_the_above_button_to_login') }}</div>
                                    <div class="pt-3 text-center">
                                        <div class="btn btn-outline-twitter btn-xs btn-credential" data-email="{{ env('ADMIN_EMAIL', NULL) }}" data-password="{{ env('ADMIN_PASSWORD', NULL) }}">Admin Credential</div>
                                        <div class="btn btn-outline-twitter btn-xs btn-credential" data-email="{{ env('OPERATOR_EMAIL', NULL) }}" data-password="{{ env('OPERATOR_PASSWORD', NULL) }}">Operator Credential</div>
                                    </div>
                                    @endif
    
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link text-car pl-lg-0 pt-3" href="{{ route('password.request') }}">
                                        {{ __('application.login.forgot_your_password') }}
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="bottom_content">
      <div class="container">
          <div class="row">
            <div class="col-lg-7">
              <h1 class="title home">{{ __('application.login.the_best_parking_management_system')}}</h1>
              <h5>{{__('application.login.page_details')}}</h5>
            </div>
            <div class="col-lg col-sm-6 ml-lg-auto">
              {{-- <div class="icons_wrapper">
                  <div class="row">
                      <div class="col-sm-6 col-sm-3 col-6">
                          <i class="flaticon-team"></i>
                      </div>
                      <div class="col-sm-6 col-sm-3 col-6">
                          <i class="flaticon-stats"></i>
                      </div>
      
                      <div class="col-sm-6 col-sm-3 col-6">
                          <i class="flaticon-agile"></i>
                      </div>
                      <div class="col-sm-6 col-sm-3 col-6">
                          <i class="flaticon-deadline"></i>
                      </div>
                  </div>
              </div> --}}
              <div class="anim_pic"><img src="{{ asset('assets/img/valet-parking.png') }}" class="img-fluid" alt=""></div>
            </div>
          </div>
      </div>
    </div>
    

</section>
  


<section class="copyright-area">
<footer>
    <div class="container">
    <div class="row align-items-center">
        <div class="col-lg text-lg-left text-center">
        <span class="footerbottom">{{ trans('application.login.copy_right')}}</span>
        </div>
        <div class="col-lg text-lg-right text-center">
        <span class="footerbottom mr-4 powered">Alimenté par </span> <img src="{{asset('assets/img/africinc_white.png')}}" class="copyright_logo" alt="" width="80">
        </div>
    </div>
    </div>
</footer>
</section>
@endsection