<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Floor;
use App\Models\Place;
use App\Models\State;
use App\Models\Country;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cities.index', ['only' => ['index']]);
        $this->middleware('permission:cities.create', ['only' => ['create']]);
        $this->middleware('permission:cities.store', ['only' => ['store']]);
        $this->middleware('permission:cities.edit', ['only' => ['edit']]);
        $this->middleware('permission:cities.update', ['only' => ['update']]);
        $this->middleware('permission:cities.delete', ['only' => ['destroy']]);
        $this->middleware('permission:cities.status', ['only' => ['statusChange']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $parkingSlot = new City();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['state.country'];
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
                $search['name'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $parkingSlot = $parkingSlot->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($parkingSlot);
        }
        return view('content.cities.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        $states = State::get();
        return view('content.cities.create')->with(['countries' => $countries, 'states' => $states]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'country_id' => 'bail|required',
            'state_id' => 'bail|required'
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();;
        }

        $data = [
            'name' => $request->name,
            'state_id' => $request->state_id
        ];

        City::create($data);

        return redirect()
            ->route('cities.index')
            ->with(['flashMsg' => ['msg' => 'City successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $countries = Country::get();
        $states = State::get();
        return view('content.cities.edit')->with(['countries' => $countries, 'states' => $states, 'city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'country_id' => 'bail|required',
            'state_id' => 'bail|required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();;
        }

        $data = [
            'name' => $request->name,
            'state_id' => $request->state_id
        ];

        $city->update($data);

        return redirect()
            ->route('cities.index')
            ->with(['flashMsg' => ['msg' => 'City successfully updated.', 'type' => 'success']]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
    }

    public function default(Request $request, City $city)
    {
        $cities = City::query()->update(['default' => 0]);
        $city->update(['default' => 1]);
		return response()->json(['status' =>true,'message' => "Default City successfully changed."]);

    }
}
