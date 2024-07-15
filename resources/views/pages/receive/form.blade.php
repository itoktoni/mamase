@extends(Template::master())

@section('title')
<h4>Penerimaan Sparepart</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
	@if(request()->has('code'))
	<a target="_blank" href="{{ route(SharedData::get('route').'.getPrintBulk', ['code' => request()->get('code')]) }}"
		class="btn btn-danger">Cetak Penerimaan</a>
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
				<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
					<label>{{ __('Nama Penerima') }}</label>
					{!! Form::text('name', null ?? Auth::user()->name, ['class' => 'form-control', 'id' => 'name',
					'placeholder'
					=> 'Please fill this input', 'required']) !!}
					{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
					<label>Lokasi</label>
					{{ Form::select('location', $location, null ?? 1000, ['class'=> 'form-control']) }}
					{!! $errors->first('location', '<p class="help-block">:message</p>') !!}

				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group {{ $errors->has('tanggal') ? 'has-error' : '' }}">
					<label>{{ __('Tanggal Terima') }}</label>
					{!! Form::text('tanggal', null ?? date('Y-m-d'), ['class' => 'form-control date', 'id' => 'tanggal',
					'required']) !!}
					{!! $errors->first('tanggal', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

		</div>

	</div>
</div>


@if ($request)
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				@if ($request->count() > 0)
					<h6>List Penerimaan</h6>

					<div class="table-responsive" id="table_data">
						<table class="table table-bordered table-striped table-responsive-stack">
							<thead>
								<tr>
									<th class="text-left">{{ __('No.') }}</th>
									<th class="text-left">{{ __('Nama Suku Cadang') }}</th>
									<th class="text-left">{{ __('Permintaan') }}</th>
									<th class="text-left">{{ __('Penerimaan') }}</th>
									<th class="text-left">{{ __('Dekripsi Penggunaan') }}</th>
								</tr>
							</thead>
							<tbody>
								@forelse($request as $req)
									@foreach ($req->has_part as $item)
									<tr>
										<td style="width: 10px">{{ $loop->iteration }}</td>
										<td style="width: 35%">{{ $item->field_name ?? '' }}</td>
										<td class="col-md-1 text-center">
											{{ $item->pivot->qty ?? '' }}
										</td>
										<td class="col-md-1 text-left">
											<input type="hidden" name="item[{{ $loop->iteration }}][receive_sparepart_id]" value="{{ $item->sparepart_id ?? '' }}">
											<input type="hidden" name="item[{{ $loop->iteration }}][receive_ask]" value="{{ $item->pivot->qty ?? '' }}">
											<input type="hidden" name="item[{{ $loop->iteration }}][receive_request_code]" value="{{ $item->pivot->request_code ?? '' }}">
											<input type="text" class="form-control text-center" name="item[{{ $loop->iteration }}][receive_qty]" id="">
										</td>
										<td>
											<input type="text" class="form-control" name="item[{{ $loop->iteration }}][receive_description]" id="">
										</td>
									</tr>
									@endforeach($request as $item)
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


{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))
@endpush