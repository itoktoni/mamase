@extends(Template::master())

@section('title')
<h4>Master Sparepart</h4>
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
				<div class="form-group {{ $errors->has('sparepart_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('sparepart_name', null, ['class' => 'form-control', 'id' => 'sparepart_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('sparepart_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('sparepart_description', null, ['class' => 'form-control h-auto', 'id' =>
					'sparepart_description', 'placeholder' => 'Please fill this input', 'rows' => 9]) !!}
				</div>

				<div class="form-group">
					<label>Stock</label>
					{!! Form::text('sparepart_stock', null, ['class' => 'form-control', 'id' => 'sparepart_stock',
					'placeholder'
					=> 'Please fill this input']) !!}
				</div>

			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Location</label>
					{!! Form::select('sparepart_location_id', $location, null, ['class' => 'form-control', 'id' =>
					'sparepart_location_id', 'placeholder' => '- Pilih Location -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Product</label>
					{!! Form::select('sparepart_product_id', $product, null, ['class' => 'form-control', 'id' =>
					'sparepart_product_id', 'placeholder' => '- Pilih Location -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Brand</label>
					{!! Form::select('sparepart_brand_id', $brand, null, ['class' => 'form-control', 'id' =>
					'sparepart_brand_id', 'placeholder' => '- Pilih Unit -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Type</label>
					{!! Form::select('sparepart_type_id', $type, null, ['class' => 'form-control', 'id' =>
					'sparepart_type_id', 'placeholder' => '- Pilih Type -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Unit</label>
					{!! Form::select('sparepart_unit_code', $unit, null, ['class' => 'form-control', 'id' =>
					'sparepart_unit_code', 'placeholder' => '- Pilih Unit -', 'required']) !!}
				</div>
			</div>
		</div>
	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@endpush