@extends(Template::master())

@section('title')
<h4>Perpindahan Barang</h4>
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
				<div class="form-group {{ $errors->has('movement_product_id') ? 'has-error' : '' }}">
					<label>{{ __('Nama Alat') }}</label>
					{!! Form::select('movement_product_id', $product, request()->get('product_id') ?? null, ['class' =>
					'form-control', 'id' =>
					'product', 'placeholder' => '- Pilih Product -', 'required']) !!}
					{!! $errors->first('movement_product_id', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('movement_requested_name') ? 'has-error' : '' }}">
					<label>{{ __('Nama Pengguna') }}</label>
					{!! Form::text('movement_requested_name', null, ['class' => 'form-control', 'id' =>
					'movement_requested_name', 'placeholder' => 'Please fill this input']) !!}
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('movement_date') ? 'has-error' : '' }}">
							<label>{{ __('Date') }}</label>
							{!! Form::text('movement_date', null ?? date('Y-m-d'), ['class' => 'form-control date', 'id'
							=> 'movement_date',
							'placeholder' => 'Please fill this input', 'required']) !!}
							{!! $errors->first('movement_date', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('movement_type') ? 'has-error' : '' }}">
							<label>Tipe</label>
							{!! Form::select('movement_type', $type, null, ['class' => 'type form-control', 'id' =>
							'movement_type', 'placeholder' => '- Pilih Type -']) !!}
						</div>
					</div>
				</div>

				<div class="old form-group {{ $errors->has('movement_location_old') ? 'has-error' : '' }}">
					<label>{{ __('Lokasi alat') }}</label>
					{!! Form::select('movement_location_old', $location, $model->field_location_old ??
					$data_product->field_location_id ?? null,
					['class' => 'form-control', 'id' =>
					'movement_location_new', 'placeholder' => '- Pilih Lokasi alat -', 'required']) !!}
					{!! $errors->first('movement_location_old', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="new form-group {{ $errors->has('movement_location_new') ? 'has-error' : '' }}">
					<label>{{ __('Pindah Lokasi Ke') }}</label>
					{!! Form::select('movement_location_new', $location, null, ['class' => 'form-control', 'id' =>
					'movement_location_new', 'placeholder'
					=> '- Pilih Lokasi Ke -', 'required']) !!}
					{!! $errors->first('movement_location_new', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="vendor form-group {{ $errors->has('movement_vendor_id') ? 'has-error' : '' }}">
					<label>Vendor</label>
					{!! Form::select('movement_vendor_id', $vendor, null, ['class' => 'form-control', 'id' =>
					'movement_vendor_id', 'placeholder' => '- Pilih Vendor -']) !!}
				</div>

			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('movement_description') ? 'has-error' : '' }}">
					<label>{{ __('Keterangan') }}</label>
					{!! Form::textarea('movement_description', null, ['class' => 'form-control h-auto', 'id' =>
					'movement_description', 'placeholder' => 'Please fill this input', 'rows' => 7]) !!}
				</div>
				<div class="form-group {{ $errors->has('movement_action') ? 'has-error' : '' }}">
					<label>{{ __('Tindakan') }}</label>
					{!! Form::textarea('movement_action', null, ['class' => 'form-control h-auto', 'id' =>
					'movement_action', 'placeholder' => 'Please fill this input', 'rows' => 7]) !!}
				</div>
			</div>

		</div>

	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('mantul')
gue tambahin
@endpush

@push('javascript')

@include(Template::components('form'))
@include(Template::components('date'))

<script>
$('#product').change(function() {
	var id = $("#product option:selected").val();
	var uri = window.location.toString();
	var clean_uri = window.location.toString();
	if (uri.indexOf("?") > 0) {
		clean_uri = uri.substring(0, uri.indexOf("?"));
		window.history.replaceState({}, document.title, clean_uri);
	}
	window.location = clean_uri + '?product_id=' + id;
});

$('body').on('change', '.type', function() {
	contract(this.value);
});

$(document).ready(function() {
	var data = $(".type option:selected").val();
	contract(data);
});

function contract(data) {
	if (typeof data == "undefined" || data == "") {
		$(".vendor").hide();
		$(".old").hide();
		$(".new").hide();
	} else if (data == "{{ MovementType::Vendor }}") {
		$(".vendor").show();
		$(".old").hide();
		$(".new").hide();
	} else if (data == "{{ MovementType::Pindah }}") {
		$(".old").show();
		$(".new").show();
		$(".vendor").hide();
	} else if (data == "{{ MovementType::Recall }}") {
		$(".new").hide();
		$(".old").show();
		$(".vendor").hide();
	} else {
		$(".pelaksana").show();
		$(".vendor").hide();
	}
}
</script>


@if($model)
<script>
const data = ["movement_product_id", "movement_date"];
data.forEach(myFunction);

function myFunction(item) {
	document.getElementById(item).readOnly = true;
	document.getElementById(item).disabled = true;
}
</script>
@endif

@endpush