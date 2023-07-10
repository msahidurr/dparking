<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Parking;
use App\Models\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        redirect()->route('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //data for barchart
        $categories = Category::where('categories.status', 1);

        $place_id = NULL;

        if (!auth()->user()->hasAllPermissions(allpermissions())) {
            $place_id = auth()->user()->place_id;
        }
        else if($request->place_id){
            $place_id = $request->place_id;
        }
        
        if($place_id){
            $categories->where('place_id', $place_id);
        }

        $categories = $categories->orderBy('categories.type', 'ASC')
            ->withCount(['slots as booked' => function ($query) {
                $query->where('status', '1')->whereHas('floor', function ($query) {
                    $query->where('status', '1');
                })->has('active_parking');
            }])->withCount(['slots as available' => function ($query) {
                $query->where('status', '1')->whereHas('floor', function ($query) {
                    $query->where('status', '1');
                })->doesnthave('active_parking');
            }])->get();

        $barChart['labels'] = $categories->pluck('type')->toArray();

        $slots = $categories->sum('available') + $categories->sum('booked');
        $barChart['availableData'] = $categories->pluck('available')->toArray();
        $barChart['bookedData'] = $categories->pluck('booked')->toArray();
        //bar chart end

        //data for line chart
        $lineChartData = [];

        $data['lineChart']['dateFrom'] = Carbon::now()->addMonth()->subYear()->format('M Y');
        $data['lineChart']['dateTo'] = Carbon::now()->format('M Y');

        $parkingMonthly = Parking::whereDate('out_time', '>=', Carbon::now()->addMonth()->subYear()->format('Y-m') . '-01');

        if ($place_id) {
            $parkingMonthly->where('place_id', $place_id);
        }

        $parkingMonthly = $parkingMonthly->groupBy('month')
            ->orderBy('month')
            ->get([
                DB::raw('DATE_FORMAT( out_time, "%b") as month'),
                DB::raw('sum(amount) as "amount"')
            ])->pluck('amount', 'month');

        $previousDate = Carbon::now()->subYear();
        foreach (range(11, 0) as $i) {
            $date = $previousDate->addMonth()->format('M');
            $monthlyAmount = (isset($parkingMonthly[$date]) ? $parkingMonthly[$date] : 0);
            $lineChartData[$date] = $monthlyAmount;
        }

        $data['lineChart']['labels'] = array_keys($lineChartData);
        $data['lineChart']['data'] = array_values($lineChartData);
        $data['lineChart']['totalAmount'] = array_sum($data['lineChart']['data']);
        //line chart end

        $data['barChart'] = $barChart;
        if ($place_id) {
            $data['today_amount'] = Parking::where('place_id', $place_id)->whereDate('out_time', date('Y-m-d'))->sum('amount');
            $data['this_month_amount'] = Parking::where('place_id', $place_id)->whereMonth('out_time', date('m'))->whereYear('out_time', date('Y'))->sum('amount');
            $data['this_year_amount'] = Parking::where('place_id', $place_id)->whereYear('out_time', date('Y'))->sum('amount');
            $data['currently_parking'] = Parking::where('place_id', $place_id)->where('out_time', NULL)->count();
        }
        else{
            $data['today_amount'] = Parking::whereDate('out_time', date('Y-m-d'))->sum('amount');
            $data['this_month_amount'] = Parking::whereMonth('out_time', date('m'))->whereYear('out_time', date('Y'))->sum('amount');
            $data['this_year_amount'] = Parking::whereYear('out_time', date('Y'))->sum('amount');
            $data['currently_parking'] = Parking::where('out_time', NULL)->count();
        }
        $data['total_slots'] = $slots;

        $data['places'] = Place::whereStatus(1)->get();

        return view('home', compact('data'));
    }
}
