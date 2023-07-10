@extends('layouts.app')
@section('title', ' - '.__('application.rfid_vehicles.list'))
@section('content')
<div class="container-fluid mb100">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    RFID API Endpoint
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('parking_settings.rfid_vehicles.index') }}">{{
                        __('application.rfid_vehicles.list') }}</a>
                </div>

                <div class="card-body">
                    <pre class="text-start">
Vendor: 
Silicon Wireless Systems Pvt. Ltd.
(An ISO 9001:2015 Certified Company)
Plot No 367, Ramakrishna Nagar, Chengicherla, Behind MYE Villas, Hyderabad-500076
Off: +91-9642893089, Skype: siliconwireless
contact@siliconwireless.in

Method: GET

URL: {{route('parking_settings.rfid.sws').'?$99999&99&E20010041276618521431021&19072022134120*'}}

Data Param:

$ beginning of the string 
1 - Place Database ID (configurable in the device)
1 - Floor Database ID (configurable in the device)
E20010041276618521431021 - RFID Card ID (Maximum of 24 digits)
19072022134120 - Date and Time of RFID transaction (DDMMYYYYHHMMSS)
* - end of the string
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush