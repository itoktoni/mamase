@extends(Template::master())

@section('title')
    <h4>Penerimaan Barang</h4>
@endsection

@section('action')
    <div class="button">
        <button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
    </div>
@endsection

@section('container')

    {!! Template::form_open($model, 'postReceive') !!}

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
                <div class="col-md-6">

                    <div class="form-group  {{ $errors->has('receive_sparepart_id') ? 'has-error' : '' }}">
                        <label>{{ __('Sparepart') }}</label>
                        {!! Form::text('receive_qty', $sparepart->field_name ?? null, [
                            'class' => 'form-control',
                            'id' => 'receive_qty',
                            'readonly',
                        ]) !!}
                    </div>
                    <input type="hidden" name="receive_sparepart_id" value="{{ $sparepart->sparepart_id }}">
                    <input type="hidden" name="receive_request_code" value="{{ $sparepart->request_code ?? null }}">

                    <div class="form-group  {{ $errors->has('receive_location_id') ? 'has-error' : '' }}">
                        <label>Lokasi</label>
                        {{ Form::select('receive_location_id', $location, null ?? 1000, ['class' => 'form-control', 'id' => 'receive_location_id', 'placeholder' => '- Pilih Location -']) }}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Permintaan Barang') }}</label>
                                {!! Form::number('receive_ask', null ?? $sparepart->qty, [
                                    'readonly',
                                    'class' => 'form-control',
                                    'id' => 'receive_ask',
                                    'placeholder' => 'Qty',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('receive_qty') ? 'has-error' : '' }}">
                                <label>{{ __('Terima Barang') }}</label>
                                {!! Form::number('receive_qty', null, [
                                    'class' => 'form-control',
                                    'id' => 'receive_qty',
                                    'placeholder' => 'Qty',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group {{ $errors->has('receive_name') ? 'has-error' : '' }}">
                        <label>{{ __('Nama Penerima') }}</label>
                        {!! Form::text('receive_name', null ?? auth()->user()->name, [
                            'class' => 'form-control',
                            'id' => 'receive_name',
                            'placeholder' => 'Nama',
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        {!! Form::textarea('receive_description', null, [
                            'class' => 'form-control h-auto',
                            'id' => 'receive_description',
                            'placeholder' => 'Please fill this input',
                            'rows' => 5,
                        ]) !!}
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
                                            <th class="text-center" style="width: 10px">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($request as $item)
                                            <tr>
                                                <td style="width: 10px">{{ $loop->iteration }}</td>
                                                <td style="width: 35%">{{ $item->has_sparepart->field_name ?? '' }}</td>
                                                <td class="col-md-1 text-left">
                                                    {{ $item->field_ask ?? '' }}
                                                </td>
												<td class="col-md-1 text-left">
                                                    {{ $item->field_qty ?? '' }}
                                                </td>
                                                <td>{{ $item->field_description ?? '' }}</td>
                                                <td class="text-center">
                                                    <a class="badge badge-primary" data="{{ $item->field_primary }}"
                                                        href="{{ route(SharedData::get('route') . '.getPrint', ['code' => $item->field_primary]) }}">
                                                        Cetak
                                                    </a>
                                                    <a class="badge badge-danger" data="{{ $item->field_primary }}"
                                                        href="{{ route(SharedData::get('route') . '.getDeleteReceive', ['code' => $item->field_primary]) }}">
                                                        Delete
                                                    </a>
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

    {!! Template::form_close() !!}

@endsection

@push('javascript')
    @include(Template::components('form'))
@endpush
