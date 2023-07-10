<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Place;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.index', ['only' => ['index']]);
        $this->middleware('permission:roles.create', ['only' => ['create']]);
        $this->middleware('permission:roles.store', ['only' => ['store']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit']]);
        $this->middleware('permission:roles.update', ['only' => ['update']]);
        $this->middleware('permission:roles.delete', ['only' => ['destroy']]);
        $this->middleware('permission:roles.status', ['only' => ['statusChange']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $roles = new Role();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['permissions:name'];
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
                $search['level'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $roles = $roles->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($roles);
        }

        return view('content.roles.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['sections'] = Section::get();
        return view('content.roles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'bail|required|unique:roles','permissions'  => 'bail|required_if:required_permission,true']);
        $data = [
            'name'     => $validated['name']
        ];

        $role = Role::create($data);
        $role->permissions()->sync($validated['permissions']);
        
        return redirect()
        ->route('roles.index')
        ->with(['flashMsg' => ['msg' => 'Role successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $viewData = array(
            'role' => $role,
            'sections' => Section::get(),
        );

        return view('content.roles.edit')->with($viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate(['name' => 'bail|required|unique:roles,name,' . $role->id,'permissions'  => 'bail|required_if:required_permission,true']);

        $role->update([
            'name'     => $validated['name']
        ]);
        $role->permissions()->sync($validated['permissions']);

        return redirect()
            ->route('roles.index')
            ->with(['flashMsg' => ['msg' => 'Role successfully updated.', 'type' => 'success']]);
    }
   
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
       $role->delete();
    }
}
