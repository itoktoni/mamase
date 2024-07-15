@extends(Template::master())

@section('title')
<h4>Penerimaan Sparepart</h4>
@endsection

@section('action')
<div class="button">
	<input class="btn-check-m d-lg-none" type="checkbox">
    <a href="{{ route(SharedData::get('route').'.getCreate') }}" class="btn btn-success">
		{{ __('Create') }}
	</a>
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

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="column-checkbox">
                            <input class="btn-check-d" type="checkbox">
                        </th>
                        <th class="text-left">Kode</th>
                        <th class="text-left">Kategori</th>
                        <th class="text-left">Brand</th>
                        <th class="text-left">Nama Sparepart</th>
                        <th class="text-left">Tgl Permintaan</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Qty</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $table)
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="code[]" value="{{ $table->request_code }}"></td>
                        <td><a href="{{ route('permintaan.getUpdate', ['code' => $table->request_code]) }}">{{ Views::uiiShort($table->request_code) }}</a></td>
                        <td>{{ $table->category_name }}</td>
                        <td>{{ $table->brand_name }}</td>
                        <td>{{ $table->sparepart_name }}</td>
                        <td>{{ $table->request_date }}</td>
                        <td>{{ RequestStatusType::getDescription($table->request_status) }}</td>
                        <td>{{ $table->qty }}</td>

                        <td class="text-center">
                            <a class="badge badge-primary"
                                href="{{ route(SharedData::get('route').'.getReceive', ['code' => $table->request_code, 'id' => $table->sparepart_id]) }}">
                                Terima
                            </a>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>

        @component(Template::components('pagination'), ['data' => $data])
        @endcomponent

    </div>
</div>
@endsection

@push('javascript')
@include(Template::components('table'))
@endpush