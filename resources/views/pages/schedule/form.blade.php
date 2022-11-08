@extends(Template::master())

@section('title')
<h4>Master Schedule</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
</div>
@endsection

@section('container')

{!! Template::form_open($model) !!}

@if(!request()->ajax())
<div class="page-header">
	<div class="header-container container-fluid d-sm-flex justify-content-between">
		@yield('title')
		@yield('action')
	</div>
</div>
@endif

<div class="card">
	<div class="card-body">

		<div class="row">

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('schedule_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('schedule_name', null, ['class' => 'form-control', 'id' => 'schedule_name',
					'placeholder' => 'Please fill this input', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('schedule_location_id') ? 'has-error' : '' }}">
					<label>{{ __('Location') }}</label>
					{!! Form::select('schedule_location_id', $location, null, ['class' => 'form-control', 'id' =>
					'schedule_location_id', 'placeholder' => '- Select Location -', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('schedule_product_id') ? 'has-error' : '' }}">
					<label>{{ __('Product') }}</label>
					{!! Form::select('schedule_product_id', $product, null, ['class' => 'form-control', 'id' =>
					'schedule_product_id', 'placeholder' => '- Select Product -', 'required']) !!}
				</div>

				<div class="row">

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('schedule_number') ? 'has-error' : '' }}">
							<label>{{ __('Banyak') }}</label>
							{!! Form::text('schedule_number', $model->schedule_number ?? 1, ['class' => 'form-control',
							'id' =>
							'schedule_number',
							'placeholder' => 'Qty', 'required']) !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('schedule_every') ? 'has-error' : '' }}">
							<label>{{ __('Every') }}</label>
							{!! Form::select('schedule_every', $every, null, ['class' => 'form-control', 'id' =>
							'schedule_every', 'placeholder' => '- Select Every-', 'required']) !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('schedule_start_date') ? 'has-error' : '' }}">
							<label>{{ __('Start Date') }}</label>
							{!! Form::text('schedule_start_date', $model->schedule_start_date ?? date('Y-m-d'), ['class'
							=> 'form-control date', 'id' =>
							'schedule_start_date', 'required']) !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('schedule_times') ? 'has-error' : '' }}">
							<label>{{ __('Number') }}</label>
							{!! Form::text('schedule_times', $model->schedule_times ?? 1, ['class' => 'form-control',
							'id' =>
							'schedule_times',
							'placeholder' => 'Qty', 'required']) !!}
						</div>
					</div>

				</div>

			</div>

			<div class="col-md-6">

				<div class="form-group {{ $errors->has('schedule_status') ? 'has-error' : '' }}">
					<label>{{ __('Status') }}</label>
					{!! Form::select('schedule_status', $status, $model->schedule_status ?? env('TICKET_SCHEDULE'),
					['class' => 'form-control', 'id' =>
					'schedule_status', 'placeholder' => '- Select Status -']) !!}
				</div>

				<div class="form-group {{ $errors->has('schedule_description') ? 'has-error' : '' }}">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('schedule_description', null, ['class' => 'form-control h-auto', 'id' =>
					'schedule_description', 'placeholder' => 'Please fill this input', 'rows' => 9]) !!}
				</div>
			</div>
		</div>

	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr(".date", {
	enableTime: false,
	minDate: "today",
	dateFormat: "Y-m-d"
});
</script>

@endpush