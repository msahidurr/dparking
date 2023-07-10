@extends('layouts.app')
@section('title', ' - User List')
@section('content')
    <div class="container-fluid mb100">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('application.user.user_list') }}
                        <a class="btn btn-sm btn-info pull-right"
                            href="{{ route('user.create') }}">{{ __('application.user.create_new') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="userDataTable" class="table table-borderd table-condenced w-100">
                                <thead>
                                    <tr>
                                        <th>{{__('application.table.serial')}}</th>
                                        <th>{{__('application.user.name')}}</th>
                                        <th>{{__('application.user.email_address')}}</th>
                                        <th>{{__('application.user.role')}}</th>
                                        <th>{{__('application.user.status')}}</th>
                                        <th>{{__('application.table.option')}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script type="text/javascript" src="{{ assetz('js/user.js') }}"></script>
@endpush
