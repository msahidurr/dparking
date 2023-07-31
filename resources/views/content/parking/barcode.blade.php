@extends('layouts.app')
@section('title', ' - All Parking')
@section('content')

<div class="container-fluid mb100">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('application.parking.barcode_print') }}</div>

                <div class="card-body tc" id="printDiv">

                    <link rel="stylesheet" href="{{asset('css/custom/content/barcode.css')}}" />

                    @isset($settings->logo)
                    @if($settings->logo)
                    <p class="dN tc fwb fs-16">
                        <img src="{{ ($settings->logo) ? asset($settings->logo) : '' }}" alt="barcode" class="w70 ml15"
                            style="width: 170px;margin-left: 10px;" />
                    </p>
                    @endif
                    @endisset


                    <p class="dN tc fwb fs-16">{{ ($settings->site_title) ? $settings->site_title : config('app.name',
                        'Demo Parking') }}</p>

                    <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($parking->barcode, 'C128', 50, 1366) }}"
                        alt="barcode" class="w70 ml15" />

                    <table class="table table-condensed rTable">
                        <tbody>
                            <tr>
                                <td class="w40">{{ __('application.parking.vehicle_no') }}</td>
                                <td class="w10">:</td>
                                <td class="w50">{{$parking->vehicle_no}}</td>
                            </tr>
                            <tr>
                                <td class="w40">{{ __('application.parking.type') }}</td>
                                <td class="w10">:</td>
                                <td class="w50">{{$parking->category->type}}</td>
                            </tr>
                            <tr>
                                <td class="w40">{{ __('application.parking.driver_name') }}</td>
                                <td class="w10">:</td>
                                <td class="w50">{{$parking->driver->name ?? ""}}</td>
                            </tr>
                            <tr>
                                <td class="w40">{{ __('application.parking.barcode') }}</td>
                                <td class="w10">:</td>
                                <td class="w50">{{$parking->barcode ?? ""}}</td>
                            </tr>
                            <tr>
                                <td class="w40">{{ __('application.parking.driver_mobile') }}</td>
                                <td class="w10">:</td>
                                <td class="w50">{{$parking->driver_mobile}}</td>
                            </tr>
                            <tr>
                                <td class="w40">{{ __('application.parking.floor') }}</td>
                                <td class="w10">:</td>
                                <td class="w50">{{$parking->slot->floor->name ?? ''}}</td>
                            </tr>
                            <tr>
                                <td class="w40">{{ __('application.parking.parking_slot') }}</td>
                                <td class="w10">:</td>
                                <td class="w50">{{$parking->slot->slot_name ?? ''}}</td>
                            </tr>
                            <tr>
                                <td class="w40">{{ __('application.tariff.start_date') }}</td>
                                <td class="w10">:</td>
                                <td class="w50"><b>{{$parking->in_time->format(env('DATE_FORMAT','m-d-Y H:i:s'))}}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="dN tc fs-12">{{ $settings->site_title }} - {{
                        __('application.parking.all_rights_reserved') }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{route('parking.create')}}" class="btn btn-warning" id="parking_list">{{
                        __('application.parking.add_parking') }}</a>
                    <button class="btn btn-success" id="print_slip">{{ __('application.parking.print_slip') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ assetz('js/custom/content/barcode.js') }}"></script>
@endsection