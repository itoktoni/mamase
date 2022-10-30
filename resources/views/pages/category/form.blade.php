@extends(Template::master())

@section('title')
<h4>Master Category</h4>
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
				<div class="form-group {{ $errors->has('category_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('category_name', null, ['class' => 'form-control', 'id' => 'category_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('category_name', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="form-group">
					<label>Active</label>
					{{ Form::select('category_active', $status, null, ['class'=> 'form-control', 'id' => 'category_active']) }}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('category_description', null, ['class' => 'form-control h-auto', 'id' =>
					'category_description',
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