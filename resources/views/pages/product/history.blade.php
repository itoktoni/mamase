@extends(Template::master())

@section('title')
<h4>Data Riwayat Perawatan {{ $model->field_name ?? '' }}</h4>
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

@include('pages.product.partial')

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h5 class="text-center">
					Riwayat Alat
				</h5>
			</div>

			<div class="col-md-12">
				@if(!empty($model->has_model->field_image))
					<h4 class="image text-center mb-5">
						<img class="img-fluid"  style="width: 300px" src="{{ asset('files/model/'.$model->has_model->field_image) }}" alt="repair">
					</h4>
				@endif

				@if(!empty($worksheets))
				<div class="table-responsive" id="table_data">
					<table class="table table-bordered table-striped table-responsive-stack">
						<thead>
							<tr>
								<th class="text-left">{{ __('Tanggal') }}</th>
								<th class="text-left">{{ __('Tipe') }}</th>
								<th class="text-left">{{ __('Status') }}</th>
								<th class="text-left">{{ __('Dikerjakan Oleh') }}</th>
								<th class="text-left">{{ __('Keterangan Alat') }}</th>
							</tr>
						</thead>
						<tbody>
							@forelse($worksheets->sortBy('work_sheet_reported_at') as $table)
							<tr>
								<td>{{ $table->field_reported_at }}</td>
								<td>{{ $table->has_type->field_name ?? '' }}</td>
								<td>{{ $table->field_status ?? '' }}</td>
								<td>{{ Query::getImplementor($table->field_contract, $table) }}</td>
								<td>

									<ul class="list-group">
										<li class="">
											<b>Kerusakan : </b> {{ $table->field_description ?? '' }}
										</li>
										<li class="">
											<b>Analisa : </b> {{ $table->field_check ?? '' }}
										</li>
										<li class="">
											<b>Tindakan : </b> {{ $table->field_action ?? '' }}
										</li>
										<li class="">
											<b>Hasil : </b> {{ $table->field_result ?? '' }}
										</li>
										<li class="">
											<b>Saran : </b> {{ $table->has_suggestion->field_name ?? '' }}
										</li>
									</ul>
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

@endsection

@push('javascript')

<script>
$('.form-product input').attr('readonly', 'readonly');
</script>

@include(Template::components('form'))
@include(Template::components('date'))
@endpush