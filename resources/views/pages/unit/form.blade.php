@extends(Template::master())

@section('title')
<h4>Master Satuan</h4>
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
				<div class="form-group {{ $errors->has('unit_code') ? 'has-error' : '' }}">
					<label>Code</label>
					{!! Form::text('unit_code', null, ['class' => 'form-control', 'id' => 'unit_code', 'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('unit_code', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('unit_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('unit_name', null, ['class' => 'form-control', 'id' => 'unit_name', 'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('unit_name', '<p class="help-block">:message</p>') !!}
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