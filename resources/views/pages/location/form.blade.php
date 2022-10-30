@extends(Template::master())

@section('title')
<h4>Master Lokasi</h4>
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
				<div class="form-group {{ $errors->has('location_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('location_name', null, ['class' => 'form-control', 'id' => 'location_name',
					'placeholder' =>
					'Please fill this input', 'required']) !!}
					{!! $errors->first('location_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group">
					<label>Building</label>
					{!! Form::select('location_building_id', $building, null, ['class' => 'form-control', 'id' =>
					'location_name', 'placeholder' => '- Select building -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>Lantai</label>
					{!! Form::select('location_floor_id', $floor, null, ['class' => 'form-control', 'id' =>
					'floor_name', 'placeholder' => '- Select Floor -', 'required']) !!}
				</div>

				<div class="form-group">
					<label>PIC</label>
					{!! Form::select('location_pic_user_id', $user, null, ['class' => 'form-control', 'id' =>
					'floor_name', 'placeholder' => '- Select PIC -', 'required']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('location_description', null, ['class' => 'form-control h-auto', 'id' =>
					'location_description',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
				</div>

				<div class="form-group {{ $errors->has('location_phone') ? 'has-error' : '' }}">
					<label>{{ __('Phone') }}</label>
					{!! Form::text('location_phone', null, ['class' => 'form-control', 'id' => 'location_phone',
					'placeholder' =>
					'Please fill this input', 'required']) !!}
					{!! $errors->first('location_phone', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('location_jenis_layanan') ? 'has-error' : '' }}">
					<label>{{ __('Jenis Layanan') }}</label>
					{!! Form::text('location_jenis_layanan', null, ['class' => 'form-control', 'id' => 'location_jenis_layanan',
					'placeholder' =>
					'Please fill this input', 'required']) !!}
					{!! $errors->first('location_jenis_layanan', '<p class="help-block">:message</p>') !!}
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