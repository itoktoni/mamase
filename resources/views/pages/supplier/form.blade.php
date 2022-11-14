@extends(Template::master())

@section('title')
<h4>Master Vendor</h4>
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
				<div class="form-group {{ $errors->has('supplier_name') ? 'has-error' : '' }}">
					<label>Vendor Name</label>
					{!! Form::text('supplier_name', null, ['class' => 'form-control', 'id' => 'supplier_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('supplier_name', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="form-group">
					<label>Vendor Contact</label>
					{!! Form::text('supplier_contact', null, ['class' => 'form-control', 'id' =>
					'supplier_contact', 'placeholder' => 'Please fill this input', 'required']) !!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group {{ $errors->has('supplier_email') ? 'has-error' : '' }}">
					<label>Vendor Email</label>
					{!! Form::text('supplier_email', null, ['class' => 'form-control', 'id' => 'supplier_email',
					'placeholder' => 'Please fill this input']) !!}
					{!! $errors->first('supplier_email', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="form-group">
					<label>Vendor Phone</label>
					{!! Form::text('supplier_phone', null, ['class' => 'form-control', 'id' => 'supplier_phone',
					'placeholder' => 'Please fill this input', 'required']) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label>Vendor Address</label>
					{!! Form::text('supplier_address', null, ['class' => 'form-control', 'id' => 'supplier_address',
					'placeholder' => 'Please fill this input', 'required']) !!}
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