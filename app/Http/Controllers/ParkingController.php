<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Category;
use App\Models\Tariff;
use App\Models\RfidVehicle;
use Illuminate\Http\Request;
use App\Http\Requests\StoreParkingRequest;
use App\Http\Requests\UpdateParkingRequest;
use App\Http\Requests\PayParkingRequest;
use App\Models\CategoryWiseFloorSlot;
use App\Models\Place;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;

class ParkingController extends Controller
{
	public function __construct()
    {
        $this->middleware('permission:parkings.index', ['only' => ['index']]);
        $this->middleware('permission:parkings.current', ['only' => ['currentList']]);
        $this->middleware('permission:parkings.ended', ['only' => ['endedList']]);
        $this->middleware('permission:parkings.print', ['only' => ['barcode']]);
        $this->middleware('permission:parkings.pay', ['only' => ['pay']]);
        $this->middleware('permission:parkings.create', ['only' => ['create']]);
        $this->middleware('permission:parkings.store', ['only' => ['store']]);
        $this->middleware('permission:parkings.edit', ['only' => ['edit']]);
        $this->middleware('permission:parkings.update', ['only' => ['update']]);
        $this->middleware('permission:parkings.delete', ['only' => ['destroy']]);
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->wantsJson()) {
			$parkings = new Parking();
			$limit = 10;
			$offset = 0;
			$search = [];
			$where = [];
			$with = ['category', 'create_by', 'slot'];
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
				$search['barcode'] = $request->input('search')['value'];
				$search['vehicle_no'] = $request->input('search')['value'];
				$search['driver_name'] = $request->input('search')['value'];
				$search['driver_mobile'] = $request->input('search')['value'];
			}

			if ($request->input('where')) {
				$where = $request->input('where');
			}

			if (!auth()->user()->hasAllPermissions(allpermissions())) {
				$where['place_id and'] = auth()->user()->place_id;
			}

			$parkings = $parkings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
			return response()->json($parkings);
		}

		if (auth()->user()->hasAllPermissions(allpermissions())) {
			$data['categories'] = Category::where('status', 1)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		} else {
			$place_id = auth()->user()->place_id;
			$data['categories'] = Category::where('status', 1)->where('place_id', $place_id)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->where('place_id', $place_id)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)->where('place_id', $place_id)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		}

		return view('content.parking.list')->with($data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function currentList(Request $request)
	{
		if ($request->wantsJson()) {
			$parkings = new Parking();
			$limit = 10;
			$offset = 0;
			$search = [];
			$where = [];
			$with = ['category', 'create_by', 'slot'];
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
				$search['barcode'] = $request->input('search')['value'];
				$search['vehicle_no'] = $request->input('search')['value'];
				$search['driver_name'] = $request->input('search')['value'];
				$search['driver_mobile'] = $request->input('search')['value'];
			}

			if ($request->input('where')) {
				$where = $request->input('where');
			}

			$where['out_time'] = null;
			if (!auth()->user()->hasAllPermissions(allpermissions())) {
				$where['place_id and'] = auth()->user()->place_id;
			}

			$parkings = $parkings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
			return response()->json($parkings);
		}

		if (auth()->user()->hasAllPermissions(allpermissions())) {
			$data['categories'] = Category::where('status', 1)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		} else {
			$place_id = auth()->user()->place_id;
			$data['categories'] = Category::where('status', 1)->where('place_id', $place_id)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->where('place_id', $place_id)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)->where('place_id', $place_id)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		}

		return view('content.parking.current_list')->with($data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function endedList(Request $request)
	{
		if ($request->wantsJson()) {
			$parkings = new Parking();
			$limit = 10;
			$offset = 0;
			$search = [];
			$where = [];
			$with = ['category', 'create_by', 'slot'];
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
				$search['barcode'] = $request->input('search')['value'];
				$search['vehicle_no'] = $request->input('search')['value'];
				$search['driver_name'] = $request->input('search')['value'];
				$search['driver_mobile'] = $request->input('search')['value'];
			}

			if ($request->input('where')) {
				$where = $request->input('where');
			}

			$where['out_time NOTEQ'] = null;
			if (!auth()->user()->hasAllPermissions(allpermissions())) {
				$where['place_id and'] = auth()->user()->place_id;
			}

			$parkings = $parkings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
			return response()->json($parkings);
		}

		if (auth()->user()->hasAllPermissions(allpermissions())) {
			$data['categories'] = Category::where('status', 1)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		} else {
			$place_id = auth()->user()->place_id;
			$data['categories'] = Category::where('status', 1)->where('place_id', $place_id)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->where('place_id', $place_id)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)->where('place_id', $place_id)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		}

		return view('content.parking.ended_list')->with($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (auth()->user()->hasAllPermissions(allpermissions())) {
			$data['places'] = Place::where('status', 1)->get();
			$data['tariffs'] = Tariff::where('status', 1)->get();
			$data['categories'] = Category::where('status', 1)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
			
			$data['drivers'] = User::whereHas('roles', function($query) {
						$query->where('id', 4);
					})
					->where('status', 1)
					->get();

			$data['owners'] = User::whereHas('roles', function($query) {
					$query->where('id', 2);
				})
				->where('status', 1)
				->get();
		} else {
			$place_id = auth()->user()->place_id;
			$data['categories'] = Category::where(['status' => 1, 'place_id' => $place_id])->get();
			$data['tariffs'] = Tariff::where('status', 1)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->where('place_id', $place_id)->count();
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)->where('place_id', $place_id)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
			
			$data['drivers'] = User::whereHas('roles', function($query) {
					$query->where('id', 4);
				})
				->where('status', 1)
				->get();
			
			$data['owners'] = User::whereHas('roles', function($query) {
					$query->where('id', 2);
				})
				->where('status', 1)
				->get();
		}
		return view('content.parking.create')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\StoreParkingRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreParkingRequest $request)
	{
		$validated = $request->validated();

		try {
			$rfidVehicle = RfidVehicle::where('vehicle_no',$validated['vehicle_no'])->where('category_id',$validated['category_id'])->first();
			Parking::create([
				'place_id' => auth()->user()->hasAllPermissions(allpermissions()) ? $validated['place_id'] : auth()->user()->place_id,
				'tariff_id'    	=> $validated['tariff_id'],
				'slot_id'    	=> $validated['slot_id'],
				'vehicle_no'    => $validated['vehicle_no'],
				'rfid_no'		=> (($rfidVehicle) ? $rfidVehicle->rfid_no : null),
				'category_id'   => $validated['category_id'],
				'driver_id'   => $validated['driver_id'],
				'driver_mobile' => $validated['driver_mobile'],
				'owner_id' 	=> $validated['owner_id'] ?? 0,
				'id_number' 	=> $validated['id_number'],
				'barcode'       => date('YmdHis') . $request->user()->id,
				'in_time'       => date('Y-m-d H:i:s'),
				'created_by'    => $request->user()->id,
				'modified_by'   => $request->user()->id
			]);
			
		} catch (\PDOException $e) {

			return redirect()
				->back()
				->withInput()
				->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
		}

		return redirect()
			->route('parking.index')
			->with(['flashMsg' => ['msg' => 'Parking successfully added.', 'type' => 'success']]);

		// return redirect()
		// 	->route('parking.barcode', ['parking' => $parking->id])
		// 	->with(['flashMsg' => ['msg' => 'Parking successfully added.', 'type' => 'success']]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Parking  $parking_crud
	 * @return \Illuminate\Http\Response
	 */
	public function show(Parking $parking_crud)
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Parking  $parking_crud
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Parking $parking_crud)
	{
		if (auth()->user()->hasAllPermissions(allpermissions())) {
			$data['drivers'] = User::whereHas('roles', function($query) {
					$query->where('id', 4);
				})
				->where('status', 1)
				->get();
			$data['tariffs'] = Tariff::where('status', 1)->get();
			$data['places'] = Place::where('status', 1)->get();
			$data['categories'] = Category::where('status', 1)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->count();
			$data['parking'] = $parking_crud;
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
			
			$data['owners'] = User::whereHas('roles', function($query) {
					$query->where('id', 2);
				})
				->where('status', 1)
				->get();
		} else {
			$place_id = auth()->user()->place_id;
			$data['drivers'] = User::whereHas('roles', function($query) {
					$query->where('id', 4);
				})
				->where('status', 1)
				->get();
			$data['tariffs'] = Tariff::where('status', 1)->get();
			$data['categories'] = Category::where('status', 1)->where('place_id', $place_id)->get();
			$data['currently_parking'] = Parking::where('out_time', NULL)->where('place_id', $place_id)->count();
			$data['parking'] = $parking_crud;
			$data['total_slots'] = CategoryWiseFloorSlot::where('category_wise_floor_slots.status', 1)->where('place_id', $place_id)
				->whereHas('floor', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})
				->with('active_parking')
				->count();
			
			$data['owners'] = User::whereHas('roles', function($query) {
					$query->where('id', 2);
				})
				->where('status', 1)
				->get();
		}

		return view('content.parking.edit')->with($data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\UpdateParkingRequest  $request
	 * @param  \App\Models\Parking  $parking_crud
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateParkingRequest $request, Parking $parking_crud)
	{
		$validated = $request->validated();

		try {
			if ($parking_crud->status > 2) {
				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => "You are not allow to update parking.", 'type' => 'warning']]);
			}
				
			$rfidVehicle = RfidVehicle::where('vehicle_no',$validated['vehicle_no'])->where('category_id',$validated['category_id'])->first();

			Parking::where('id', $parking_crud->id)
				->update([
					'place_id'    	=> auth()->user()->hasAllPermissions(allpermissions()) ? $validated['place_id'] : auth()->user()->place_id,
					'tariff_id'    	=> $validated['tariff_id'],
					'slot_id'    	=> $validated['slot_id'],
					'vehicle_no'    => $validated['vehicle_no'],
					'rfid_no'		=> (($rfidVehicle) ? $rfidVehicle->rfid_no : null),
					'category_id'   => $validated['category_id'],
					'driver_id'   	=> $validated['driver_id'],
					'driver_mobile' => $validated['driver_mobile'],
					'owner_id' 		=> $validated['owner_id'] ?? 0,
					'id_number' 	=> $validated['id_number'],
					'status' 		=> 2,
					'modified_by'   => $request->user()->id
				]);
		} catch (\PDOException $e) {

			return redirect()
				->back()
				->withInput()
				->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
		}

		return redirect()
			->route('parking.index')
			->with(['flashMsg' => ['msg' => 'Parking successfully updated.', 'type' => 'success']]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Parking $parking_crud)
	{
		$barcodeNo = $parking_crud->barcode;
		$parking_crud->delete();
		return response()->json(['message' => $barcodeNo . ' Parking successfully deleted.']);
	}

	/**
	 * End the specified parking from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function end(Request $request, Parking $parking)
	{
		$viewData = [];
		$viewData['amt'] = 0;
		$viewData['fine_amount'] = 0;
		$viewData['total_duration'] = 0;
		if ($parking->status <= 2) {
			try {
				$tariff = $parking->tariff;

				if ($tariff == NULL) {
					return redirect()
						->back()
						->withInput()
						->with(['flashMsg' => ['msg' => "Tariff not found for this hour. Please check your tariff information!", 'type' => 'warning']]);
				}

				// $eDate = new \DateTime($parking->out_time);
				
				// Session::put('eDate_' . $parking->id, $eDate);
				// $dateDiff = $eDate->diff(new \DateTime($parking->in_time));

				// \Exceptio\Utlt::look($dateDiff);
				$amt = $tariff->min_amount + $tariff->amount;

				$now = now();
				$endDate = Carbon::parse($parking->in_time)->addDays($parking->tariff->type);

				if($now->gt($endDate)) {
					$differenceDay = $now->diffInDays($endDate);
					$backlogDay = (round($differenceDay / $parking->tariff->type));
					$viewData['fine_amount'] = round($amt * $backlogDay, 2);
					$amt = $amt + $viewData['fine_amount'];
					$viewData['total_duration'] = $differenceDay;
				}

				// $hour = $dateDiff->h;
				// if ($dateDiff->days > 0)
				// 	$hour = $dateDiff->h + ($dateDiff->days * 24);
				// $hour += ($dateDiff->i / 60);
				// if ($hour > 1)
				// 	$amt = $hour * $tariff->amount;

				// Session::put('eAmt_' . $parking->id, $amt);
				$viewData['parking'] = $parking;
				$viewData['amt'] = $amt;
				
				// $viewData['amt'] = $tariff->min_amount > $amt ? $tariff->min_amount : $amt;

				// print_r("<pre>");
				// print_r($viewData);die();
				return view('content.parking.end')->with($viewData);
			} catch (Exception $e) {

				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
			}
		}

		$viewData['parking'] = $parking;
		return view('content.parking.end')->with($viewData);
	}

	/**
	 * Print the specified parking from storage.
	 *
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function barcode(Parking $parking)
	{
		return view('content.parking.barcode')->with(['parking' => $parking]);
	}

	/**
	 * End the specified parking from storage.
	 *
	 * @param  \Illuminate\Http\PayParkingRequest  $request
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function pay(PayParkingRequest $request, Parking $parking)
	{
		if ($parking->status != 3) {
			try {
				$validated = $request->validated();
				$parking->out_time = date('Y-m-d H:i:s');

				$tariff = $parking->tariff;
				$amt = $tariff->min_amount + $tariff->amount;

				// $totalAmount = $amt;
				$paidAmt = $validated['paid_amt'];

				// if($totalAmount != $paidAmt) {
				// 	return redirect()
				// 	->back()
				// 	->withInput()
				// 	->with(['flashMsg' => ['msg' => "Partial payment is not available. Please pay full amount.", 'type' => 'error']]);
				// }
				// //amount 
				// if (Session::has('eAmt_' . $parking->id)) {
				// 	$amt = Session::get('eAmt_' . $parking->id);
				// } else {
				// 	$tariff = Tariff::getCurrent($parking->category_id, $parking->place_id);
				// 	$dateDiff = $parking->out_time->diff(new \DateTime($parking->in_time));

				// 	$hour = $dateDiff->h;
				// 	$amt = $tariff->min_amount;
				// 	if ($dateDiff->days > 0)
				// 		$hour = $dateDiff->h + ($dateDiff->days * 24);
				// 	$hour += ($dateDiff->i / 60);
				// 	if ($hour > 1)
				// 		$amt = $hour * $tariff->amount;
				// }

				$parking->amount = $amt;
				$parking->fine_amount = $request->fine_amount;
				$parking->fine_count_at = now();
				$parking->modified_by = $request->user()->id;
				$parking->paid = $paidAmt;
				$parking->status = 4;
				$parking->update();

				// Session::forget('eAmt_' . $parking->id);
				// Session::forget('eDate_' . $parking->id);

				$viewData['flashMsg'] = ['msg' => 'Parking checkout & payment successfully.', 'type' => 'success'];
				$viewData['parking'] = $parking;

				return redirect()
					->route('parking.end', ['parking' => $parking->id])
					->with($viewData);
			} catch (Exception $e) {

				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
			}
		}

		$viewData['parking'] = $parking;
		return view('content.parking.end')->with($viewData);
	}

	/**
	 * get slot by using category id.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function parkingSlot(Request $request, $category_id)
	{
		$slots = CategoryWiseFloorSlot::where('category_id', $category_id)
			->whereHas('floor', function ($query) {
				$query->where('status', '1');
			})
			->with('active_parking')
			->where('category_wise_floor_slots.status', 1)
			->join('floors', 'floors.id', '=', 'category_wise_floor_slots.floor_id')
			->orderBy('floors.level', 'DESC')
			->select('category_wise_floor_slots.*')
			->where('category_wise_floor_slots.status', 1)
			->get();

		return view('content.parking.slot_list')->with(['slots' => $slots, 'id' => $request->id])->render();
	}

	/**
	 * End the specified parking from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function quick_end(Request $request)
	{
		try {
			if (auth()->user()->hasAllPermissions(allpermissions())) {
				$parking = Parking::where([
					['barcode', $request->input('barcode')],
					['status', '<=', 2],
				])->first();
			} else {
				$place_id = auth()->user()->place_id;
				$parking = Parking::where([
					['barcode', $request->input('barcode')],
					['status', '<=', 2],
				])->where('place_id', $place_id)->first();
			}

			if ($parking == null) {
				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => "This barcode doesn't exist.", 'type' => 'warning']]);
			} else {
				$viewData['parking'] = $parking;

				return redirect()
					->route('parking.end', ['parking' => $parking->id])
					->with($viewData);
			}
		} catch (Exception $e) {

			return redirect()
				->back()
				->withInput()
				->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
		}
	}
}
