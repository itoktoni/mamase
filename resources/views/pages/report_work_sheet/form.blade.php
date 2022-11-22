@extends(Template::master())

@section('title')
<h4>{{ __('Report') }} Lembar Kerja</h4>
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
					{!! Form::text('start_date', null, ['class' => 'form-control date',
						'id' => 'start_date', 'placeholder' => __('Start Date')]) !!}
					{!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
					<label>{{ __('End Date') }}</label>
					{!! Form::text('end_date', null, ['class' => 'form-control date',
						'id' => 'end_date', 'placeholder' => __('End Date')]) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('ticket_system_department_id') ? 'has-error' : '' }}">
					<label>Alat</label>
					{!! Form::select('work_sheet_producy_id', $product, null, ['class' => 'form-control', 'id' =>
					'work_sheet_product_id', 'placeholder' => '- Pilih Status -']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('ticket_system_department_id') ? 'has-error' : '' }}">
					<label>Ruangan</label>
					{!! Form::select('work_sheet_location_id', $location, null, ['class' => 'form-control', 'id' =>
					'work_sheet_location_id', 'placeholder' => '- Pilih Ruangan -']) !!}
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group {{ $errors->has('ticket_system_topic_id') ? 'has-error' : '' }}">
					<label>{{ __('Tipe Pekerjaan') }}</label>
					{!! Form::select('work_sheet_type_id', $work_type, null, ['class' => 'form-control', 'id' =>
					'work_sheet_type_id', 'placeholder' => '- Pilih Status -']) !!}
				</div>
			</div>

			@if(Template::greatherAdmin())

			<div class="col-md-3">
				<div class="form-group">
					<label>{{ __('Contact') }}</label>
					{!! Form::select('work_sheet_contract', $kontrak, null, ['class' => 'form-control
					contract', 'placeholder' => '- Pilih Tipe Kontrak -']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group teknisi">
					<label>{{ __('Teknisi') }}</label>
					{!! Form::select('teknisi[]', $teknisi, $model ?
					json_decode($model->field_teknisi_data) :
					null, ['class' => 'form-control',
					'multiple', 'data-placeholder' => 'Pilih Pelaksana']) !!}
				</div>

				<div class="form-group vendor">
					<label>{{ __('Vendor') }}</label>
					{!! Form::select('work_sheet_vendor_id', $supplier, null,
					['class' => 'form-control',
					'placeholder' => '- Pilih Vendor -']) !!}
				</div>
			</div>

			@endif

		</div>
	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))

@if(Template::greatherAdmin())
<script>
$('body').on('change', '.contract', function() {
	reset();
	contract(this.value);
});

$(document).ready(function() {
	reset();
	var data = $(".contract option:selected").val();
	contract(data);
});

function reset(){
	$(".vendor").hide();
	$(".teknisi").hide();
}

function contract(data) {
	if (typeof data == "undefined") {
		$(".vendor").hide();
		$(".teknisi").hide();
	} else if (data == '1') {
		$(".vendor").show();
		$(".teknisi").hide();
	} else if (data == '0') {
		$(".teknisi").show();
		$(".vendor").hide();
	}
	else{
		reset();
	}
}
</script>
@endif
@endpush
