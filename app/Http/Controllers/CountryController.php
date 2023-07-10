<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:countries.index', ['only' => ['index']]);
        $this->middleware('permission:countries.create', ['only' => ['create']]);
        $this->middleware('permission:countries.store', ['only' => ['store']]);
        $this->middleware('permission:countries.edit', ['only' => ['edit']]);
        $this->middleware('permission:countries.update', ['only' => ['update']]);
        $this->middleware('permission:countries.delete', ['only' => ['destroy']]);
        $this->middleware('permission:countries.status', ['only' => ['statusChange']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $parkingSlot = new Country();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = [];
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
                $search['short_code'] = $request->input('search')['value'];
                $search['phone_code'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $parkingSlot = $parkingSlot->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($parkingSlot);
        }

        return view('content.countries.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.countries.create');
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
            'short_code' => 'bail|required',
            'phone_code' => 'bail|required',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();;
        }

        $data = [
            'name' => $request->name,
            'short_code' => $request->short_code,
            'phone_code' => $request->phone_code,
        ];

        Country::create($data);

        return redirect()
            ->route('countries.index')
            ->with(['flashMsg' => ['msg' => 'Country successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('content.countries.edit')->with(['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'short_code' => 'bail|required',
            'phone_code' => 'bail|required',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();;
        }

        $data = [
            'name' => $request->name,
            'short_code' => $request->short_code,
            'phone_code' => $request->phone_code,
        ];

        $country->update($data);

        return redirect()
            ->route('countries.index')
            ->with(['flashMsg' => ['msg' => 'Country successfully updated.', 'type' => 'success']]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();
    }
    public function default(Request $request, Country $country)
    {
        Country::query()->update(['default' => 0]);
        $country->update(['default' => 1]);
		return response()->json(['status' =>true,'message' => "Default Country successfully changed."]);

    }
}
