<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Floor;
use App\Models\Place;
use App\Models\Country;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:states.index', ['only' => ['index']]);
        $this->middleware('permission:states.create', ['only' => ['create']]);
        $this->middleware('permission:states.store', ['only' => ['store']]);
        $this->middleware('permission:states.edit', ['only' => ['edit']]);
        $this->middleware('permission:states.update', ['only' => ['update']]);
        $this->middleware('permission:states.delete', ['only' => ['destroy']]);
        $this->middleware('permission:states.status', ['only' => ['statusChange']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $parkingSlot = new State();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['country'];
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

        return view('content.states.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get();
        return view('content.states.create')->with(['countries' => $countries]);
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
            'country_id' => 'bail|required'
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();;
        }

        $data = [
            'name' => $request->name,
            'country_id' => $request->country_id
        ];

        State::create($data);

        return redirect()
            ->route('states.index')
            ->with(['flashMsg' => ['msg' => 'State successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        $countries = Country::get();
        return view('content.states.edit')->with(['countries' => $countries, 'state' => $state]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'country_id' => 'bail|required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();;
        }

        $data = [
            'name' => $request->name,
            'country_id' => $request->country_id
        ];

        $state->update($data);

        return redirect()
            ->route('states.index')
            ->with(['flashMsg' => ['msg' => 'State successfully updated.', 'type' => 'success']]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();
    }
    public function default(Request $request, State $state)
    {
        State::query()->update(['default' => 0]);
        $state->update(['default' => 1]);
		return response()->json(['status' =>true,'message' => "Default State successfully changed."]);

    }
}
