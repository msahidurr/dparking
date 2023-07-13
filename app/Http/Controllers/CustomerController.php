<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Models\City;
use App\Models\Floor;
use App\Models\Place;
use App\Models\State;
use App\Models\Country;
use App\Models\Section;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserInformation;
use App\Models\CategoryWiseFloorSlot;
use Illuminate\Support\Facades\{DB, Hash, Mail};
use Illuminate\Support\Facades\Artisan;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:customers.index', ['only' => ['index']]);
        $this->middleware('permission:customers.create', ['only' => ['create']]);
        $this->middleware('permission:customers.store', ['only' => ['store']]);
        $this->middleware('permission:customers.edit', ['only' => ['edit']]);
        $this->middleware('permission:customers.update', ['only' => ['update']]);
        $this->middleware('permission:customers.delete', ['only' => ['destroy']]);
        $this->middleware('permission:customers.status', ['only' => ['status']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.list');
    }

    public function getListForDataTable(Request $request)
    {
        $users = new User();
        $limit = 10;
        $offset = 0;
        $search = [];
        $where = [];
        $with = ['roles'];
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
            $search['email'] = $request->input('search')['value'];
            $search['name'] = $request->input('search')['value'];
        }

        if ($request->input('where')) {
            $where = $request->input('where');
        }

        if (request()->input('status') != null && request()->input('status') != "") {
            $where['status'] = request()->input('status');
        }

        $where['role_id'] = 4;

        // $where['id NOTEQ'] = auth()->id();

        $users = $users->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy, $request->all());

        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['roles'] = Role::get();
        $data['sections'] = Section::get();
        $data['languages'] = Language::where('status', '>=', 1)->where('code', '!=', 'master')->get();
        $data['places'] = Place::whereStatus(1)->get();
        $data['floors'] = Floor::whereStatus(1)->get();
        $data['slots'] = CategoryWiseFloorSlot::whereStatus(1)->get();
        $data['countries'] = Country::get();
        $data['states'] = State::get();
        $data['cities'] = City::get();
        $data['categories'] = Category::where('status', 1)->get();
        $data['owners'] = User::whereHas('roles', function($query) {
                $query->where('id', 2);
            })->get();

        return view('customer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $data = [
                'name'     => $request['name'],
                'phone_number'    => $request['phone_number'],
                'id_number'    => $request['id_number'],
                'vehicle_no'    => $request['vehicle_no'],
                'driver_owner_id'    => $request['driver_owner_id'],
                'owner_phone_no'    => $request['owner_phone_no'],
                'place_id' => $request['place_id'],
                'floor_id' => $request['floor_id'],
                'category_id' => $request['category_id'],
                'category_wise_floor_slot_id' => $request['category_wise_floor_slot_id'],
                'status'   => 1,
                'role_id'   => 4
            ];

            DB::beginTransaction();

            $user = User::create($data);
            $user->roles()->sync(4);
            $user->permissions()->sync($validated['permissions'] ?? []);
            // $user->sendEmailVerificationNotification();

            DB::commit();            
        } catch (\PDOException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput($request->except('password'))
                ->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
        } catch (Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('customer.list')
                ->with(['flashMsg' => ['msg' => "The customer successfully created but failed to send the email, because the email is not configured.", 'type' => 'error']]);
        }

        return redirect()
            ->route('customer.list')
            ->with(['flashMsg' => ['msg' => 'customer successfully created.', 'type' => 'success']]);
    }

    public function status($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = ! $user->status;
            $user->update();
            return redirect()
                ->route('customer.list')
                ->with(['flashMsg' => ['msg' => 'customer status change successfully.', 'type' => 'success']]);
        } catch (\Throwable $th) {
            return redirect()
                ->route('customer.list')
                ->with(['flashMsg' => ['msg' => 'customer status change Faild.', 'type' => 'error']]);
        }
            

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    public function profile(Request $request)
    {
        $viewData = array(
            'user' => $request->user(),
            'roles' => Role::get(),
            'languages' => Language::where('status', '>=', 1)->where('code', '!=', 'master')->get()
        );
        return view('customer.profile')->with($viewData);
    }

    public function profileUpdate(StoreUserInformation $request)
    {
        if (!env('DEMO', false)) {
            $validated = $request->validated();
            try {
                $user = $request->user();
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->language_id = $validated['language_id'];
                if ($validated['password']) {
                    $user->password = Hash::make($validated['password']);
                }
                $user->update();
            } catch (\PDOException $e) {
                return redirect()
                    ->back()
                    ->withInput($request->except('password'))
                    ->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
            }
            return redirect()
                ->route('customer.profile')
                ->with(['flashMsg' => ['msg' => 'Profile successfully updated.', 'type' => 'success']]);
        } else {
            return redirect()
                ->back()
                ->with(['flashMsg' => ['msg' => 'This feature is not enable in demo mode.', 'type' => 'warning']]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
        try {
            $viewData = array(
                'user' => User::where('role_id', 4)->findOrFail($id),
                'owners' => User::whereHas('roles', function($query) {
                            $query->where('id', 2);
                        })->get(),
                'roles' => Role::get(),
                'sections' => Section::get(),
                'places' => Place::whereStatus(1)->get(),
                'floors' => Floor::whereStatus(1)->get(),
                'slots' => CategoryWiseFloorSlot::whereStatus(1)->get(),
                'countries' => Country::get(),
                'states' => State::get(),
                'cities' => City::get(),
                'categories' => Category::where('status', 1)->get(),
                'languages' => Language::where('status', '>=', 1)->where('code', '!=', 'master')->get()
            );
            return view('customer.edit', $viewData);
        } catch (\Throwable $th) {
            return redirect()->back()->withError($th->getMessage());
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $user->name = $request['name'];
            $user->phone_number = $request['phone_number'];
            $user->id_number = $request['id_number'];
            $user->vehicle_no = $request['vehicle_no'];
            $user->driver_owner_id = $request['driver_owner_id'];
            $user->owner_phone_no = $request['owner_phone_no'];
            $user->category_id = $request['category_id'];
            $user->place_id = $request['place_id'];
            $user->floor_id = $request['floor_id'];
            $user->category_wise_floor_slot_id = $request['category_wise_floor_slot_id'];
            $user->update();

            return redirect()->route('customer.list')->with(['flashMsg' => ['msg' => 'Customer information successfully updated.', 'type' => 'success']]);
        } catch (\PDOException $e) {

            throw $e;
            return redirect()
                ->back()
                ->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
        }
        return redirect()
            ->route('customer.list')
            ->with(['flashMsg' => ['msg' => 'Customer information successfully updated.', 'type' => 'success']]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try {

            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        
    }
}
