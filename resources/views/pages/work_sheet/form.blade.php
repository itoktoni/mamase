@extends(Template::master())

@section('title')
<h4>Lembar Kerja</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Kirim') }}</button>
	@if($model)
	<a target="_blank" href="{{ route(SharedData::get('route').'.getPdf', ['code' => $model->field_primary]) }}"
		class="btn btn-danger">Print PDF</a>
	@endif
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

				<div class="form-group">
					<label>{{ __('Ticket') }}</label>
					{!! Form::select('work_sheet_ticket_code', $ticket, request()->get('ticket_id') ?? null,
					['placeholder' =>
					'- Select Ticket -', 'class' => 'form-control ticket', ]) !!}
				</div>

				<div class="form-group {{ $errors->has('work_sheet_product_id') ? 'has-error' : '' }}">
					<label>{{ __('Product') }}</label>
					{!! Form::select('work_sheet_product_id', $product, null, ['class' => 'form-control', 'id'
					=>
					'work_sheet_product_id', 'placeholder' => '- Select Product -', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('work_sheet_location_id') ? 'has-error' : '' }}">
					<label>{{ __('Location') }}</label>
					{!! Form::select('work_sheet_location_id', $location, null, ['class' => 'form-control',
					'placeholder' => '- Select Location -']) !!}
				</div>

				<div class="row">

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('work_sheet_reported_at') ? 'has-error' : '' }}">
							<label>{{ __('Report Date') }}</label>
							{!! Form::text('work_sheet_reported_at', $model->work_sheet_reported_at ?? date('Y-m-d'), ['class' =>
							'form-control date', 'id' =>
							'work_sheet_reported_at', 'required']) !!}
							{!! $errors->first('work_sheet_reported_at', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>{{ __('Contact') }}</label>
							{!! Form::select('work_sheet_contract', $contract, null, ['class' => 'form-control
							contract']) !!}
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group pelaksana">
							<label>{{ __('Implementor') }}</label>
							{!! Form::select('implementor[]', $implementor, $model ?
							json_decode($model->field_implementor) :
							null,
							['class' => 'form-control',
							'multiple', 'data-placeholder' => 'Pilih Pelaksana']) !!}
						</div>

						<div class="form-group vendor">
							<label>{{ __('Vendor') }}</label>
							{!! Form::select('work_sheet_vendor_id', $vendor, null,
							['class' => 'form-control',
							'placeholder' => '- Pilih Vendor -']) !!}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('work_sheet_type_id') ? 'has-error' : '' }}">
							<label>Type</label>
							{!! Form::select('work_sheet_type_id', $work_type, $model->work_sheet_type_id ?? 2, ['class' => 'form-control', 'id' =>
							'work_sheet_type_id', 'placeholder' => '- Select work Type -', 'required']) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('work_sheet_status') ? 'has-error' : '' }}">
							<label>Status</label>
							{!! Form::select('work_sheet_status', $status, null, ['class' => 'form-control', 'id' =>
							'work_sheet_status', 'placeholder' => '- Select Status -']) !!}
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-6">

				<div class="form-group {{ $errors->has('work_sheet_name') ? 'has-error' : '' }}">
					<label>{{ __('Name') }}</label>
					{!! Form::text('work_sheet_name', $data_ticket ? 'Follow up : '.$data_ticket->field_name : null,
					['class' =>
					'form-control', 'id' => 'work_sheet_name', 'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('work_sheet_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group">
					<label>{{ __('Reported By') }}</label>
					{!! Form::select('work_sheet_reported_by', $user, $data_ticket->field_reported_By ?? null,
					['placeholder' =>
					'- Select User -', 'class' => 'form-control']) !!}
				</div>

				<div class="form-group {{ $errors->has('work_sheet_description') ? 'has-error' : '' }}">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('work_sheet_description', null, ['class' => 'form-control h-auto', 'id' =>
					'work_sheet_description',
					'placeholder' => 'Please fill this input', 'rows' => 9]) !!}
				</div>

				<div class="form-group {{ $errors->has('file_picture') ? 'has-error' : '' }}">
					@if(Template::isMobile())
					<label for="cameraFileInput">
						<span class="btn btn-success">Ambil Gambar</span>
						<input id="cameraFileInput" style="{!! Template::isMobile() ? 'display:none' : '' !!}"
							name="file_picture" type="file" accept="image/*" capture="environment" />
					</label>
					@else
					<label for="">{{ __('Take Picture') }}</label>
					<input id="cameraFileInput" name="file_picture" type="file" accept="image/*"
						class="btn btn-default btn-block" capture="environment" />
					@endif

					<input type="hidden" name="file_old" value="{{ $model->field_picture ?? null }}">

					<img class="img-fluid"
						src="{{ $model && $model->field_picture ? asset('storage/worksheet/'.$model->field_picture) : asset('images/picture.png') }}"
						id="pictureFromCamera" />
				</div>

			</div>
		</div>

		@if($model)
		<hr>
		<div class="form-group">
			<label>{{ __('Check') }}</label>
			{!! Form::textarea('work_sheet_check', null, ['class' => 'form-control h-auto', 'id' =>
			'work_sheet_check',
			'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
		</div>

		<div class="form-group">
			<label>{{ __('Result') }}</label>
			{!! Form::textarea('work_sheet_result', null, ['class' => 'form-control h-auto', 'id' =>
			'work_sheet_result',
			'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
		</div>
		@endif
	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))


<style>
#pictureFromCamera {
	width: 100%;
	margin-top: 16px;
}

.btn {
	display: inline-block;
	background-color: #00b531;
	color: white;
	padding: 8px 12px;
	border-radius: 4px;
	font-size: 16px;
	cursor: pointer;
}

.btn:hover {
	filter: brightness(0.9);
}
</style>

<script>
$('.ticket').change(function() {
	var id = $(".ticket option:selected").val();
	var uri = window.location.toString();
	var clean_uri = window.location.toString();
	if (uri.indexOf("?") > 0) {
		clean_uri = uri.substring(0, uri.indexOf("?"));
		window.history.replaceState({}, document.title, clean_uri);
	}
	window.location = clean_uri + '?ticket_id=' + id;
});

$('body').on('change', '.contract', function() {
	contract(this.value);
});

$(document).ready(function() {
	var data = $(".contract option:selected").val();
	contract(data);
});

function contract(data) {
	if (typeof data == "undefined") {
		$(".vendor").show();
		$(".pelaksana").hide();
	} else if (data == '1') {
		$(".vendor").show();
		$(".pelaksana").hide();
	} else {
		$(".pelaksana").show();
		$(".vendor").hide();
	}
}

document
	.getElementById("cameraFileInput")
	.addEventListener("change", function() {
		document
			.getElementById("pictureFromCamera")
			.setAttribute("src", window.URL.createObjectURL(this.files[0]));
		document
			.getElementById("pictureFromCamera")
			.style.height = 'auto';
	});
</script>

@endpush