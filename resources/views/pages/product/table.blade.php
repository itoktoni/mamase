@extends(Template::master())

@section('title')
<h4 style="padding-top: 15px">Master Alat</h4>
@endsection

@section('action')
<div class="button" style="padding-top: 5px">
	<input class="btn-check-m d-lg-none" type="checkbox">
	@if(auth()->user()->type >= RoleType::Admin)
	<button href="{{ route(SharedData::get('route').'.postDelete') }}" class="btn btn-danger btn-sm button-delete-all">
		Delete
	</button>
	<a href="{{ route(SharedData::get('route').'.getCreate') }}" class="btn btn-primary btn-sm">
		Create
	</a>
	<a href="{{ route(SharedData::get('route').'.getExport') }}" class="btn btn-success btn-sm">
		Export
	</a>
	<div style="margin-top: 5px;margin-bottom:5px">
		<form action="{{ route(SharedData::get('route').'.postImport') }}" method="post" enctype="multipart/form-data">
			{{ $errors->first('import_csv') }}
			<input type="file" name="import_csv" class="btn btn-warning btn-sm" style="width:220px;">
			{{ csrf_field() }}
			<button type="submit" class="btn btn-secondary btn-sm">Import</button>
		</form>
	</div>
	@endif
</div>
@endsection

@section('container')

<div class="page-header">
	<div class="header-container container-fluid d-sm-flex justify-content-between">
		@yield('title')
		@yield('action')
	</div>
</div>

<div class="card">
	<div class="card-body">

		{!! Template::form_table() !!}

		<div class="form-group col-md-4">
			<select name="filter" class="form-control">
				<option value="">- {{ __('Search Default Data') }} -</option>
				@foreach($fields as $value)
				<option {{ request()->get('filter') == $value->code ? 'selected' : '' }} value="{{ $value->code }}">
					{{ __(__($value->name)) }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col">
			<div class="input-group">
				<input type="text" name="search" value="{{ request()->get('search') }}" class="form-control"
					placeholder="{{ __('Searching') }} Data">
				<div class="input-group-append">
					<button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
				</div>
			</div>
		</div>

		{!! Template::form_close() !!}

		<div class="" id="table_data">
			<table class="table table-bordered table-striped table-responsive-stack">
				<thead>
					<tr>
						<th class="column-checkbox">
							<input class="btn-check-d" type="checkbox">
						</th>
						@foreach($fields as $value)
						<th {{ Template::extractColumn($value) }}>
							@if($value->sort)
							@sortablelink($value->code, __($value->name))
							@else
							{{ __($value->name) }}
							@endif
						</th>
						@endforeach
						<th class="text-center column-sort">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($data as $table)
					<tr>
						<td><input type="checkbox" class="checkbox" name="code[]" value="{{ $table->field_primary }}">
						</td>
						<td>{{ $table->field_serial_number ?? '' }}</td>
						<td>{{ $table->field_category_name ?? '' }}</td>
						<td>{{ $table->field_name }}</td>
						<td>
							{{ ProductStatus::getDescription($table->field_status) }}
						</td>
						<td class="text-center">
							<div class="dropdown">
								@if(auth()->user()->type >= RoleType::Admin)
								<a href="{{ route(SharedData::get('route').'.getUpdate', ['code' => $table->field_primary]) }}" class="badge badge-primary">
									Edit
								</a>
								<a href="{{ route(SharedData::get('route').'.postDelete', ['code' => $table->field_primary]) }}" data="{{ $table->field_primary }}" class="badge badge-danger">
									Hapus
								</a>
								@else
								<a href="{{ route(SharedData::get('route').'.getHistory', ['code' => $table->field_primary]) }}" class="badge badge-dark">
									Riwayat
								</a>
								<a href="{{ route('print_product', ['code' => $table->field_primary]) }}" data="{{ $table->field_primary }}" class="mt-2 badge badge-secondary">
									Cetak
								</a>
								@endif
							</div>
						</td>
					</tr>
					@empty
					@endforelse
				</tbody>
			</table>
		</div>

		@component(Template::components('pagination'), ['data' => $data])
		@endcomponent

		<div class="inner" id="Intent" style="text-align: center;">

	</div>
</div>
@endsection

@push('javascript')

<script>
	function sendUrlToPrint(url) {
		var beforeUrl = 'intent:';
		var afterUrl = '#Intent;';
		// Intent call with component
		afterUrl += 'component=ru.a402d.rawbtprinter.activity.PrintDownloadActivity;'
		afterUrl += 'package=ru.a402d.rawbtprinter;end;';
		document.location = beforeUrl + encodeURI(url) + afterUrl;
		return false;
	}
	// jQuery: set onclick hook for css class print-file
	$(document).ready(function() {
		$('.print-file').click(function() {
			return sendUrlToPrint($(this).attr('href'));
		});
	});
</script>

<script src="{{ url('assets/js/stacktable.js') }}"></script>
<script>
$('.table').cardtable();
</script>

<style>
.stacktable { width: 100%; }
.st-head-row { padding-top: 1em; }
.st-head-row.st-head-row-main { font-size: 1.5em; padding-top: 0; }
.st-key { width: 35%; text-align: left; padding-right: 1%; }
.st-val { width: 70%; padding-left: 1%; }



/* RESPONSIVE EXAMPLE */

.stacktable.large-only { display: table; }
.stacktable.small-only { display: none; }

@media (max-width: 800px) {
  .stacktable.large-only { display: none; }
  .stacktable.small-only { display: table; }
}

h2 {
  text-align: center;
  padding-top: 10px;
}

table caption {
	padding: .5em 0;
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
</style>

@include(Template::components('table'))
@endpush