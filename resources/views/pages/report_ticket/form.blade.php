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
					=> 'Tanggal Awal']) !!}
					{!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
					<label>{{ __('End Date') }}</label>
					{!! Form::text('end_date', null, ['class' => 'form-control date', 'id' => 'end_date', 'placeholder'
					=> 'Tanggal Akhir']) !!}
					{!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('ticket_system_topic_id') ? 'has-error' : '' }}">
					<label>Topik Ticket</label>
					{!! Form::select('ticket_system_topic_id', $ticket_topic, null, ['class' => 'form-control', 'id' =>
					'ticket_system_topic_id', 'placeholder' => '- Pilih Status -']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('ticket_system_work_type_id') ? 'has-error' : '' }}">
					<label>Tipe Pekerjaan</label>
					{!! Form::select('ticket_system_work_type_id', $type, null, ['class' => 'form-control', 'id'
					=>
					'ticket_system_work_type_id', 'placeholder' => '- Pilih Type -']) !!}
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