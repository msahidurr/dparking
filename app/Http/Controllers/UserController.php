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
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserInformation;
use App\Models\CategoryWiseFloorSlot;
use Illuminate\Support\Facades\{DB, Hash, Mail};


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.index', ['only' => ['index']]);
        $this->middleware('permission:users.create', ['only' => ['create']]);
        $this->middleware('permission:users.store', ['only' => ['store']]);
        $this->middleware('permission:users.edit', ['only' => ['edit']]);
        $this->middleware('permission:users.update', ['only' => ['update']]);
        $this->middleware('permission:users.delete', ['only' => ['destroy']]);
        $this->middleware('permission:users.status', ['only' => ['status']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.list');
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

        // $where['id NOTEQ'] = auth()->id();

        $users = $this->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
        return response()->json($users);
    }

    public function getDataForDataTable($limit = 20, $offset = 0, $search = [], $where = [], $with = [], $join = [], $order_by = [], $table_col_name = '', $select = null){

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
					$totalData->leftJoin($name_array[0], $withJ, '=', 'users.id')
					->selectRaw($asJ);
					$filterData->leftJoin($name_array[0], $withJ, '=', 'users.id');
					$totalCount->leftJoin($name_array[0], $withJ, '=', 'users.id');
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
            	$totalData->selectRaw('users.*');
            	$filterData->selectRaw('users.*');
            }
        }

        if(count($search) > 0){
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
			$totalData->orderBy('users.id', 'ASC');
        }

        return [
            'data' => $totalData->whereNull('role_id')->get(),
            'draw'      => (int)request()->input('draw'), //prevent Cross Site Scripting (XSS) attacks. https://datatables.net/manual/server-side
            'recordsTotal'  => $totalCount->whereNull('role_id')->count(),
            'recordsFiltered'   => $filterData->whereNull('role_id')->count(),
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
        $data['countries'] = Country::get();
        $data['states'] = State::get();
        $data['cities'] = City::get();

        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserInformation $request)
    {
        $validated = $request->validated();
        try {
            $data = [
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone_number'    => $validated['phone_number'],
                'address'    => $validated['address'],
                'password' => Hash::make($validated['password']),
                'language_id' => $validated['language_id'],
                'place_id' => $validated['place_id'],
                'floor_id' => $validated['floor_id'],
                'category_wise_floor_slot_id' => $validated['category_wise_floor_slot_id'],
                'country_id' => $validated['country_id'],
                'state_id' => $validated['state_id'],
                'city_id' => $validated['city_id'] ?? null,
                'status'   => 1
            ];

            DB::beginTransaction();

            $user = User::create($data);
            $user->roles()->sync($validated['role']);
            $user->permissions()->sync($validated['permissions'] ?? []);
            $user->sendEmailVerificationNotification();

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
                ->route('user.list')
                ->with(['flashMsg' => ['msg' => "The user successfully created but failed to send the email, because the email is not configured.", 'type' => 'error']]);
        }

        return redirect()
            ->route('user.list')
            ->with(['flashMsg' => ['msg' => 'User successfully created.', 'type' => 'success']]);
    }

    public function status(User $user)
    {
        if (env('DEMO') != true) {
            $user->status = !$user->status;
            $user->update();
            return redirect()
                ->route('user.list')
                ->with(['flashMsg' => ['msg' => 'User status change successfully.', 'type' => 'success']]);
        } else {
            return redirect()
                ->route('user.list')
                ->with(['flashMsg' => ['msg' => "You can't change user mode in demo version.", 'type' => 'warning']]);
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
        return view('user.profile')->with($viewData);
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
                ->route('user.profile')
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
    public function edit(User $user)
    {
        $viewData = array(
            'user' => $user,
            'roles' => Role::get(),
            'sections' => Section::get(),
            'places' => Place::whereStatus(1)->get(),
            'floors' => Floor::whereStatus(1)->get(),
            'slots' => CategoryWiseFloorSlot::whereStatus(1)->get(),
            'countries' => Country::get(),
            'states' => State::get(),
            'cities' => City::get(),
            'languages' => Language::where('status', '>=', 1)->where('code', '!=', 'master')->get()
        );
        return view('user.edit', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserInformation $request, User $user)
    {
        if (!env('DEMO', false)) {
            $validated = $request->validated();
            try {
                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->address = $validated['address'];
                $user->phone_number = $validated['phone_number'];
                $user->language_id = $validated['language_id'];
                $user->place_id = $validated['place_id'];
                $user->floor_id = $validated['floor_id'];
                $user->category_wise_floor_slot_id = $validated['category_wise_floor_slot_id'];
                $user->country_id = $validated['country_id'];
                $user->state_id = $validated['state_id'];
                $user->city_id = $validated['city_id'] ?? null;                
                // if ($request->role == 2) {
                //     $user->place_id = $validated['place_id'];
                // }
                // else{
                //     $user->place_id = NULL;
                // }

                if ($validated['password']) {
                    $user->password = Hash::make($validated['password']);
                }
                $user->update();
                $user->roles()->sync($validated['role']);
                if(isset($validated['permissions'])){
                    $user->permissions()->sync($validated['permissions']);

                }
            } catch (\PDOException $e) {
                return redirect()
                    ->back()
                    ->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
            }
            return redirect()
                ->route('user.list')
                ->with(['flashMsg' => ['msg' => 'User information successfully updated.', 'type' => 'success']]);
        } else {
            return redirect()
                ->back()
                ->with(['flashMsg' => ['msg' => 'This feature is not enable in demo mode.', 'type' => 'warning']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
