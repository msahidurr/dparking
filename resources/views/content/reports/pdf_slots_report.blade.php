<style>
    body {
        margin: 20px;
        30px;
    }

    table,
    td,
    th {
        border: solid #4d4d4d;
        border-width: 0.01em;
        padding: 3px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }


    h2,
    h3,
    h4,
    h5 {
        text-align: center;
        margin: 0px;
        padding: 0px;
    }

    th {
        font-weight: bold;
    }

    h4 {
        font-style: underline;
    }

    .tc {
        text-align: center;
        margin: 0px;
    }

    .tr {
        text-align: right;
    }

    .text-right {
        text-align: right;
    }

    .main-table {
        width: 100%;
        margin: auto;
        margin-bottom: 30px;
        border: 2px solid #a0a0a0;
    }

    .main-head {
        font-size: 16px;
    }

    table {
        page-break-inside: auto
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto
    }
</style>
<div>
    <div>
        <h4 class="tc">{{ __('application.report.parking_slots_report') }}</h4>
        @if ($request['place_id'] != 'all')
        <h6 class="tc">{{ __('application.report.place') }}:
            {{ $places->where('id', $request['place_id'])->first()->name }}</h6>
        @endif
        @if (isset($request['floor_id']) && $request['floor_id'] != NULL)
        <h6 class="tc">{{ __('application.report.floor') }}:
            {{ $floors->where('id', $request['floor_id'])->first()->name }}</h6>
        @endif
        @if (isset($request['category_id']) && $request['category_id'] != NULL)
        <h6 class="tc">{{ __('application.report.brand') }}:
            {{ $categories->where('id', $request['category_id'])->first()->type }}</h6>
        @endif
    </div>
    <br>
</div>
<div>
    @foreach ($slots as $slot)
    @foreach($slot->groupBy('floor_id') as $floorWiseSlots)
    <table class="main-table">
        <tr>
            @php
            $totalSlot = count($floorWiseSlots);
            $bookedSlot = count($floorWiseSlots->whereNotNull('parking_id'));
            $availableSlot = $totalSlot - $bookedSlot;
            @endphp
            <th class="main-head">{{ __('application.report.parking_slots_place') }} : {{ $slot[0]->place_name }} , {{ __('application.report.parking_slots_floor') }} : {{ $floorWiseSlots[0]->floor_name }},
                {{ __('Total Customer') }} : {{ $totalSlot }}, {{ __('Total Paid') }} : {{ $bookedSlot }}, {{ __('Past Due') }} {{ $availableSlot }}</th>
        </tr>
        <tr>
            <td colspan="3">
                <table class="inner-table">
                    <tr>
                        <th width="5%">{{ __('application.report.parking_slots_serial') }}</th>
                        <th>{{ __('application.report.parking_slots_category') }}</th>
                        {{-- <th width="10%" class="tc">{{ __('application.report.parking_slots_total_slot') }}</th> --}}
                        <th width="10%" class="tc">{{ __('Total Customer') }}</th>
                        {{-- <th width="10%" class="tc">{{ __('application.report.parking_slots_booked') }}</th> --}}
                        <th width="10%" class="tc">{{ __('Total Paid') }}</th>
                        {{-- <th width="10%" class="tc">{{ __('application.report.parking_slots_available') }}</th> --}}
                        <th width="10%" class="tc">{{ __('Past Due') }}</th>
                        <th width="40%" class="tc">{{ __('application.report.parking_slots_available_slot') }}</th>
                    </tr>
                    @php
                    $sl = 1;
                    @endphp
                    @foreach($floorWiseSlots->groupBy('category_id') as $categorySlot)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $categorySlot[0]->category_name }}</td>
                        @php
                        $totalSlot = count($categorySlot);
                        $bookedSlot = count($categorySlot->whereNotNull('parking_id'));
                        $availableSlot = $totalSlot - $bookedSlot;
                        @endphp
                        <td class="tc">{{ $totalSlot }}</td>
                        <td class="tc">{{ $bookedSlot }}</td>
                        <td class="tc">{{ $availableSlot }}</td>
                        <td class="tc">{{ $categorySlot->whereNull('parking_id')->pluck('slot_name')->implode(', ') }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
    @endforeach
    @endforeach
</div>