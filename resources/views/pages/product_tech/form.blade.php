@extends(Template::master())

@section('title')
<h4>Jenis Teknologi</h4>
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
				<div class="form-group {{ $errors->has('product_tech_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('product_tech_name', null, ['class' => 'form-control', 'id' => 'product_tech_name',
					'placeholder' =>
					'Please fill this input', 'required']) !!}
					{!! $errors->first('product_tech_name', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::text('product_tech_description', null, ['class' => 'form-control', 'id' =>
					'product_tech_description',
					'placeholder' => 'Please fill this input']) !!}
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