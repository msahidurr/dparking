@auth
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_title ? $settings->site_title : config('app.name', 'Demo Parking') }}
        @yield('title')
    </title>
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->

    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <!-- End plugin css for this page -->
    <!-- datatable css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatable/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/datatable/buttons.bootstrap4.min.css') }}" />

    <!-- sweet-alert2 css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweet-alert2/sweetalert2.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendors/datepicker/jquery.datetimepicker.min.css') }}" />

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ assetz('assets/css/main/style.css') }}" />
    <link rel="stylesheet" href="{{ assetz('css/site.css') }}" />

    <!--  select 2  -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset($settings->favicon) }}" />
    
    @include('includes_for_css.universal_styles_admin')
    @stack('css')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="profile pl-0">
                <li class="nav-item">
                    <a class="nav-link d-block" href="{{ url('/') }}">
                        <img class="sidebar-brand-logo" src="{{ asset($settings->logo) }}" alt="" />
                    </a>
                </li>
                <li class="pt-2 pb-1">
                    <span class="nav-item-head">{{ __('application.moto.the_best_parking_solution') }}</span>
                </li>
            </ul>
            <ul class="nav">
                <li class="nav-item"></li>
                <li class="pt-2 pb-1 my-0 py-0"></li>
                @can("dashboard.index")
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="mdi mdi-compass-outline menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.dashboard') }}</span>
                    </a>
                </li>
                @endcan
                @if (Auth::user()->hasAnyPermission(["users.index","users.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-user-management" aria-expanded="false"
                        aria-controls="ui-user-management">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.user') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-user-management">
                        <ul class="nav flex-column sub-menu">
                            @can("users.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.create') }}">{{ __('application.menu.add_user')
                                    }}</a>
                            </li>
                            @endcan
                            @can("users.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.list') }}">{{ __('application.menu.user_list')
                                    }}
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif

                @if (Auth::user()->hasAnyPermission(["customers.index","customers.create"]))
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-customer-management" aria-expanded="false"
                            aria-controls="ui-customer-management">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">{{ __('application.menu.customer') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-customer-management">
                            <ul class="nav flex-column sub-menu">
                                @can("customers.create")
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customer.create') }}">{{ __('application.menu.add_customer')
                                        }}</a>
                                </li>
                                @endcan
                                @can("customers.index")
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customer.list') }}">{{ __('application.menu.customer_list')
                                        }}
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["roles.index","roles.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-role-management" aria-expanded="false"
                        aria-controls="ui-role-management">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.role') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-role-management">
                        <ul class="nav flex-column sub-menu">
                            @can("roles.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('roles.create') }}">{{ __('application.menu.add_role')
                                    }}</a>
                            </li>
                            @endcan
                            @can("roles.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('roles.index') }}">{{ __('application.menu.role_list')
                                    }}
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["countries.index","countries.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-country-management" aria-expanded="false"
                        aria-controls="ui-country-management">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.country') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-country-management">
                        <ul class="nav flex-column sub-menu">
                            @can("countries.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('countries.create') }}">{{ __('application.menu.add_country')
                                    }}</a>
                            </li>
                            @endcan
                            @can("countries.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('countries.index') }}">{{ __('application.menu.country_list')
                                    }}
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["states.index","states.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-state-management" aria-expanded="false"
                        aria-controls="ui-state-management">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.state') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-state-management">
                        <ul class="nav flex-column sub-menu">
                            @can("states.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('states.create') }}">{{ __('application.menu.add_state')
                                    }}</a>
                            </li>
                            @endcan
                            @can("states.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('states.index') }}">{{ __('application.menu.state_list')
                                    }}
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["cities.index","cities.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-city-management" aria-expanded="false"
                        aria-controls="ui-city-management">
                        <i class="mdi mdi-account menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.city') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-city-management">
                        <ul class="nav flex-column sub-menu">
                            @can("cities.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cities.create') }}">{{ __('application.menu.add_city')
                                    }}</a>
                            </li>
                            @endcan
                            @can("cities.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cities.index') }}">{{ __('application.menu.city_list')
                                    }}
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["places.create","places.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-place-management" aria-expanded="false"
                        aria-controls="ui-place-management">
                        <i class="mdi mdi-wrap-disabled menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.place') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-place-management">
                        <ul class="nav flex-column sub-menu">
                            @can("places.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('places.create') }}">{{
                                    __('application.menu.add_place') }}</a>
                            </li>
                            @endcan
                            @can("places.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('places.index') }}">{{
                                    __('application.menu.place_list') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["categories.index","categories.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-category" aria-expanded="false"
                        aria-controls="ui-category">
                        <i class="mdi mdi-tag-multiple menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.category') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-category">
                        <ul class="nav flex-column sub-menu">
                            @can("categories.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('category.create') }}">{{
                                    __('application.menu.add_category') }}</a>
                            </li>
                            @endcan
                            @can("categories.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('category.index') }}">{{
                                    __('application.menu.category_list') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["floors.index","floors.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-floor" aria-expanded="false"
                        aria-controls="ui-floor">
                        <i class="mdi mdi-layers menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.floor') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-floor">
                        <ul class="nav flex-column sub-menu">
                            @can("floors.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('floors.create') }}">{{
                                    __('application.menu.add_floor') }}</a>
                            </li>
                            @endcan
                            @can("floors.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('floors.index') }}">{{
                                    __('application.menu.floor_list') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["tariffs.index","tariffs.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-tariff" aria-expanded="false"
                        aria-controls="ui-tariff">
                        <i class="mdi mdi mdi-cash-multiple menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.tariff') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-tariff">
                        <ul class="nav flex-column sub-menu">
                            @can("tariffs.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tariff.create') }}">{{
                                    __('application.menu.add_tariff') }}</a>
                            </li>
                            @endcan
                            @can("tariffs.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tariff.index') }}">{{
                                    __('application.menu.tariff_list') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["slots.index","slots.create","rfids.index","rfids.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-parking-setup" aria-expanded="false"
                        aria-controls="ui-parking-setup">
                        <i class="mdi mdi mdi-home-map-marker menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.parking_setup') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-parking-setup">
                        <ul class="nav flex-column sub-menu">
                            @can("slots.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking_settings.create') }}">{{
                                    __('application.menu.add_slot') }}</a>
                            </li>
                            @endcan
                            @can("slots.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking_settings.index') }}">{{
                                    __('application.menu.slot_list') }}</a>
                            </li>
                            @endcan
                            @can("rfids.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking_settings.rfid_vehicles.create') }}">{{
                                    __('application.menu.add_rfid_vehicles') }}</a>
                            </li>
                            @endcan
                            @can("rfids.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking_settings.rfid_vehicles.index') }}">{{
                                    __('application.menu.rfid_vehicles_list') }}</a>
                            </li>
                            @endcan
                            @can("rfids.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking_settings.rfid_vehicles.endpoint') }}">{{
                                    __('application.menu.rfid_endpoint') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["parkings.index","parkings.create","parkings.current","parkings.ended"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-parking" aria-expanded="false"
                        aria-controls="ui-parking">
                        <i class="mdi mdi-car menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.parking') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-parking">
                        <ul class="nav flex-column sub-menu">
                            @can("parkings.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking.create') }}">{{
                                    __('application.menu.add_parking') }}</a>
                            </li>
                            @endcan
                            @can("parkings.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking.index') }}">{{
                                    __('application.menu.all_parking_list') }}</a>
                            </li>
                            @endcan
                            @can("parkings.current")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking.current_list') }}">{{
                                    __('application.menu.currnetly_parking_list') }}</a>
                            </li>
                            @endcan
                            @can("parkings.ended")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('parking.ended_list') }}">{{
                                    __('application.menu.ended_parking_list') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["reports.summary","reports.slot","reports.detail"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-report" aria-expanded="false"
                        aria-controls="ui-report">
                        <i class="mdi mdi mdi-home-map-marker menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.reports') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-report">
                        <ul class="nav flex-column sub-menu">
                            @can("reports.summary")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.summary') }}">{{
                                    __('application.menu.summary_report') }}</a>
                            </li>
                            @endcan
                            @can("reports.detail")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.details_report') }}">{{
                                    __('application.menu.details_report') }}</a>
                            </li>
                            @endcan
                            @can("reports.slot")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reports.slots_report') }}">{{
                                    __('application.menu.slots_report') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["settings.index","activation.index"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-setting" aria-expanded="false"
                        aria-controls="ui-setting">
                        <i class="mdi mdi-brightness-7 menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.settings') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-setting">
                        <ul class="nav flex-column sub-menu">
                            @can("settings.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('settings.create') }}">{{ __('application.menu.global_setting') }}</a>
                            </li>
                            @endcan
                            @can("activation.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('activation.active_form') }}">{{ __('application.menu.activation') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(["languages.index","languages.create"]))
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-language" aria-expanded="false"
                        aria-controls="ui-language">
                        <i class="mdi mdi-translate menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.language') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-language">
                        <ul class="nav flex-column sub-menu">
                            @can("languages.create")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('languages.create') }}">{{
                                    __('application.menu.add_language') }}</a>
                            </li>
                            @endcan
                            @can("languages.index")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('languages.index') }}">{{
                                    __('application.menu.all_language') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>                
                @endif
                @can("profile.index")
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.profile') }}">
                        <i class="mdi mdi-ticket-account menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.my_profile') }}</span>
                    </a>
                </li>
                @endif
                @can("back.index")
                <li class="nav-item">
                    <a class="nav-link" href="javascript:window.history.go(-1);">
                        <i class="mdi mdi-chevron-double-left menu-icon"></i>
                        <span class="menu-title">{{ __('application.menu.go_back') }}</span>
                    </a>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-chevron-double-left"></span>
                    </button>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo-mini" href="{{ route('home') }}"><img
                                src="{{ asset($settings->logo) }}" alt="logo" /></a>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown d-none">
                            <a class="nav-link" id="messageDropdown" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-email-outline"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list"
                                aria-labelledby="messageDropdown">
                                <h6 class="p-3 mb-0 font-weight-semibold">{{ __('Messages') }}</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="#" alt="image" alt="" class="profile-pic">
                                    </div>
                                    <div
                                        class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="preview-subject ellipsis mb-1 font-weight-normal">
                                            {{ __('Mark send you a message') }}</h6>
                                        <p class="text-gray mb-0"> {{ __('1 minutes ago') }}</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <h6 class="p-3 mb-0 text-center text-primary font-13">4 new messages</h6>
                            </div>
                        </li>
                        <li class="nav-item dropdown ms-3 d-none">
                            <a class="nav-link" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list"
                                aria-labelledby="notificationDropdown">
                                <h6 class="px-3 py-3 font-weight-semibold mb-0">Notifications</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="mdi mdi-calendar"></i>
                                        </div>
                                    </div>
                                    <div
                                        class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="preview-subject font-weight-normal mb-0">New order recieved</h6>
                                        <p class="text-gray ellipsis mb-0"> 45 sec ago </p>
                                    </div>
                                </a>

                                <div class="dropdown-divider"></div>
                                <h6 class="p-3 font-13 mb-0 text-primary text-center">View all notifications</h6>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown d-none d-md-block">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="nav-profile-text"><i
                                        class="mdi mdi-account-circle mb-1 position-relative t-2"></i><span>{{
                                        auth()->user()->name }}</span>
                                </div>
                            </a>
                            <div class="dropdown-menu center navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="mdi mdi-account-box me-3"></i> {{ __('application.menu.profile') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" id="logOut">
                                    <i class="mdi mdi-logout-variant me-3"></i> {{ __('application.menu.logout') }}
                                </a>
                                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper pb-0">

                    <!-- first row starts here -->
                    <?php	
						$msg = session('flashMsg') ?? $flashMsg ?? null;
						if ($msg) {
					?>
                    <div class="d-none flashMessage">
                        <div id="msgType">{{ $msg['type'] }}</div>
                        <div id="msg">{{ $msg['msg'] }}</div>
                    </div>
                    <?php
						}
					?>
                    @yield('content')

                    <!-- content-wrapper ends -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>

        <!-- container-scroller -->
        <!--datatable-->
        <script src="{{ asset('assets/js/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatable/buttons.print.min.js') }}"></script>

        <!-- sweet-alert2 css -->
        <link rel="stylesheet" href="{{ asset('assets/vendors/sweet-alert2/sweetalert2.min.css') }}" />

        <!-- Plugin js for this page -->
        <script src="{{ assetz('js/app.js') }}"></script>
        <script type="text/javascript">
            Ziggy.url = "{{ url('/') }}";
                @if ($_SERVER['SERVER_PORT'] != 80 || $_SERVER['SERVER_PORT'] != 443)
                    Ziggy.port = {{ $_SERVER['SERVER_PORT'] }};
                @endif
        </script>
        <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('assets/js/misc.js') }}"></script>
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/settings.js') }}"></script>
        <script src="{{ asset('assets/js/todolist.js') }}"></script>
        <script src="{{ asset('assets/vendors/datepicker/jquery.datetimepicker.full.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/sweet-alert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ assetz('js/site.js') }}"></script>
        @stack('scripts')
        <!-- endinject -->
        <!-- End custom js for this page -->
        <script>
            const currentPath = '{{ request()->path() }}';
        </script>
</body>

</html>
@endauth
@guest
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings->site_title ? $settings->site_title : config('app.name', 'dParking') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($settings->favicon) }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ assetz('assets/css/style.css') }}" />
    <link href="{{ assetz('css/public_site.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="nav-bg">
            <div class="container">
                <a class="m-0 navbar-brand p-0 color-white" href="{{ url('/') }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" id="guest-log-out">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
@endguest