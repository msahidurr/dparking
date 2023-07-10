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
    
</style>

<div>
    <div>
        <h4 class="tc">{{ __('application.report.parking_report') }}</h4>
        <h4 class="tc"> <b>{{ __('application.report.summary_pdf_date') }}:</b> {{ __('application.report.summary_pdf_date_from') }} {{ $request['from_date'] !=
            null ? $request['from_date'] : 'ALL' }}
            {{ __('application.report.summary_pdf_date_to') }}
            {{ $request['to_date'] != null ? $request['to_date'] : 'ALL' }}</h4>
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
    <table>
        <thead>
            <tr>
                <th>{{ __('application.report.serial') }}</th>
                <th>{{ __('application.report.place') }}</th>
                <th>{{ __('application.report.vehicle_no') }}</th>
                <th>{{ __('application.report.type') }}</th>
                <th>{{ __('application.report.floor') }}</th>
                <th>{{ __('application.report.slot') }}</th>
                <th>{{ __('application.report.exit_floor') }}</th>
                <th>{{ __('application.report.in_time') }}</th>
                <th>{{ __('application.report.out_time') }}</th>
                <th>{{ __('application.report.amount') }} ({{ __('application.report.currency') }})</th>
                <th>{{ __('application.report.paid') }} ({{ __('application.report.currency') }})</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
                $total = 0;
                $totalPaid = 0; ?>
            @foreach ($parkings as $parking)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $parking->place->name }}</td>
                <td>{{ $parking->vehicle_no }}</td>
                <td>{{ $parking->category->type }}</td>
                <td>{{ $parking->slot->floor->name ?? '' }}</td>
                <td>{{ $parking->slot->slot_name ?? '' }}</td>
                <td>{{ $parking->exit_floor->name ?? '' }}</td>
                <td>{{ appDate($parking->in_time) }}</td>
                <td>{{ $parking->out_time != null ? appDate($parking->out_time) :
                    $parking->out_time }}
                </td>
                @php
                $total += $parking->amount;
                $totalPaid += $parking->paid;
                @endphp
                <td class="tr">{{ round($parking->amount, 2) }} /=</td>
                <td class="tr">{{ $parking->paid }} /=</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="8" class="text-right">{{ __('application.report.total') }} = </td>
                <td class="tr">{{ $total }} /=</td>
                <td class="tr">{{ $totalPaid }} /=</td>
            </tr>
        </tbody>
    </table>
</div>