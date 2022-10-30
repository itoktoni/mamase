@extends(Template::master())

@section('title')
<h4>Surat Perintah Kerja</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
	@if($model)
	<a target="_blank" href="{{ route(SharedData::get('route').'.getPdf', ['code' => $model->field_primary]) }}"
		class="btn btn-danger">Print PDF</a>
	@endif
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

				<div class="form-group {{ $errors->has('spk_vendor_id') ? 'has-error' : '' }}">
					<label>{{ __('Vendor') }}</label>
					{!! Form::select('spk_vendor_id', $vendor, null, ['class' => 'form-control', 'id' =>
					'spk_vendor_id', 'placeholder' => '- Select Vendor -', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('spk_product_id') ? 'has-error' : '' }}">
					<label>{{ __('Product') }}</label>
					{!! Form::select('spk_product_id', $product, null, ['class' => 'form-control', 'id' =>
					'spk_product_id', 'placeholder' => '- Select Product -', 'required']) !!}
				</div>

				<div class="row">

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('spk_date') ? 'has-error' : '' }}">
							<label>{{ __('Date') }}</label>
							{!! Form::text('spk_date', $model->spk_date ?? date('Y-m-d'), ['class' => 'form-control
							date', 'id'
							=> 'spk_date', 'placeholder'
							=> 'Please fill this input', 'required']) !!}
							{!! $errors->first('spk_date', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('spk_status') ? 'has-error' : '' }}">
							<label>Status</label>
							{!! Form::select('spk_status', $status, null, ['class' => 'form-control', 'id' =>
							'spk_status', 'placeholder' => '- Select Status -']) !!}
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('spk_estimation') ? 'has-error' : '' }}">
							<label>{{ __('Estition Price') }}</label>
							{!! Template::number('spk_estimation') !!}
							{!! $errors->first('spk_estimation', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('spk_realisation') ? 'has-error' : '' }}">
							<label>{{ __('Realisation Price') }}</label>
							{!! Template::number('spk_realisation') !!}
							{!! $errors->first('spk_realisation', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-6">

				<div class="form-group {{ $errors->has('spk_work_sheet_code') ? 'has-error' : '' }}">
					<label>WorkSheet Code</label>
					{!! Form::select('spk_work_sheet_code', $work_sheet, null, ['class' => 'form-control', 'id'
					=>
					'spk_work_sheet_code', 'placeholder' => '- Select work sheet -', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('spk_description') ? 'has-error' : '' }}">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('spk_description', null, ['class' => 'form-control h-auto', 'id' =>
					'spk_description',
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
@include(Template::components('date'))
@endpush