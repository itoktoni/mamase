@extends(Template::master())

@section('title')
<h4>Master Menu</h4>
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
				<div class="form-group {{ $errors->has('system_menu_type') ? 'has-error' : '' }}">
					<label>Tipe</label>
					{!! Form::select('system_menu_type', $type, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Pilih Group -', 'required']) !!}
					{!! $errors->first('system_menu_type', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('system_menu_code') ? 'has-error' : '' }}">
					<label>Code</label>
					{!! Form::text('system_menu_code', null, ['class' => 'form-control', 'id' => 'system_menu_code',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('system_menu_code', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('system_menu_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('system_menu_name', null, ['class' => 'form-control', 'id' => 'system_menu_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('system_menu_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group">
					<label>Sort</label>
					{!! Form::text('system_menu_sort', null, ['class' => 'form-control', 'id' =>
					'system_menu_sort',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
				</div>

			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('system_menu_controller') ? 'has-error' : '' }}">
					<label>Controller</label>
					{!! Form::select('system_menu_controller', $file ?? [], null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Pilih Controller -', 'required']) !!}
					{!! $errors->first('system_menu_controller', '<p class="help-block">:message</p>') !!}
				</div>

				@if(!empty($model))

				<div class="form-group {{ $errors->has('system_menu_action') ? 'has-error' : '' }}">
					<label>Action</label>
					{!! Form::select('system_menu_action', $action, null, ['class' => 'form-control', 'id' =>
					'product_name', 'placeholder' => '- Pilih Action -', 'required']) !!}
					{!! $errors->first('system_menu_action', '<p class="help-block">:message</p>') !!}
				</div>
				@else
				<div class="form-group">
					<label>Action</label>
					{!! Form::text('system_menu_action', null, ['class' => 'form-control', 'id' =>
					'system_menu_action',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
				</div>
				@endif

				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('system_menu_description', null, ['class' => 'form-control h-auto', 'id' =>
					'email',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
				</div>
			</div>
		</div>

	</div>
</div>

@if(!empty($model) && $model->field_type == MenuType::Group)
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
					<label>{{ __('Pilih Link di Menu') }}</label>
					{!! Form::select('link[]', $link, $selected ?? [], ['class' => 'form-control', 'id' =>
					'link', 'multiple']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endif

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@endpush