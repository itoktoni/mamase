@extends(Template::master())

@section('title')
<h4>Perpindahan Barang</h4>
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
				<div class="form-group {{ $errors->has('movement_product_id') ? 'has-error' : '' }}">
					<label>{{ __('Product Name') }}</label>
					{!! Form::select('movement_product_id', $product, null, ['class' => 'form-control', 'id' =>
					'movement_product_id', 'placeholder' => '- Select Product -', 'required']) !!}
					{!! $errors->first('movement_product_id', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="form-group {{ $errors->has('movement_date') ? 'has-error' : '' }}">
					<label>{{ __('Date') }}</label>
					{!! Form::text('movement_date', null, ['class' => 'form-control date', 'id' => 'movement_date',
					'placeholder' => 'Please fill this input', 'required']) !!}
					{!! $errors->first('movement_date', '<p class="help-block">:message</p>') !!}
				</div>
				@if($model)
				<div class="form-group {{ $errors->has('movement_location_old') ? 'has-error' : '' }}">
					<label>{{ __('Location Old') }}</label>
					{!! Form::select('movement_location_old', $location, null, ['class' => 'form-control', 'id' =>
					'movement_location_new', 'placeholder' => '- Select Location Old -', 'required', 'readonly
					disabled']) !!}
					{!! $errors->first('movement_location_old', '<p class="help-block">:message</p>') !!}
				</div>
				@endif
				<div class="form-group {{ $errors->has('movement_location_new') ? 'has-error' : '' }}">
					<label>{{ __('Location New') }}</label>
					{!! Form::select('movement_location_new', $location, null, ['class' => 'form-control', 'id' =>
					'movement_location_new', 'placeholder'
					=> '- Select Location New -', 'required']) !!}
					{!! $errors->first('movement_location_new', '<p class="help-block">:message</p>') !!}
				</div>
				@if($model)
				<div class="form-group {{ $errors->has('movement_status') ? 'has-error' : '' }}">
					<label>Status</label>
					{!! Form::select('movement_status', $status, null, ['class' => 'form-control', 'id' =>
					'movement_status', 'placeholder' => '- Select Status -']) !!}
				</div>
				@endif
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('movement_description') ? 'has-error' : '' }}">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('movement_description', null, ['class' => 'form-control h-auto', 'id' =>
					'movement_description', 'placeholder' => 'Please fill this input', 'rows' => 7]) !!}
				</div>
				<div class="form-group {{ $errors->has('movement_reason') ? 'has-error' : '' }}">
					<label>{{ __('Reason') }}</label>
					{!! Form::textarea('movement_reason', null, ['class' => 'form-control h-auto', 'id' =>
					'movement_reason', 'placeholder' => 'Please fill this input', 'rows' => 7]) !!}
				</div>
			</div>
		</div>

	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('mantul')
gue tambahin
@endpush

@push('javascript')

@include(Template::components('form'))
@include(Template::components('date'))

@if($model)
<script>
const data = ["movement_product_id", "movement_date"];
data.forEach(myFunction);

function myFunction(item) {
	document.getElementById(item).readOnly = true;
	document.getElementById(item).disabled = true;
}
</script>
@endif

@endpush