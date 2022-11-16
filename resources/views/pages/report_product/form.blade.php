@extends(Template::master())

@section('title')
<h4>{{ __('Report') }} Product</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" name="type" value="report" class="btn btn-primary" id="modal-btn-save">{{ __('Generate') }}</button>
	<button type="submit" name="type" value="barcode" class="btn btn-danger" id="modal-btn-save">{{ __('Print Label') }}</button>
</div>
@endsection

@section('container')

{!! Form::open(['url' => route(SharedData::get('route').'.getPrint'), 'class' => 'form-horizontal needs-validation',
'method' => 'GET']) !!}

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
				<div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
					<label>{{ __('Start Date') }}</label>
					{!! Form::text('start_date', null, ['class' => 'form-control date', 'id' => 'start_date',
					'placeholder'
					=> 'tanggal awal']) !!}
					{!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
					<label>{{ __('End Date') }}</label>
					{!! Form::text('end_date', null, ['class' => 'form-control date', 'id' => 'end_date', 'placeholder'
					=> 'tanggal akhir']) !!}
					{!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('ticket_system_department_id') ? 'has-error' : '' }}">
					<label>Product</label>
					{!! Form::select('product_data[]', $product, null, ['class' => 'form-control', 'id' =>
					'work_sheet_product_id', 'multiple']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('ticket_system_department_id') ? 'has-error' : '' }}">
					<label>Location</label>
					{!! Form::select('location', $location, null, ['class' => 'form-control', 'id' =>
					'location', 'placeholder' => '- Pilih Location -']) !!}
				</div>
			</div>

		</div>
	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))
@endpush