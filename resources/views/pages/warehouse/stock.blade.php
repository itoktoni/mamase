@extends(Template::master())

@section('title')
<h4>Stock Gudang</h4>
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

				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label>Sparepart</label>
							{{ Form::select('warehouse_sparepart_id', $sparepart, $model->warehouse_sparepart_id ?? null, ['class'=> 'form-control', 'id' => 'warehouse_active', 'placeholder' => '- Pilih Sparepart -']) }}
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>{{ __('Qty') }}</label>
							{!! Form::number('warehouse_qty', null, ['class' => 'form-control', 'id' =>
							'warehouse_qty',
							'placeholder' => 'Qty']) !!}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Location</label>
					{{ Form::select('warehouse_location_id', $location, $model->warehouse_location_id ?? 1000, ['class'=> 'form-control', 'id' => 'warehouse_active', 'placeholder' => '- Pilih Location -']) }}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('warehouse_description', null, ['class' => 'form-control h-auto', 'id' =>
					'warehouse_description',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
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