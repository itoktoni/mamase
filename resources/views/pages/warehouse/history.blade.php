@extends(Template::master())

@section('title')
<h4>Master Category</h4>
@endsection

@section('action')
<div class="button">
	<a href="{{ url()->previous() }}" class="btn btn-warning">{{ __('Kembali') }}</a>
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

				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label>Sparepart</label>
							{{ Form::select('warehouse_sparepart_id', $sparepart, null, ['class'=> 'form-control', 'id' => 'warehouse_active', 'placeholder' => '- Pilih Sparepart -']) }}
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>{{ __('Qty') }}</label>
							{!! Form::number('warehouse_qty', null, ['class' => 'form-control', 'id' =>
							'warehouse_qty',
							'placeholder' => 'Qty']) !!}
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Location</label>
					{{ Form::select('warehouse_location_id', $location, null, ['class'=> 'form-control', 'id' => 'warehouse_active', 'placeholder' => '- Pilih Location -']) }}
				</div>
			</div>

		</div>

	</div>
</div>

{!! Template::form_close() !!}


@if ($stock)
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				@if ($stock->count() > 0)
					<h6>Kartu Stock</h6>

					<div class="table-responsive" id="table_data">
						<table class="table table-bordered table-striped table-responsive-stack">
							<thead>
								<tr>
									<th class="text-left">{{ __('No.') }}</th>
									<th class="text-left">{{ __('Stok Awal') }}</th>
									<th class="text-left">{{ __('Stock Perubahan') }}</th>
									<th class="text-left">{{ __('Stok Akhir') }}</th>
									<th class="text-left">{{ __('Tanggal Perubahan') }}</th>
									<th class="text-left">{{ __('Deskripsi') }}</th>
								</tr>
							</thead>
							<tbody>
								@forelse($stock as $item)
									<tr>
										<td style="width: 10px">{{ $loop->iteration }}</td>
										<td>{{ $item->field_awal ?? '' }}</td>
										<td>{{ $item->field_perubahan ?? '' }}</td>
										<td>{{ $item->field_akhir ?? '' }}</td>
										<td>{{ $item->field_date ?? '' }}</td>
										<td>{{ $item->field_description ?? '' }}</td>
									</tr>
								@empty
								@endforelse
							</tbody>
						</table>
					</div>

					<hr>
				@endif
			</div>
		</div>
	</div>
</div>
@endif


@endsection

@push('javascript')
@include(Template::components('form'))
@endpush