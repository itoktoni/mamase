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
					<label>{{ __('Name') }}</label>
					{!! Form::text('ticket_topic_name', null, ['class' => 'form-control', 'id' => 'ticket_topic_name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('ticket_topic_name', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('unit_name') ? 'has-error' : '' }}">
				<label>Active</label>
				{{ Form::select('ticket_topic_active', $status, null, ['class'=> 'form-control', 'id' => 'ticket_topic_active']) }}
				</div>
			</div>
		</div>
	</div>
</div>
@if($model)
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
					<label>{{ __('Pilih User Responsible') }}</label>
					{!! Form::select('user[]', $user, $selected ?? [], ['class' => 'form-control', 'id' =>
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