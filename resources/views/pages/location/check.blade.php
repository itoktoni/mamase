@extends(Template::master())

@section('title')
<h4>Ruangan {{ $model->field_name ?? '' }}</h4>
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
			<input type="hidden" name="location_id" value="{{ $model->field_primary ?? '' }}">
			<input type="hidden" name="location_name" value="{{ $model->field_name ?? '' }}">

			<div class="" id="table_data ">
				<table class="table table-bordered table-striped table-responsive">
					<thead>
						<tr>
							<th class="column-checkbox">
								<input class="btn-check-d" type="checkbox">
							</th>
							<th class="text-left col-md-4">Nama Alat (centang jika rusak)</th>
							<th class="text-center col-md-4">Keterangan</th>
							<th class="text-center col-md-4">Tindakan</th>
						</tr>
					</thead>
					<tbody>
						@forelse($product as $table)
						<tr>
							<td><input type="checkbox" class="checkbox" name="check[{{ $loop->iteration }}][id]" value="{{ $table->field_primary }}">
							</td>
							<td>{{ $table->field_name }}</td>
							<td><textarea class="form-control" name="check[{{ $loop->iteration }}][description]" id="" cols="30" rows="3"></textarea></td>
							<td><textarea class="form-control" name="check[{{ $loop->iteration }}][action]" id="" cols="30" rows="3"></textarea></td>
						</tr>
						@empty
						@endforelse
					</tbody>
				</table>
			</div>

		</div>

	</div>
</div>

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@endpush