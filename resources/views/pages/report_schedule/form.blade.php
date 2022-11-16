@extends(Template::master())

@section('title')
<h4>{{ __('Report') }} Tiket</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Generate') }}</button>
</div>
@endsection

@section('container')

{!! Template::form_report() !!}

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
				<div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
					<label>{{ __('Start Date') }}</label>
					{!! Form::text('start_date', null, ['class' => 'form-control date', 'id' => 'start_date',
					'placeholder'
					=> 'Please fill this input']) !!}
					{!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
					<label>{{ __('End Date') }}</label>
					{!! Form::text('end_date', null, ['class' => 'form-control date', 'id' => 'end_date', 'placeholder'
					=> 'Please fill this input']) !!}
					{!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('schedule_type') ? 'has-error' : '' }}">
					<label>{{ __('Schedule Type') }}</label>
					{!! Form::select('schedule_type', $type, null, ['class' => 'form-control', 'id' =>
					'schedule_type', 'placeholder' => '- Pilih Status -']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('schedule_user') ? 'has-error' : '' }}">
					<label>User</label>
					{!! Form::select('schedule_user', $user, null, ['class' => 'form-control', 'id'
					=> 'schedule_user', 'placeholder' => '- Pilih User -']) !!}
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
