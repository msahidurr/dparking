<style>
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
        width: 80%;
        margin: auto;
        margin-bottom: 30px;
        border: 2px solid #a0a0a0;
    }

    .main-head {
        font-size: 16px;
    }
</style>
<div>
    <div>
        <h3 class="tc">{{ __('application.report.parking_summary_report') }}</h3>
        <h4 class="tc"> <b>{{ __('application.report.summary_pdf_date') }}:</b> {{ __('application.report.summary_pdf_date_from') }} {{ $request['from_date'] !=
            null ? $request['from_date'] : 'ALL' }}
            {{ __('application.report.summary_pdf_date_to') }}
            {{ $request['to_date'] != null ? $request['to_date'] : 'ALL' }}</h4>
        @if ($request['place_id'] != 'all')
        <h4 class="tc">{{ __('application.report.place') }}:
            {{ $places->where('id', $request['place_id'])->first()->name }}</h4>
        @endif
    </div>
    <br>
</div>
<div class="report-block">
    @foreach ($parkings as $parking)
    @foreach($parking->groupBy('floor_id') as $floorWiseParkings)
    <table class="main-table">
        <tr>
            <th class="main-head">{{ __('application.report.summary_place') }} : {{ $parking[0]->place_name }} , {{ __('application.report.summary_floor') }} : {{ $floorWiseParkings[0]->floor_name
                }}, {{ __('application.report.summary_total_collection') }} : {{ $floorWiseParkings->sum('amount') }} ({{ __('application.report.currency') }})</th>
        </tr>
        <tr>
            <td colspan="3">
                <table class="inner-table">
                    <tr>
                        <th>{{ __('application.report.summary_serial') }}</th>
                        <th>{{ __('application.report.summary_category') }}</th>
                        <th class="tc">{{ __('Total Customer') }}</th>
                        <th class="tr">{{ __('application.report.summary_total_collection') }} ({{ __('application.report.currency') }})</th>
                    </tr>
                    @php
                    $sl = 1;
                    @endphp
                    @foreach($floorWiseParkings->groupBy('category_id') as $categoryParking)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>{{ $categoryParking[0]->category_name }}</td>
                        <td class="tc">{{ count($categoryParking) }}</td>
                        <td class="tr">{{ $categoryParking->sum('amount') }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
    @endforeach
    @endforeach
</div>