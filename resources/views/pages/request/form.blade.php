@extends(Template::master())

@section('title')
    <h4>Permintaan Sparepart</h4>
@endsection

@section('action')
    <div class="button">
        @if (empty($model) || $model->field_status != RequestStatusType::Selesai)
        <button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
        @endif
		@if($model)
		<a target="_blank" href="{{ route(SharedData::get('route').'.getPrint', ['code' => $model->field_primary]) }}"
			class="btn btn-danger">Cetak Permintaan</a>
		@endif
    </div>
@endsection

@section('container')

    {!! Template::form_open($model) !!}

    @if (!request()->ajax())
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
                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('request_date') ? 'has-error' : '' }}">
                        <label>{{ __('Tanggal Buat') }}</label>
                        {!! Form::text('request_date', null ?? date('Y-m-d'), [
                            'class' => 'form-control date',
                            'id' => 'request_date',
                            'placeholder' => 'Please fill this input',
                            'required',
                        ]) !!}
                        {!! $errors->first('request_date', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                @if(auth()->user()->type > RoleType::Admin)
                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('request_start_date') ? 'has-error' : '' }}">
                        <label>{{ __('Generate Dari Tgl') }}</label>
                        {!! Form::text('request_start_date', null, [
                            'class' => 'form-control date',
                            'id' => 'request_start_date',
                            'placeholder' => 'Please fill this input',
                            'required',
                        ]) !!}
                        {!! $errors->first('request_start_date', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group {{ $errors->has('request_end_date') ? 'has-error' : '' }}">
                        <label>{{ __('Sampai Tgl') }}</label>
                        {!! Form::text('request_end_date', null, [
                            'class' => 'form-control date',
                            'id' => 'request_end_date',
                            'placeholder' => 'Please fill this input',
                            'required',
                        ]) !!}
                        {!! $errors->first('request_end_date', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                @endif

                <div class="col-md-3">
                    @if ($model)
                        <div class="form-group">
                            <label>Status</label>
                            {{ Form::select('request_status', $status, null, ['class' => 'form-control', 'id' => 'category_active']) }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('request_name') ? 'has-error' : '' }}">
                        <label>{{ __('Permintaan dari user') }}</label>
                        {!! Form::text('request_name', null ?? auth()->user()->name, [
                            'class' => 'form-control',
                            'id' => 'request_name',
                            'placeholder' => 'Please fill this input',
                            'required',
                        ]) !!}
                        {!! $errors->first('request_name', '<p class="help-block">:message</p>') !!}
                    </div>

                    @if(auth()->user()->type > RoleType::Admin)

                        <div class="form-group">
                            <label>Approval</label>
                            {{ Form::select('request_approval_by', $user, null, ['class' => 'form-control', 'id' => 'category_active', 'placeholder' => ' - Silahkan pilih user -']) }}
                        </div>

                        <div class="form-group">
                            <label>Mengetahui</label>
                            {{ Form::select('request_cc_by', $user, null, ['class' => 'form-control', 'id' => 'category_active', 'placeholder' => ' - Silahkan pilih user -']) }}
                        </div>

                    @else
                        <input type="hidden" name="request_approval_by" value="100">
                    @endif
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        {!! Form::textarea('request_description', null, [
                            'class' => 'form-control h-auto',
                            'id' => 'request_description',
                            'placeholder' => 'Please fill this input',
                            'rows' => 5,
                        ]) !!}
                    </div>
                </div>

            </div>

        </div>
    </div>

    {!! Template::form_close() !!}

    @if ($model)


        <div class="card">
            <div class="card-body">
				{!! Template::form_open($model, 'postUpdateProduct') !!}

				<input type="hidden" name="request" value="{{ $model->field_primary }}">

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group {{ $errors->has('sparepart') ? 'has-error' : '' }}">
                            <label>Kebutuhan Sparepart</label>
                            {!! Form::select('sparepart', $sparepart, null, [
                                'class' => 'form-control',
                                'id' => 'sparepart',
                                'placeholder' => '- Pilih work Sparepart -',
                                'required',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group {{ $errors->has('qty') ? 'has-error' : '' }}">
                            <label>{{ __('Qty') }}</label>
                            {!! Form::text('qty', 1, ['class' => 'form-control', 'id' => 'qty', 'placeholder' => 'Qty']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label>{{ __('Keterangan Kebutuhan') }}</label>
                            {!! Form::textarea('description', null, [
                                'class' => 'form-control h-auto',
                                'id' => 'description',
                                'placeholder' => 'Tambahkan keterangan kebutuhan sparepart',
                                'rows' => 1,
                            ]) !!}
                        </div>
                    </div>

                    @if ($model->field_status != RequestStatusType::Selesai)
                    <div class="col-md-1 mt-4">
                        <button type="submit" class="btn btn-success" id="modal-btn-save">{{ __('Tambah') }}</button>
                    </div>
                    @endif
                </div>
				{!! Template::form_close() !!}

                <hr>

				{{-- sparepart dari ticket --}}
                <div class="row">
                    <div class="col-md-12">
                        @if ($worksheet)

						@forelse($worksheet as $work)
							<h6>
							Lembar kerja : <a class="link-url" href="{{ route('lembar_kerja.getUpdate', ['code' => $work->field_primary]) }}">{{ Views::uiiShort($work->field_primary) }}</a>
							</h6>
							<p>
								Peralatan :  <b>{{ $work->has_product->field_name ?? '' }}</b>
								<br>

								@if ($work->field_check)
								<b>Analisa</b> : {{ $work->field_check ?? '' }}
								<br>
								@endif

								@if ($work->field_action)
								<b>Tindak lanjut</b> : {{ $work->field_action ?? '' }}
								@endif
							</p>
                            <div class="table-responsive" id="table_data">
                                <table class="table table-bordered table-striped table-responsive-stack">
                                    <thead>
                                        <tr>
                                            <th class="text-left">{{ __('No.') }}</th>
                                            <th class="text-left">{{ __('Nama Suku Cadang') }}</th>
                                            <th class="text-left">{{ __('Qty') }}</th>
                                            <th class="text-left">{{ __('Dekripsi Penggunaan') }}</th>
                                            <th class="text-center" style="width: 10px">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($work->has_sparepart as $item)
                                            <tr>
                                                <td style="width: 10px">{{ $loop->iteration }}</td>
                                                <td style="width: 35%">{{ $item->field_name }}</td>
                                                <td class="col-md-1 text-left">
                                                    {{ $item->pivot->qty ?? '' }} {{ $item->field_unit_code }}
                                                </td>
                                                <td>{{ $item->pivot->description ?? '' }}</td>
                                                <td class="text-center">
                                                    @if ($model->field_status >= RequestStatusType::Disetujui && (auth()->user()->type >= RoleType::Admin))
                                                    <a class="badge badge-primary"
														data="{{ $work->field_primary }}"
														href="{{ route('lembar_kerja.getUpdate', ['code' => $work->field_primary]) }}">
														Edit
													</a>
                                                    <a class="badge badge-dark"
                                                        data="{{ $work->field_primary }}"
                                                        href="{{ route('penerimaan.getReceive', ['code' => $model->field_primary, 'id' => $item->field_primary]) }}">
                                                        Terima
                                                    </a>

                                                    <a class="badge badge-danger"
                                                        data="{{ $work->field_primary }}"
                                                        href="{{ route(SharedData::get('route').'.getDeleteProduct', ['code' => $model->field_primary, 'id' => $item->field_primary]) }}">
                                                        Delete
                                                    </a>

                                                    <a class="badge badge-secondary"
                                                        data="{{ $work->field_primary }}"
                                                        href="{{ route('distribusi.getCreate', ['code' => $model->field_primary, 'id' => $item->field_primary]) }}">
                                                        Distribusi
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

							<hr>
							@empty
						@endforelse

						@endif
                    </div>
                </div>
				{{-- end sparepart ticket --}}

				<div class="row">
                    <div class="col-md-12">
                        @if ($part->count() > 0)

							<h6>Tambahan Suku cadang</h6>
                            <div class="table-responsive" id="table_data">
                                <table class="table table-bordered table-striped table-responsive-stack">
                                    <thead>
                                        <tr>
                                            <th class="text-left">{{ __('No.') }}</th>
                                            <th class="text-left">{{ __('Nama Suku Cadang') }}</th>
                                            <th class="text-left">{{ __('Qty') }}</th>
                                            <th class="text-left">{{ __('Dekripsi Penggunaan') }}</th>
                                            <th class="text-center"  style="width: 10px">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($part as $item)
                                            <tr>
                                                <td style="width: 10px">{{ $loop->iteration }}</td>
                                                <td style="width: 35%">{{ $item->field_name }}</td>
                                                <td class="col-md-1 text-left">
                                                    {{ $item->pivot->qty ?? '' }} {{ $item->field_unit_code }}
                                                </td>
                                                <td>{{ $item->pivot->description ?? '' }}</td>
                                                <td class="text-center">
                                                    @if ($model->field_status >= RequestStatusType::Disetujui || (auth()->user()->type >= RoleType::Admin))
                                                    <a class="badge badge-dark mt-1"
                                                        data="{{ $item->field_primary }}"
                                                        href="{{ route('penerimaan.getReceive', ['code' => $model->field_primary, 'id' => $item->field_primary]) }}">
                                                        Terima
                                                    </a>
                                                    <a class="badge badge-danger mt-1"
                                                        data="{{ $item->field_primary }}"
                                                        href="{{ route(SharedData::get('route').'.getDeleteProduct', ['code' => $model->field_primary, 'id' => $item->field_primary]) }}">
                                                        Delete
                                                    </a>

                                                    <a class="badge badge-secondary mt-1"
                                                        data="{{ $item->field_primary }}"
                                                        href="{{ route('distribusi.getCreate', ['code' => $model->field_primary, 'id' => $item->field_primary]) }}">
                                                        Distribusi
                                                    </a>
                                                    @endif
                                                </td>
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
    @include(Template::components('date'))
@endpush
