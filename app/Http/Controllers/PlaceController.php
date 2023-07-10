<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:places.index', ['only' => ['index']]);
        $this->middleware('permission:places.create', ['only' => ['create']]);
        $this->middleware('permission:places.store', ['only' => ['store']]);
        $this->middleware('permission:places.edit', ['only' => ['edit']]);
        $this->middleware('permission:places.update', ['only' => ['update']]);
        $this->middleware('permission:places.delete', ['only' => ['destroy']]);
        $this->middleware('permission:places.status', ['only' => ['statusChange']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $places = new Place();
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
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $places = $places->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($places);
        }

        return view('content.places.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.places.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate(['name' => 'bail|required|unique:places', 'description' => 'bail|nullable|min:5']);

        $place = Place::create([
            'name'     => $validated['name'],
            'description'     => $validated['description'],
            'created_by' => auth()->id()
        ]);

        return redirect()
            ->route('places.index')
            ->with(['flashMsg' => ['msg' => 'Place successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Place $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Place $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        $viewData = array(
            'place' => $place,
        );

        return view('content.places.edit')->with($viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        $validated = $request->validate(['name' => 'bail|required|unique:places,name,' . $place->id, 'description' => 'bail|nullable|min:5']);

        $place->update([
            'name'     => $validated['name'],
            'description'    => $validated['description']
        ]);

        return redirect()
            ->route('places.index')
            ->with(['flashMsg' => ['msg' => 'Place successfully updated.', 'type' => 'success']]);
    }


    /**
     * Update the status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Place $place
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, Place $place)
    {
        if ($place->status == 1) {
            $place->update(['status' => 0]);
        } else {
            $place->update(['status' => 1]);
        }

        return back()->with(['flashMsg' => ['msg' => 'Status successfully changed.', 'type' => 'success']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Place $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->delete();
    }
}
