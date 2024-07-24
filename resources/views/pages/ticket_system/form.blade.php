@extends(Template::master())

@section('title')
<h4>Tiket System</h4>
@endsection

@section('action')
<div class="button">
	<a href="{{ URL::previous() }}" class="btn btn-warning">Back</a>
	@if($model)
	<a target="_blank" href="{{ route(SharedData::get('route').'.getPdf', ['code' => $model->field_primary]) }}"
		class="btn btn-danger">{{ __('Print PDF') }}</a>
	@endif

	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Kirim') }}</button>

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

			<div class="col-md-12">
				<div class="form-group {{ $errors->has('ticket_system_product_id') ? 'has-error' : '' }}">
					<label>{{ __('Nama Alat') }}</label>
					{!! Form::select('ticket_system_product_id', $product, $selected_product->field_primary ?? null, ['class' => 'form-control selectize', 'id'
					=> 'product', 'placeholder' => '- Pilih Product -']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="row">
					@if(env('TICKET_DEPARTMENT', true))
					<div class="col-md-12">
						<div class="form-group {{ $errors->has('ticket_system_department_id') ? 'has-error' : '' }}">
							<label>{{ __('Department') }}</label>
							{!! Form::select('ticket_system_department_id', $department, null, ['class' =>
							'form-control', 'id'
							=> 'ticket_system_department_id', 'placeholder' => '- Pilih Department -', 'required']) !!}
						</div>
					</div>
					@endif

					<div class="col-md-6">
						<div class="form-group {{ $errors->has('ticket_system_topic_id') ? 'has-error' : '' }}">
							<label>{{ __('Kategori Tiket') }}</label>
							{!! Form::select('ticket_system_topic_id', $ticket_topic, $selected_category->field_primary ?? null, ['class' => 'form-control',
							'id' =>
							'ticket_system_topic_id', 'placeholder' => '- Pilih Kategori Tiket -', 'required']) !!}
						</div>
					</div>

					<div class="col-md-6">

						<div class="form-group {{ $errors->has('work_sheet_reported_at') ? 'has-error' : '' }}">
							<label>{{ __('Nama Pelapor') }}</label>
							{!! Form::text('ticket_system_reported_name', $model->field_reported_name ??
							auth()->user()->name, ['class' => 'form-control', 'id' =>
							'ticket_system_reported_name', Template::isUser() ? 'readonly' : '']) !!}
							{!! $errors->first('ticket_system_reported_name', '<p class="help-block">:message</p>') !!}
						</div>

					</div>
				</div>

				<div class="form-group {{ $errors->has('ticket_system_location_id') ? 'has-error' : '' }}">
					<label>{{ __('Ruangan') }}</label>
					{!! Form::select('ticket_system_location_id', $location, $selected_location->field_primary ?? null, ['class' => 'form-control selectize',
					'placeholder' => '- Pilih Ruangan -']) !!}
				</div>

				<div class="form-group {{ $errors->has('ticket_system_description') ? 'has-error' : '' }}">
					<label>{{ __('Keterangan Permasalahan') }}</label>
					{!! Template::textarea('ticket_system_description', null, 5) !!}
				</div>

				@if(!empty($model) && $model->field_action)
				<div class="form-group {{ $errors->has('ticket_system_action') ? 'has-error' : '' }}">
					<label>{{ __('Tindakan') }}</label>
					{!! Template::textarea('ticket_system_action', null, 5) !!}
				</div>
				@endif

			</div>

			<div class="col-md-6">

				<div class="row">
					<div class="col-md-5">
						<div class="form-group {{ $errors->has('work_sheet_reported_at') ? 'has-error' : '' }}">
							<label>{{ __('Tanggal Laporan') }}</label>
							{!! Form::text('ticket_system_reported_at', date('Y-m-d') ?? null, ['class' => 'form-control
							date', 'id' =>
							'ticket_system_reported_at', 'placeholder' => 'Date', 'required']) !!}
							{!! $errors->first('ticket_system_reported_at', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
					<div class="col-md-7">

						@if(!Template::greatherAdmin())
						<input type="hidden" value="{{ env('TICKET_WORKSHEET') }}" name="ticket_system_work_type_id">
						<div class="form-group {{ $errors->has('ticket_system_work_type_id') ? 'has-error' : '' }}">
							<label>{{ __('Tipe') }}</label>
							{!! Form::text('', 'Permintaan Perbaikan', ['class' => 'form-control', 'readonly']) !!}
						</div>
						@else
						<div class="form-group {{ $errors->has('ticket_system_work_type_id') ? 'has-error' : '' }}">
							<label>{{ __('Tipe') }}</label>
							{!! Form::select('ticket_system_work_type_id', $type,
							$model->ticket_system_work_type_id ?? env('TICKET_WORKSHEET'), ['class' => 'form-control',
							'placeholder' => '- Type -']) !!}
						</div>
						@endif

					</div>
				</div>

				<div class="row">
					<div class="col-md-5">
						<div class="form-group {{ $errors->has('ticket_system_status') ? 'has-error' : '' }}">
							<label>Status</label>
							{!! Form::select('ticket_system_status', $status, null, ['class' => 'form-control', 'id' =>
							'ticket_system_status', 'placeholder' => '- Pilih Status -']) !!}
						</div>
					</div>
					<div class="col-md-7">
						<div class="form-group {{ $errors->has('ticket_system_priority') ? 'has-error' : '' }}">
							<label>Prioritas</label>
							{!! Form::select('ticket_system_priority', $priority, null, ['class' => 'form-control', 'id'
							=>
							'ticket_system_priority', 'placeholder' => '- Pilih Prioritas -']) !!}
						</div>
					</div>
				</div>

				<div class="form-group {{ $errors->has('file_picture') ? 'has-error' : '' }}">

					<label for="cameraFileInput">
						<input id="cameraFileInput" class="btn btn-default" style="{!! Template::isMobile() ? 'display:none' : '' !!}"
							name="file_picture" type="file" accept="image/*" capture="environment" />
					</label>

					<input type="hidden" name="file_old" value="{{ $model->field_picture ?? null }}">

					<img class="img-fluid" style="height: {{ $model && $model->field_picture ? 'auto' : '0px' }}"
						src="{{ $model && $model->field_picture ? asset('files/ticket/'.$model->field_picture) : asset('images/picture.png') }}"
						id="pictureFromCamera" />
				</div>

			</div>
		</div>
	</div>
</div>

{!! Template::form_close() !!}

@if($model && auth()->user()->type >= RoleType::Admin)
{!! Template::form_open($model, 'postUpdateWorksheet') !!}

<div class="card">
	<div class="card-body">
		<div class="row">

			<div class="col-md-4">
				<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
					<label>Nama Worksheet</label>
					{!! Form::text('name', $model->has_type->field_name ?? '', ['class' => 'form-control', 'id' =>
					'ticket_system_reported_at', 'placeholder' => __('Work sheet Name'), 'required']) !!}
					{!! $errors->first('ticket_system_reported_at', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<label>Status</label>
					{!! Form::select('contract', $contract, null, ['class' => 'form-control contract']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<label>Pelaksana</label>
				<div class="form-group pelaksana">
					{!! Form::select('implementor[]', $implementor,
					null, ['class' => 'form-control',
					'multiple', 'data-placeholder' => 'Pilih Pelaksana']) !!}
				</div>

				<div class="form-group vendor">
					{!! Form::select('work_sheet_vendor_id', $vendor, null,
					['class' => 'form-control',
					'placeholder' => '- Pilih Vendor -']) !!}
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Alat</label>
					{!! Form::select('product', $product, $model->ticket_system_product_id ?? null,
					['class' => 'form-control',
					'placeholder' => '- Pilih Product -']) !!}
				</div>
			</div>

			<div class="col-md-5">
				<div class="form-group">
					<label>Tipe</label>
					{!! Form::select('type', $type, $model->ticket_system_work_type_id ?? env('TICKET_WORKSHEET'),
					['class' => 'form-control',
					'placeholder' => '- Pilih Tipe -']) !!}
				</div>
			</div>

			<div class="col-md-1">
				<div class="d-flex justify-content-end mt-4">
					<button type="submit" class="btn btn-success btn-lg" id="modal-btn-success">{{ __('Create') }}
					</button>
				</div>
			</div>

		</div>

	</div>
</div>

{!! Template::form_close() !!}
@endif

@if($worksheet)
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-left column-action">{{ __('Code') }}</th>
							<th class="text-left column-action">{{ __('Name') }}</th>
							<th class="text-left column-action">{{ __('Kontrak') }}</th>
							<th class="text-left column-action">{{ __('Status') }}</th>
							<th class="text-left column-action">{{ __('Updated Date') }}</th>
							<th class="text-left column-action">{{ __('Impelement By') }}</th>
							<th class="text-center column-action">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@forelse($worksheet as $table)
						<tr>
							<td class="">
								<u>
									{{ Views::uiiShort($table->field_primary) }}
								</u>
							</td>
							<td class="">{{ $table->field_name }}</td>
							<td class="">{{ KontrakType::getDescription($table->field_contract) }}</td>
							<td class="">{{ $table->field_status }}</td>
							<td class="">{{ $table->field_updated_at }}</td>
							<td class="">
								@if($table->field_contract == KontrakType::Kontrak)
								{{ $table->has_vendor->field_name ?? '' }}
								@else
								{{ Query::getTeknisi(json_decode($table->field_implementor)) ?? '' }}
								@endif
							</td>
							<td class="col-md-2 text-center column-action">
								@if($model && auth()->user()->type >= RoleType::Teknisi)
								<a size="modal-xl" class="btn btn-primary btn-sm btn-block"
									href="{{ route(env('WORK_ROUTE').'.getUpdate', ['code' => $table->field_primary]) }}">
									{{ __('Lihat') }}
								</a>
								@endif
								@if($model && auth()->user()->type >= RoleType::Admin)
								<a class="btn btn-danger btn-sm button-delete btn-block" data="{{ $table->field_primary }}"
									href="{{ route(env('WORK_ROUTE').'.postDelete', ['code' => $table->field_primary]) }}">
									{{ __('Delete') }}
								</a>
								@endif
							</td>
						</tr>
						@empty
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endif

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))
@include(Template::components('table'))

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

<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
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

function contract(data) {
	if (typeof data === "undefined") {
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

$(document).ready(function() {
	var data = $(".contract option:selected").val();
	contract(data);

	$('body').on('change', '.contract', function() {
		contract(this.value);
	});

	$('#product').change(function() {
		var id = $("#product option:selected").val();
		var uri = window.location.toString();
		var clean_uri = window.location.toString();
		if (uri.indexOf("?") > 0) {
			clean_uri = uri.substring(0, uri.indexOf("?"));
			window.history.replaceState({}, document.title, clean_uri);
		}
		window.location = clean_uri + '?id=' + id;
	});
});
</script>

@endpush