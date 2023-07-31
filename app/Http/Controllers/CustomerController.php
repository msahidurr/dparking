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
use App\Models\Commune;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserInformation;
use App\Models\CategoryWiseFloorSlot;
use App\Models\District;
use App\Models\Parking;
use App\Models\Tariff;
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
        $with = ['roles', 'place', 'floor', 'slot', 'country', 'state', 'city', 'category', 'hasParking'];
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
            $search['start_at'] = $request->input('search')['value'];
            $search['end_at'] = $request->input('search')['value'];
            $search['vehicle_no'] = $request->input('search')['value'];
            $search['id_number'] = $request->input('search')['value'];
            $search['driver_owner_name'] = $request->input('search')['value'];
        }

        if ($request->input('where')) {
            $where = $request->input('where');
        }

        if (request()->input('status') != null && request()->input('status') != "") {
            $where['status'] = request()->input('status');
            $where['role_id'] = 4;
        }

        $where['role_id'] = 4;

        // $where['id NOTEQ'] = auth()->id();

        $users = $this->getDataForDataTable2($limit, $offset, $search, $where, $with, $join, $orderBy, $request->all());

        // print_r("<pre>");
        // print_r($users['data'][0]->toArray());die();
        return response()->json($users);
    }

    public function getTable()
    {
        return 'users';
    }

    public function getDataForDataTable2($limit = 20, $offset = 0, $search = [], $where = [], $with = [], $join = [], $order_by = [], $table_col_name = '', $select = null){

        $totalData = User::query();
        $filterData = User::query();
		$totalCount = User::query();

        if(count($where) > 0){
            foreach ($where as $keyW => $valueW) {
				if(strpos($keyW, ' IN') !== false){
                    $keyW = str_replace(' IN', '', $keyW);
                    $totalData->whereIn($keyW, $valueW);
                    $filterData->whereIn($keyW, $valueW);
                    $totalCount->whereIn($keyW, $valueW);
                }else if(strpos($keyW, ' NOTIN') !== false){
                    $keyW = str_replace(' NOTIN', '', $keyW);
                    $totalData->whereNotIn($keyW, $valueW);
                    $filterData->whereNotIn($keyW, $valueW);
                    $totalCount->whereNotIn($keyW, $valueW);
                }else if(is_array($valueW)){
                    $totalData->where([$valueW]);
                    $filterData->where([$valueW]);
                    $totalCount->where([$valueW]);
                }else if(strpos($keyW, ' and') === false){
                    if(strpos($keyW, ' NOTEQ') !== false){
                        $keyW = str_replace(' NOTEQ', '', $keyW);
                        $totalData->orWhere($keyW, '!=', $valueW);
                        $filterData->orWhere($keyW, '!=',  $valueW);
                        $totalCount->orWhere($keyW, '!=', $valueW);
                    }
                    else{
                        $totalData->orWhere($keyW, $valueW);
                        $filterData->orWhere($keyW, $valueW);
                        $totalCount->orWhere($keyW, $valueW);
                    }
                }
                else{
                    $keyW = str_replace(' and', '', $keyW);
                    if(strpos($keyW, ' NOTEQ') !== false){
                        $keyW = str_replace(' NOTEQ', '', $keyW);
                        $totalData->where($keyW, '!=', $valueW);
                        $filterData->where($keyW, '!=',  $valueW);
                        $totalCount->where($keyW, '!=', $valueW);
                    }
                    else{
                        $totalData->where($keyW, $valueW);
                        $filterData->where($keyW, $valueW);
                        $totalCount->where($keyW, $valueW);
                    }
                }
			}
        }


        if($limit > 0){
            $totalData->limit($limit)->offset($offset);
        }

        if(count($with) > 0){
            foreach ($with as $w) {
                $totalData->with($w);
            }
        }

        if(count($join) > 0){
            foreach ($join as list($nameJ, $withJ, $asJ)) {
				$name_array = explode(" ", $nameJ);
				$name_as = end($name_array);
				if($name_as =='rev'){
					$totalData->leftJoin($name_array[0], $withJ, '=', $this->getTable().'.id')
					->selectRaw($asJ);
					$filterData->leftJoin($name_array[0], $withJ, '=', $this->getTable().'.id');
					$totalCount->leftJoin($name_array[0], $withJ, '=', $this->getTable().'.id');
				}else if($name_as =='inner'){
                    $totalData->join($name_array[0], $withJ, '=', $name_array[0].'.id')
                    ->selectRaw($asJ);
                    $filterData->join($name_array[0], $withJ, '=', $name_array[0].'.id');
                    $totalCount->join($name_array[0], $withJ, '=', $name_array[0].'.id');
                }
				else{
					$totalData->leftJoin($nameJ, $withJ, '=', $name_as.'.id')
					->selectRaw($asJ);
					$filterData->leftJoin($nameJ, $withJ, '=', $name_as.'.id');
					$totalCount->leftJoin($nameJ, $withJ, '=', $name_as.'.id');
				}
			}

            if($select == null){
            	$totalData->selectRaw($this->getTable().'.*');
            	$filterData->selectRaw($this->getTable().'.*');
            }
        }

        if(count($search) > 0) {
            $totalData->where(function($totalData) use($search) {
				foreach ($search as $keyS => $valueS) {
					if(strpos($keyS, ' and') === false){
						$totalData->orWhere($keyS, 'like', "%$valueS%");
					}
					else{
						$keyS = str_replace(' and', '', $keyS);
						$totalData->where($keyS, $valueS);
					}
				}
			});

            // $searchValue = request()->input('search')['value'];

            // $totalData->whereHas('place', function($query) use ($searchValue) {
            //     $query->where('name', 'like', "%$searchValue%");
            // });

			$filterData->where(function($filterData) use($search) {
				foreach ($search as $keyS => $valueS) {
					$filterData->orWhere($keyS, 'like', "%$valueS%");
				}
			});
        }

        if($select != null){
        	$totalData->selectRaw($select);
        	$filterData->selectRaw($select);
        }

        if (count($order_by) > 0) {
			foreach ($order_by as $col => $by) {
				$totalData->orderBy($col, $by);
			}
		} else {
			$totalData->orderBy($this->getTable() . '.id', 'ASC');
        }

        return [
            'data' => $totalData->where('role_id', 4)->get(),
            'draw'      => (int)request()->input('draw'), //prevent Cross Site Scripting (XSS) attacks. https://datatables.net/manual/server-side
            'recordsTotal'  => $totalCount->where('role_id', 4)->count(),
            'recordsFiltered'   => $filterData->where('role_id', 4)->count(),
        ];
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
        $data['countries'] = Country::where('id', 50)->get();
        $data['states'] = State::get();
        $data['cities'] = City::get();
        $data['categories'] = Category::where('status', 1)->get();
        $data['tariffs'] = Tariff::where('status', 1)->get();
        $data['districts'] = District::where('state_id', 828)->get();
        $data['communes'] = Commune::get();

        // $data['owners'] = User::whereHas('roles', function($query) {
        //         $query->where('id', 2);
        //     })->get();

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
            'phone_number' => 'required|unique:users,phone_number',
            'id_number' => 'required|unique:users,id_number',
            'vehicle_no' => 'required|unique:users,vehicle_no',
            'district_id'    => 'bail|nullable|numeric|min:0',
            'commune_id'    => 'bail|nullable|numeric|min:0',
        ]);

        try {
            $place_id = auth()->user()->hasAllPermissions(allpermissions()) ? $request->place_id : auth()->user()->place_id;

			if(Tariff::getCurrent($request['category_id'], $place_id) == null) {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withErrors(['category_id' =>'No tariff found']);
			}

            $activeParking = Parking::where('vehicle_no', $request['vehicle_no'])
                    ->where('out_time', null)
                    ->first();

            if ($activeParking) {
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withErrors(['vehicle_no' => 'This vehicle has currently parked in ' . $activeParking->slot->slot_name . ' slot.']);
            }

            $data = [
                'name'     => $request['name'],
                'phone_number'    => $request['phone_number'],
                'id_number'    => $request['id_number'],
                'vehicle_no'    => $request['vehicle_no'],
                'driver_owner_id'    => $request['driver_owner_id'] ?? 0,
                'driver_owner_name'    => $request['driver_owner_name'] ?? 0,
                'owner_phone_no'    => $request['owner_phone_no'] ?? "",
                'place_id' => $request['place_id'],
                'floor_id' => $request['floor_id'],
                'category_id' => $request['category_id'],
                'category_wise_floor_slot_id' => $request['category_wise_floor_slot_id'],
                'country_id' => $request['country_id'],
                'state_id' => $request['state_id'],
                'city_id' => $request['city_id'],
                'tariff_id' => $request['tariff_id'],
                'district_id' => $request['district_id'] ?: 0,
                'start_at' => $request['start_at'] ?: null,
                'end_at' => $request['end_at'] ?: null,
                'period' => $request['period'] ?: null,
                'status'   => 1,
                'role_id'   => 4 // Driver
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

            throw $e;
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
                // 'owners' => User::whereHas('roles', function($query) {
                //             $query->where('id', 2);
                //         })->get(),
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

            $viewData['tariffs'] = Tariff::where('status', 1)->get();
            $viewData['districts'] = District::where('state_id', 828)->get();
            $viewData['communes'] = Commune::get();

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
            'phone_number' => 'required|unique:users,phone_number,'. $user->id. 'id',
            'id_number' => 'required|unique:users,id_number,'. $user->id. 'id',
            'vehicle_no' => 'required|unique:users,vehicle_no,'. $user->id. 'id',
            'district_id'    => 'bail|nullable|numeric|min:0',
            'commune_id'    => 'bail|nullable|numeric|min:0',
        ]);
        
        // if(Tariff::getCurrent($request['category_id'], $request['place_id']) == null) {
        //     return redirect()
        //         ->back()
        //         ->withInput($request->all())
        //         ->withErrors(['category_id' =>'No tariff found']);
        // }

        // $activeParking = Parking::where('vehicle_no', $request['vehicle_no'])
        //         ->where('driver_id', $user->id)
        //         ->where('out_time', null)
        //         ->first();

        // if ($activeParking) {
        //     return redirect()
        //         ->back()
        //         ->withInput($request->all())
        //         ->withErrors(['vehicle_no' => 'This vehicle has currently parked in ' . $activeParking->slot->slot_name . ' slot.']);
        // }

        try {

            // print_r("<pre>");
            // print_r($request->all());die();
            $user->name = $request['name'];
            $user->phone_number = $request['phone_number'];
            $user->id_number = $request['id_number'];
            $user->vehicle_no = $request['vehicle_no'];
            $user->driver_owner_id = $request['driver_owner_id'] ?? 0;
            $user->driver_owner_name = $request['driver_owner_name'] ?? "";
            $user->owner_phone_no = $request['owner_phone_no'] ?? "";
            $user->category_id = $request['category_id'];
            $user->place_id = $request['place_id'];
            $user->country_id = $request['country_id'];
            $user->state_id = $request['state_id'];
            $user->state_id = $request['state_id'];
            $user->city_id = $request['city_id'];
            $user->tariff_id = $request['tariff_id'];
            $user->district_id = $request['district_id'] ?: 0;
            $user->commune_id = $request['commune_id'] ?: 0;
            $user->category_wise_floor_slot_id = $request['category_wise_floor_slot_id'];
            $user->start_at = $request['start_at'] ?: null;
            $user->end_at = $request['end_at'] ?: null;
            $user->period = $request['period'] ?: null;
            $user->update();

            return redirect()->route('customer.list')->with(['flashMsg' => ['msg' => 'Customer information successfully updated.', 'type' => 'success']]);
        } catch (\PDOException $e) {
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
