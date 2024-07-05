@extends(Template::master())

@section('title')
    <h4>Distribusi Barang</h4>
@endsection

@section('action')
    <div class="button">
        @if (empty($model))
        <button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
        @endif
		@if($model)
		<a target="_blank" href="{{ route(SharedData::get('route').'.getPrint', ['code' => $model->field_primary]) }}"
			class="btn btn-danger">Cetak Distribusi</a>
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

                <div class="col-md-6">

                    <input type="hidden" name="distribution_request_code" value="{{ request()->get('code') ?? null }}">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('distribution_date') ? 'has-error' : '' }}">
                                <label>{{ __('Tanggal Buat') }}</label>
                                {!! Form::text('distribution_date', null ?? date('Y-m-d'), [
                                    'class' => 'form-control date',
                                    'id' => 'distribution_date',
                                    'placeholder' => 'Please fill this input',
                                    'required',
                                ]) !!}
                                {!! $errors->first('distribution_date', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                       <div class="col-md-12">
                            <div class="form-group {{ $errors->has('distribution_name') ? 'has-error' : '' }}">
                                <label>{{ __('Distribusi ke user') }}</label>
                                {!! Form::text('distribution_name', null ?? $name, [
                                    'class' => 'form-control',
                                    'id' => 'distribution_name',
                                    'placeholder' => 'Please fill this input',
                                    'required',
                                ]) !!}
                                {!! $errors->first('distribution_name', '<p class="help-block">:message</p>') !!}
                            </div>
                       </div>
                    </div>

                    <div class="form-group {{ $errors->has('distribution_description') ? 'has-error' : '' }}">
                        <label>{{ __('Description') }}</label>
                        {!! Form::textarea('distribution_description', null, [
                            'class' => 'form-control h-auto',
                            'id' => 'distribution_description',
                            'placeholder' => 'Please fill this input',
                            'rows' => 5,
                        ]) !!}
                        {!! $errors->first('distribution_description', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('distribution_sparepart_id') ? 'has-error' : '' }}">
                                <label>Sparepart</label>
                                {{ Form::select('distribution_sparepart_id', $sparepart, null ?? request()->get('id'), ['class' => 'form-control', 'placeholder' => '- Pilih Sparepart -']) }}
                                {!! $errors->first('distribution_sparepart_id', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('distribution_qty') ? 'has-error' : '' }}">
                                <label>{{ __('Qty') }}</label>
                                {!! Form::number('distribution_qty', null, [
                                    'class' => 'form-control',
                                    'id' => 'distribution_qty',
                                    'placeholder' => 'Qty',
                                    'required',
                                ]) !!}
                                {!! $errors->first('distribution_qty', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('distribution_waste') ? 'has-error' : '' }}">
                                <label>{{ __('Rusak / Sisa') }}</label>
                                {!! Form::number('distribution_waste', null, [
                                    'class' => 'form-control',
                                    'id' => 'distribution_waste',
                                    'placeholder' => 'Qty',
                                    'required',
                                ]) !!}
                                {!! $errors->first('distribution_waste', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                    </div>

                    <div class="form-group {{ $errors->has('distribution_location_from') ? 'has-error' : '' }}">
                        <label>Dari Lokasi</label>
                        {{ Form::select('distribution_location_from', $location, null ?? 1000, ['class' => 'form-control', 'id' => 'category_active', 'placeholder' => '- Pilih lokasi -']) }}
                        {!! $errors->first('distribution_location_from', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('distribution_location_to') ? 'has-error' : '' }}">
                        <label>Ke Lokasi</label>
                        {{ Form::select('distribution_location_to', $location, null, ['class' => 'form-control', 'id' => 'category_active', 'placeholder' => '- Pilih lokasi -']) }}
                        {!! $errors->first('distribution_location_to', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

            </div>

        </div>
    </div>

    {!! Template::form_close() !!}

@endsection

@push('javascript')
    @include(Template::components('form'))
    @include(Template::components('date'))
@endpush
