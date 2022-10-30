@extends(Template::master())

@section('title')
<h4>Master Group</h4>
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
				<div class="form-group {{ $errors->has('system_group_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('system_group_name', null, ['class' => 'form-control', 'id' => 'system_group_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('system_group_name', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="form-group">
					<label>Enable</label>
					{{ Form::select('system_group_enable', $status, null, ['class'=> 'form-control', 'id' => 'system_group_active']) }}
				</div>
				<div class="form-group">
					<label>Icon</label>
					{!! Form::text('system_group_icon', null, ['class' => 'form-control', 'id' => 'system_group_icon',
					'placeholder' => 'Please fill this input']) !!}
					<span class="help-block">To add more icon please <a target="_blank"
							href="https://feathericons.com">https://feathericons.com</a></span>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Group Code</label>
					{!! Form::text('system_group_code', null, ['class' => 'form-control', 'id' => 'system_group_code',
					'readonly',
					'placeholder' => 'Please fill this input']) !!}
				</div>

				<div class="form-group {{ $errors->has('system_group_icon') ? 'has-error' : '' }}">
					<label>Link to Url</label>
					{!! Form::text('system_group_url', null, ['class' => 'form-control', 'id' => 'system_group_url',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('system_group_url', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group">
					<label>Sort</label>
					{!! Form::number('system_group_sort', null, ['class' => 'form-control', 'id' => 'system_group_sort',
					'placeholder' => 'Please fill this input']) !!}
				</div>
			</div>

		</div>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('menu') ? 'has-error' : '' }}">
					<label>{{ __('Pilih Menu di group') }}</label>
					{!! Form::select('menu[]', $menu, $selected ?? [], ['class' => 'form-control', 'id' =>
					'menu', 'multiple']) !!}
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