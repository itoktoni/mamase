@extends(Template::master())

@section('title')
<h4 style="padding-top: 15px">Stok Gudang</h4>
@endsection

@section('action')
<div class="button" style="padding-top: 5px">
	<input class="btn-check-m d-lg-none" type="checkbox">
    @if(auth()->user()->type >= RoleType::Admin)
	<a href="{{ route(SharedData::get('route').'.postDelete') }}" class="btn btn-danger btn-sm button-delete-all">
		{{ __('Delete') }}
    </a>
	<a href="{{ route(SharedData::get('route').'.getCreate') }}" class="btn btn-primary btn-sm">
		{{ __('Create') }}
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

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                        <th class="text-center column-action">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $table)
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="code[]" value="{{ $table->field_primary }}"></td>
                        <td class="">{{ $table->field_sparepart_name }}</td>
                        <td class="">{{ $table->field_location_name }} - {{ $table->field_building_name }}</td>
                        <td class="">{{ $table->field_qty }}</td>
                        <td class="text-center">
                            <a class="badge badge-dark"
                                href="{{ route(SharedData::get('route').'.getHistory', ['sparepart' => $table->warehouse_sparepart_id, 'location' => $table->warehouse_location_id]) }}">
                                History
                            </a>
                            @if(auth()->user()->type >= RoleType::Admin)
                            <a class="badge badge-primary"
                                href="{{ route(SharedData::get('route').'.getStock', ['sparepart' => $table->warehouse_sparepart_id, 'location' => $table->warehouse_location_id]) }}">
                                Update
                            </a>
                            <a class="badge badge-danger button-delete" data="{{ $table->field_primary }}"
                                href="{{ route(SharedData::get('route').'.postDelete', ['code' => $table->field_primary]) }}">
                                Delete
                            </a>
                            @endif
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