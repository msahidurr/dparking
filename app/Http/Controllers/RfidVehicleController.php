<?php

namespace App\Http\Controllers;

use App\Models\RfidVehicle;
use App\Models\Category;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Log;

class RfidVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $vehicles = new RfidVehicle();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['category.place'];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['vehicle_no'] = $request->input('search')['value'];
                $search['rfid_no'] = $request->input('search')['value'];
                $search['driver_name'] = $request->input('search')['value'];
                $search['driver_mobile'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $vehicles = $vehicles->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($vehicles);
        }

        return view('content.parking_settings.rfid_vehicles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.parking_settings.rfid_vehicles_create',['places' => Place::get(), 'categories' => Category::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'bail|required|exists:categories,id',
            'vehicle_no' => 'bail|required|string|max:12|unique:rfid_vehicles,vehicle_no,NULL,NULL,category_id,'.$request->input('category_id'), 
            'rfid_no' => 'bail|required|string|max:24|unique:rfid_vehicles,rfid_no,NULL,NULL,category_id,'.$request->input('category_id'), 
            'driver_name' => 'bail|nullable|min:5',
            'driver_mobile' => 'bail|nullable|min:9'
        ]);

        $device = RfidVehicle::create([
            'category_id'     => $validated['category_id'],
            'vehicle_no'     => $validated['vehicle_no'],
            'rfid_no'     => $validated['rfid_no'],
            'driver_name'     => $validated['driver_name'],
            'driver_mobile'     => $validated['driver_mobile'],
            'created_by' => auth()->id()
        ]);

        return redirect()
            ->route('parking_settings.rfid_vehicles.index')
            ->with(['flashMsg' => ['msg' => 'RFID Vehicles successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RfidVehicle  $rfidVehicle
     * @return \Illuminate\Http\Response
     */
    public function show(RfidVehicle $rfidVehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RfidVehicle  $rfidVehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(RfidVehicle $rfidVehicle)
    {
        return view('content.parking_settings.rfid_vehicles_edit',['rfidVehicle' => $rfidVehicle,'places' => Place::get(),'categories' => Category::get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RfidVehicle  $rfidVehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RfidVehicle $rfidVehicle)
    {
        $validated = $request->validate([
            'category_id' => 'bail|required|exists:categories,id',
            'vehicle_no' => ['bail','required','string','max:12',Rule::unique('rfid_vehicles')->where(function ($query) use($request, $rfidVehicle){
                return $query->where('id', '!=', $rfidVehicle->id)
                ->where('vehicle_no',$request->vehicle_no)
                ->where('category_id',$request->category_id);
            })],
            'rfid_no' => ['bail','required','string','max:24',Rule::unique('rfid_vehicles')->where(function ($query) use($request, $rfidVehicle){
                return $query->where('id', '!=', $rfidVehicle->id)
                ->where('rfid_no',$request->rfid_no)
                ->where('category_id',$request->category_id);
            })], 
            'driver_name' => 'bail|nullable|min:5',
            'driver_mobile' => 'bail|nullable|min:9'
        ]);

        $rfidVehicle->update([
            'category_id'     => $validated['category_id'],
            'vehicle_no'     => $validated['vehicle_no'],
            'rfid_no'     => $validated['rfid_no'],
            'driver_name'     => $validated['driver_name'],
            'driver_mobile'     => $validated['driver_mobile'],
            'modified_by' => auth()->id()
        ]);

        return redirect()
            ->route('parking_settings.rfid_vehicles.index')
            ->with(['flashMsg' => ['msg' => 'RFID Vehicles successfully updated.', 'type' => 'success']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RfidVehicle  $rfidVehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(RfidVehicle $rfidVehicle)
    {
        $rfidVehicle->delete();
    }

    /**
     * Update the status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RfidDevice $rfidVehicle
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, RfidVehicle $rfidVehicle)
    {
        if ($rfidVehicle->status == 1) {
            $rfidVehicle->update(['status' => 0]);
        } else {
            $rfidVehicle->update(['status' => 1]);
        }

        return back()->with(['flashMsg' => ['msg' => 'Status successfully changed.', 'type' => 'success']]);
    }

    public function endpoint(){
        return view('content.parking_settings.rfid_endpoint');
    }
}
