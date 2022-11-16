@extends(Template::master())

@section('title')
<h4>Data Pengguna</h4>
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
				<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
					<label>{{ __('Full Name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'required']) !!}
					{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
					<label>{{ __('Username') }}</label>
					{!! Form::text('username', null, ['class' => 'form-control', 'id' => 'username', 'required']) !!}
					{!! $errors->first('username', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
					<label>{{ __('Handphone') }}</label>
					{!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone', 'required']) !!}
					{!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Role</label>
					{!! Form::select('role', $roles, null, ['class' => 'form-control', 'id' =>
					'user_name', 'placeholder' => '- Pilih role -', 'required']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
					<label>Email address</label>
					{!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
					{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
					<label>Password</label>
					{!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
					{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Vendor</label>
					{!! Form::select('vendor', $vendor, null, ['class' => 'form-control', 'id' =>
					'user_name', 'placeholder' => '- Pilih vendor -', 'required']) !!}
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