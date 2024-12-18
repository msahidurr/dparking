<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryWiseFloorSlot;
use App\Models\Floor;
use App\Models\Parking;
use App\Models\Place;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary(Request $request)
    {
        if ($request->has('_token')) {
            $request->validate([
                'from_date' => 'bail|required|date',
                'to_date' => 'bail|required|date'
            ]);
        }

        $from = date($request->from_date);
        $to = date($request->to_date);
        $parkings = Parking::query();

        if ($from != ""){
            $parkings->where('out_time', '>=', $from);
        }

        if ($to != ""){
            $parkings->where('out_time', '<=', $to);
        }

        if (count($request->all())) {
            if ($request->place_id != 'all'){
                $parkings->where('parkings.place_id', $request->place_id);
            }

            if ($request->category_id != NULL){
                $parkings->where('parkings.category_id', $request->category_id);
            }

            if ($request->floor_id != NULL) {
                $parkings->where('cwfs.floor_id', $request->floor_id);
            }

            $parkings->join('category_wise_floor_slots as cwfs', 'parkings.slot_id', '=', 'cwfs.id');
            $parkings->join('places', 'parkings.place_id', '=', 'places.id');
            $parkings->join('floors', 'cwfs.floor_id', '=', 'floors.id');
            $parkings->join('categories', 'parkings.category_id', '=', 'categories.id');

            $data['parkings'] = $parkings->select('amount', 'paid', 'parkings.place_id', 'parkings.category_id', 'cwfs.floor_id', 'floors.name as floor_name', 'places.name as place_name', 'categories.type as category_name')->get();
            $data['parkings'] = $data['parkings']->groupBy(['place_id']);
        }

        $data['request'] = $request->all();

        $data['places'] = Place::whereStatus(1)->select('id', 'name')->get();
        $data['categories'] = Category::whereStatus(1)->select('id', 'type', 'place_id')->get();
        $data['floors'] = Floor::whereStatus(1)->select('id', 'place_id', 'name')->get();

        return view('content.reports.summary', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailsReport(Request $request)
    {
        if ($request->has('_token')) {
            $request->validate([
                'from_date' => 'bail|required|date',
                'to_date' => 'bail|required|date'
            ]);
        }

        $from = date($request->from_date);
        $to = date($request->to_date);

        $parkings = Parking::query();

        if ($from != ""){
            $parkings->where('out_time', '>=', $from);
        }
        if ($to != ""){
            $parkings->where('out_time', '<=', $to);
        }

        if (count($request->all())) {
            if ($request->place_id != 'all') {
                $parkings->where('parkings.place_id', $request->place_id);
            }

            if ($request->category_id != NULL) {
                $parkings->where('parkings.category_id', $request->category_id);
            }

            if ($request->floor_id != NULL) {
                $parkings->where('cwfs.floor_id', $request->floor_id);
            }

            if ($request->car_no != NULL) {
                $parkings->where('vehicle_no', $request->car_no);
            }

            if ($request->driver_name != NULL) {
                $parkings->where('driver_name', $request->driver_name);
            }

            if ($request->driver_mobile != NULL) {
                $parkings->where('driver_mobile', $request->driver_mobile);
            }
            
            $parkings->join('category_wise_floor_slots as cwfs', 'parkings.slot_id', '=', 'cwfs.id');
    
            $data['parkings'] = $parkings->get();
        }

        $data['request'] = $request->all();

        $data['places'] = Place::whereStatus(1)->select('id', 'name')->get();
        $data['categories'] = Category::whereStatus(1)->select('id', 'type', 'place_id')->get();
        $data['floors'] = Floor::whereStatus(1)->select('id', 'place_id', 'name')->get();

        return view('content.reports.details_report', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slotsReport(Request $request)
    {

        $slots = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1);

        if (count($request->all())) {

            // $users = User::where('role_id', 4)
            //     ->when($request->place_id != 'all', function($query) use ($request) {
            //         $query->where('category_wise_floor_slot_id', $request->place_id);
            //     })
            //     ->when($request->category_id != NULL, function($query) use ($request) {
            //         $query->where('category_id', $request->category_id);
            //     })
            //     ->when($request->floor_id != NULL, function($query) use ($request) {
            //         $query->where('floor_id', $request->floor_id);
            //     })
            //     ->get();

                
            if ($request->place_id != 'all') {
                $slots->where('category_wise_floor_slots.place_id', $request->place_id);
            }

            if ($request->category_id != NULL) {
                $slots->where('category_wise_floor_slots.category_id', $request->category_id);
            }

            if ($request->floor_id != NULL) {
                $slots->where('category_wise_floor_slots.floor_id', $request->floor_id);
            }
       
            $slots->join('floors', 'category_wise_floor_slots.floor_id', '=', 'floors.id');
            $slots->join('places', 'category_wise_floor_slots.place_id', '=', 'places.id');
            $slots->join('categories', 'category_wise_floor_slots.category_id', '=', 'categories.id');
            $slots->leftJoin('parkings', function($join)
            {
                $join->on('category_wise_floor_slots.id', '=', 'parkings.slot_id');
                $join->whereNull('out_time');
            });

            $data['slots'] = $slots->select('category_wise_floor_slots.place_id', 'category_wise_floor_slots.slot_name', 'category_wise_floor_slots.floor_id', 'category_wise_floor_slots.category_id', 'categories.type as category_name', 'floors.name as floor_name', 'places.name as place_name', 'parkings.id as parking_id')->get();
            $data['slots'] = $data['slots']->groupBy(['place_id']);
        }
        
        $data['request'] = $request->all();

        $data['places'] = Place::whereStatus(1)->select('id', 'name')->get();
        $data['categories'] = Category::whereStatus(1)->select('id', 'type', 'place_id')->get();
        $data['floors'] = Floor::whereStatus(1)->select('id', 'place_id', 'name')->get();

        return view('content.reports.slots_report', $data);
    }
}
