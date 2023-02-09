@extends(Template::master())

@section('title')
<h4>Lembar Kerja</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
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
					<label>{{ __('Tiket') }}</label>
					{!! Form::select('work_sheet_ticket_code', $ticket, request()->get('ticket_id') ?? null,
					['placeholder' =>
					'- Pilih Ticket -', 'class' => 'form-control ticket', ]) !!}
				</div>

				<div class="form-group {{ $errors->has('work_sheet_product_id') ? 'has-error' : '' }}">
					<label>{{ __('Alat') }}</label>
					{!! Form::select('work_sheet_product_id', $product, null, ['class' => 'form-control product selectize', 'id'
					=>
					'work_sheet_product_id', 'placeholder' => '- Pilih Alat -', 'required']) !!}
				</div>

				<div class="form-group {{ $errors->has('work_sheet_location_id') ? 'has-error' : '' }}">
					<label>{{ __('Ruangan') }}</label>
					{!! Form::select('work_sheet_location_id', $location, null, ['class' => 'form-control selectize',
					'placeholder' => '- Pilih Ruangan -']) !!}
				</div>

				<div class="row">

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('work_sheet_reported_at') ? 'has-error' : '' }}">
							<label>{{ __('Tanggal Laporan') }}</label>
							{!! Form::text('work_sheet_reported_at', $model->work_sheet_reported_at ?? date('Y-m-d'),
							['class' =>
							'form-control date', 'id' =>
							'work_sheet_reported_at', 'required']) !!}
							{!! $errors->first('work_sheet_reported_at', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>{{ __('Kontrak') }}</label>
							{!! Form::select('work_sheet_contract', $contract, null, ['class' => 'form-control
							contract']) !!}
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group pelaksana">
							<label>{{ __('Pilih Teknisi Internal') }}</label>
							{!! Form::select('work_sheet_implementor[]', $implementor, $model ?
							json_decode($model->field_implementor) :
							null,
							['class' => 'form-control',
							'multiple', 'data-placeholder' => 'Pilih Teknisi']) !!}
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
							<label>Tipe</label>
							{!! Form::select('work_sheet_type_id', $work_type, $model->work_sheet_type_id ?? 2, ['class'
							=> 'form-control', 'id' =>
							'work_sheet_type_id', 'placeholder' => '- Pilih work Type -', 'required']) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('work_sheet_status') ? 'has-error' : '' }}">
							<label>Status</label>
							{!! Form::select('work_sheet_status', $status, null, ['class' => 'form-control', 'id' =>
							'work_sheet_status', 'placeholder' => '- Pilih Status -']) !!}
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-6">

				<div class="form-group {{ $errors->has('work_sheet_name') ? 'has-error' : '' }}">
					<label>{{ __('Nama Pekerjaan') }}</label>
					{!! Form::text('work_sheet_name', $data_ticket ? 'Follow up : '.$data_ticket->field_name : null,
					['class' =>
					'form-control', 'id' => 'work_sheet_name', 'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('work_sheet_name', '<p class="help-block">:message</p>') !!}
				</div>

				<div class="form-group {{ $errors->has('work_sheet_reported_name') ? 'has-error' : '' }}">
					<label>{{ __('Pelapor') }}</label>
					{!! Form::text('work_sheet_reported_name', $model->field_reported_name ?? auth()->user()->name, ['class' => 'form-control h-auto', 'id' =>
					'work_sheet_reported_name',
					'placeholder' => 'Please fill this input']) !!}
				</div>

				<div class="form-group {{ $errors->has('work_sheet_description') ? 'has-error' : '' }}">
					<label>{{ __('Description') }}</label>
					{!! Form::textarea('work_sheet_description', null, ['class' => 'form-control h-auto', 'id' =>
					'work_sheet_description',
					'placeholder' => '* Wajib diisi', 'rows' => 5]) !!}
				</div>

				<div class="form-group {{ $errors->has('file_picture') ? 'has-error' : '' }}">
					@if(Template::isMobile())
					<label for="cameraFileInput">
						<span class="btn btn-success">Ambil Gambar</span>
						<input id="cameraFileInput" style="{!! Template::isMobile() ? 'display:none' : '' !!}"
							name="file_picture" type="file" accept="image/*" capture="environment" />
					</label>
					@else
					<label for="">{{ __('Ambil Gambar') }}</label>
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

	</div>
</div>

@if($model)
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Analisa') }}</label>
					{!! Form::textarea('work_sheet_check', null, ['class' => 'form-control h-auto', 'id' =>
					'work_sheet_check',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Tindakan') }}</label>
					{!! Form::textarea('work_sheet_action', null, ['class' => 'form-control h-auto', 'id' =>
					'work_sheet_action',
					'placeholder' => 'Please fill this input', 'rows' => 5]) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>{{ __('Kesimpulan') }}</label>
					{!! Form::textarea('work_sheet_result', null, ['class' => 'form-control h-auto', 'id' =>
					'work_sheet_result',
					'placeholder' => 'Please fill this input', 'rows' => 10]) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="row show-product">
					<div class="col-md-12">
						<div class="form-group {{ $errors->has('work_sheet_suggestion_id') ? 'has-error' : '' }}">
							<label>Rekomendasi Penggunaan Alat</label>
							{!! Form::select('work_sheet_suggestion_id', $saran, null, ['class' =>
							'form-control', 'id' =>
							'work_sheet_suggestion_id', 'placeholder' => '- Pilih Penggunaan Alat -', 'required']) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('work_sheet_product_fisik') ? 'has-error' : '' }}">
							<label>Cek Fisik</label>
							{!! Form::select('work_sheet_product_fisik', $product_status, null, ['class' =>
							'form-control', 'id' =>
							'work_sheet_product_fisik', 'placeholder' => '- Pilih work Sparepart -', 'required']) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('work_sheet_product_fungsi') ? 'has-error' : '' }}">
							<label>Cek Fungsi</label>
							{!! Form::select('work_sheet_product_fungsi', $product_status, null, ['class' =>
							'form-control', 'id' =>
							'work_sheet_product_fungsi', 'placeholder' => '- Pilih work Sparepart -', 'required']) !!}
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>{{ __('Keterangan Alat') }}</label>
							{!! Form::textarea('work_sheet_product_description', null, ['class' => 'form-control h-auto', 'id' =>
							'work_sheet_product_description',
							'placeholder' => 'Please fill this input', 'rows' => 2]) !!}
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endif

{!! Template::form_close() !!}

@if($model && $model->field_suggestion_id == 1)
{!! Template::form_open($model, 'postUpdateSparepart') !!}

<input type="hidden" name="product" value="{{ $model->field_product_id }}">
<input type="hidden" name="ticket" value="{{ $model->field_ticket_code }}">
<input type="hidden" name="worksheet" value="{{ $model->field_primary }}">

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-5">
				<div class="form-group {{ $errors->has('sparepart') ? 'has-error' : '' }}">
					<label>Kebutuhan Sparepart</label>
					{!! Form::select('sparepart', $sparepart, null, ['class' =>
					'form-control', 'id' =>
					'sparepart', 'placeholder' => '- Pilih work Sparepart -', 'required']) !!}
				</div>
			</div>
			<div class="col-md-1">
				<div class="form-group {{ $errors->has('qty') ? 'has-error' : '' }}">
					<label>{{ __('Qty') }}</label>
					{!! Form::text('qty', 1, ['class' => 'form-control', 'id' =>
					'qty', 'placeholder' => 'Qty']) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
					<label>{{ __('Keterangan Kebutuhan') }}</label>
					{!! Form::textarea('description', null, ['class' => 'form-control h-auto', 'id' =>
					'description', 'placeholder' => 'Please fill this input', 'rows' => 1]) !!}
				</div>
			</div>

			<div class="col-md-1 mt-4">
				<button type="submit" class="btn btn-success" id="modal-btn-save">{{ __('Tambah') }}</button>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-md-12">
				@if(!empty($spareparts))
				<div class="table-responsive" id="table_data">
					<table class="table table-bordered table-striped table-responsive-stack">
						<thead>
							<tr>
								<th class="text-left">{{ __('Nama Suku Cadang') }}</th>
								<th class="text-left">{{ __('Qty') }}</th>
								<th class="text-left">{{ __('Dekripsi Penggunaan') }}</th>
								<th class="text-center column-action">{{ __('Action') }}</th>
							</tr>
						</thead>
						<tbody>
							@forelse($spareparts as $table)
							<tr>
								<td>{{ $table->field_name }}</td>
								<td class="col-md-1 text-left">
									{{ $table->pivot->qty ?? '' }} {{ $table->field_unit_code }}
								</td>
								<td>{{ $table->pivot->description ?? '' }}</td>
								<td class="text-center">
									<a class="badge badge-danger button-delete" data="{{ $table->field_primary }}"
										href="{{ route(SharedData::get('route').'.getDeleteSparepart', ['code' => $model->field_primary, 'id' => $table->field_primary]) }}">
										Delete
									</a>
								</td>
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

{!! Template::form_close() !!}

@endif

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
$('body').on('click', '.button-delete', function(event) {
	event.preventDefault();

	var me = $(this),
		url = me.attr('href'),
		id = me.attr('data'),
		csrf_token = $('meta[name="csrf-token"]').attr('content');

	swal({
		title: '{{ __("Are you sure want to delete this data ?") }}',
		text: '{{ __("You not be able to revert this!") }}',
		icon: "warning",
		buttons: true,
	}).then((result) => {
		if (result) {
			$.ajax({
				url: url,
				type: "GET",
				dataType: 'json',
				success: function(response) {
					if (response.status) {
						swal({
							icon: 'success',
							title: '{{ __("Success!") }}',
							text: '{{ __("Data has been deleted!") }}',
							timer: 3000
						}).then(function() {
							window.location.reload();
						});

					} else if (response.status == false) {
						swal({
							icon: 'error',
							title: '{{ __("Error!") }}',
							text: response.data
						});
					} else {
						swal({
							icon: 'error',
							title: '{{ __("Error!") }}',
							text: '{{ __("Data failed to deleted!") }}'
						});
					}
				},
				error: function(xhr, status, error) {

					if (xhr.status == 422) {

						swal({
							icon: 'error',
							title: 'Oops...',
							text: '{{ __("Validation Error !") }}'
						});
					} else {
						swal({
							icon: 'error',
							title: 'Oops...',
							text: '{{ __("Something went wrong!") }}'
						});
					}
				}
			});
		} else {

		}
	});
});

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

$('body').on('change', '.product', function() {
	showProduct(this.value);
});

$(document).ready(function() {
	var data = $(".product option:selected").val();
	showProduct(data);
});


function showProduct(data){
	$(".show-product").show();
	if (typeof data == "undefined" || data == '') {
		$(".show-product").hide();
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