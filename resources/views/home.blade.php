@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		@if (Auth::user()->hasAnyPermission("dashboard.month_wise_collection_left"))
			<div class="col-xl-8 stretch-card grid-margin">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-between flex-wrap mb-3">
							<div>
								<div class="card-title mb-0">{{ __('application.dashboard.month_wise_collection') }}</div>
								<span class="font-10 font-weight-semibold text-muted">{{ $data['lineChart']['dateFrom'].' -
									'.$data['lineChart']['dateTo'] }}</span>
							</div>
							<div>
								<div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
									<div class="d-flex me-3 mt-2 mt-sm-0">
										<button type="button" class="btn btn-social-icon btn-outline-sales profit">
											<i class="mdi mdi-cash text-info"></i>
										</button>
										<div class="ps-2">
											<h4 class="mb-0 font-weight-semibold head-count"> {{
												$data['lineChart']['totalAmount'] }} </h4>
											<span class="font-10 font-weight-semibold text-muted">{{ __('application.dashboard.total') }} {{
												$data['lineChart']['dateFrom'].' - '.$data['lineChart']['dateTo'] }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="line-chart-wrapper">
							<canvas id="linechart" height="80"></canvas>
						</div>
					</div>
				</div>
			</div>
		@endif

		@if (Auth::user()->hasAnyPermission(["dashboard.month_wise_collection_right"]))
			<div class="col-xl-4 grid-margin">
				<div class="card stretch-card mb-3 {{ auth()->user()->hasAllPermissions(allpermissions()) ? '' : 'd-none' }}">
					<div
						class="card-body {{ auth()->user()->hasAllPermissions(allpermissions()) ? 'dashboard-right-card' : 'dashboard-right-sm-card' }} d-flex flex-wrap justify-content-between">
						<form class="w-100" id="placeChangeForm" action="" method="get">
							<div class="form-group mb-0 w-100">
								<label for="status"
									class="col-form-label f-12 fw-bold pb-2 pt-0 text-md-right text-primary">{{
									__('application.dashboard.change_place') }}</label>
								<select name="place_id" id="place_id" class="form-control">
									<option value="">All place</option>
									@foreach ($data['places'] as $place)
									<option {{ app('request')->input('place_id') == $place->id ? 'selected' : '' }} value="{{ $place->id }}">{{ $place->name }}</option>
									@endforeach
								</select>
							</div>
						</form>
					</div>
				</div>
				<div class="card stretch-card mb-3">
					<div
						class="card-body {{ auth()->user()->hasAllPermissions(allpermissions()) ? 'dashboard-right-card' : 'dashboard-right-sm-card' }} d-flex flex-wrap justify-content-between">
						<div>
							<h4 class="font-weight-semibold mb-1 text-success"> {{
								__('application.dashboard.daily_collection') }} </h4>
							<h6 class="text-muted">{{ now()->format('d F Y') }}</h6>
						</div>
						<h3 class="text-success font-weight-bold">{{$data['today_amount']}}</h3>
					</div>
				</div>
				<div class="card stretch-card mb-3">
					<div
						class="card-body {{ auth()->user()->hasAllPermissions(allpermissions()) ? 'dashboard-right-card' : 'dashboard-right-sm-card' }} d-flex flex-wrap justify-content-between">
						<div>
							<h4 class="font-weight-semibold mb-1 text-behance"> {{
								__('application.dashboard.monthly_collection') }} </h4>
							<h6 class="text-muted">{{ now()->format('F Y') }}</h6>
						</div>
						<h3 class="text-behance font-weight-bold">{{$data['this_month_amount']}}</h3>
					</div>
				</div>
				<div class="card mt-3">
					<div
						class="card-body {{ auth()->user()->hasAllPermissions(allpermissions()) ? 'dashboard-right-card' : 'dashboard-right-sm-card' }} d-flex flex-wrap justify-content-between">
						<div>
							<h4 class="font-weight-semibold mb-1 text-facebook"> {{
								__('application.dashboard.yearly_collection') }} </h4>
							<h6 class="text-muted">{{ now()->format('Y') }}</h6>
						</div>
						<h3 class="text-facebook font-weight-bold">{{$data['this_year_amount']}}</h3>
					</div>
				</div>
			</div>
		@endif

		@if (Auth::user()->hasAnyPermission(["dashboard.slot_left"]))
			<div class="col-xl-4 grid-margin">
				<div class="card stretch-card mb-3">
					<div class="card-body dashboard-left-card d-flex flex-wrap justify-content-between">
						<div>
							<h4 class="font-weight-semibold mb-1 text-success"> {{ __('application.dashboard.total_slots')
								}} </h4>
							<h6 class="text-muted">{{ __('application.dashboard.slots_in_all_category') }}</h6>
						</div>
						<h3 class="text-success font-weight-bold">{{ $data['total_slots'] }}</h3>
					</div>
				</div>
				<div class="card stretch-card mb-3">
					<div class="card-body dashboard-left-card d-flex flex-wrap justify-content-between">
						<div>
							<h4 class="font-weight-semibold mb-1 text-behance">{{
								__('application.dashboard.currently_parking') }}</h4>
							<h6 class="text-muted">{{ __('application.dashboard.booked_slots') }}</h6>
						</div>
						<h3 class="text-behance font-weight-bold">{{ $data['currently_parking'] }}</h3>
					</div>
				</div>
				{{--  <div class="card mt-3">
					<div class="card-body dashboard-left-card d-flex flex-wrap justify-content-between">
						<div>
							<h4 class="font-weight-semibold mb-1 text-facebook"> {{
								__('application.dashboard.available_slots') }} </h4>
							<h6 class="text-muted">{{ __('application.dashboard.currently_available') }}</h6>
						</div>
						<h3 class="text-facebook font-weight-bold">{{ $data['total_slots'] - $data['currently_parking'] }}
						</h3>
					</div>
				</div>  --}}
			</div>
		@endif

		@if (Auth::user()->hasAnyPermission(["dashboard.slot_left"]))
			<div class="col-xl-8 stretch-card grid-margin">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-between flex-wrap mb-3">
							<div>
								<div class="card-title mb-0">{{ __('application.dashboard.slots') }}</div>
								<span class="font-10 font-weight-semibold text-muted">{{
									__('application.dashboard.total_allocation') }} {{
									$data['total_slots'] }}</span>
							</div>
							<div>
								<div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
									<div class="d-flex me-5">
										<div class="ps-2">
											<h4 class="mb-0 font-weight-semibold head-count free-box bg-available"></h4>
											<span class="font-10 font-weight-semibold text-muted">{{
												__('application.dashboard.available') }}</span>
										</div>
									</div>
									<div class="d-flex me-3 mt-2 mt-sm-0">
										<div class="ps-2">
											<h4 class="mb-0 font-weight-semibold head-count free-box bg-booked"></h4>
											<span class="font-10 font-weight-semibold text-muted">{{
												__('application.dashboard.booked') }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="bar-chart-wrapper">
							<canvas id="barchart" height="80"></canvas>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
</div>
@endsection
@push('scripts')
<script>
	var barChartLabel = @json($data['barChart']['labels']);
	var lineChartAvailableData = @json($data['barChart']['availableData']);
	var lineChartBookedData = @json($data['barChart']['bookedData']);
	var lineChartLabel = @json($data['lineChart']['labels']);
	var lineChartData = @json($data['lineChart']['data']);
</script>
<script src="{{ assetz('js/custom/dashboard/home.js') }}"></script>
@endpush