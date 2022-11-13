@extends(Template::master())

@section('title')
<h4>Lembar Kerja</h4>
@endsection

@section('action')
<div class="button">
	<input class="btn-check-m d-lg-none" type="checkbox">
	@if(auth()->user()->type >= RoleType::Admin)
	<a href="{{ route(SharedData::get('route').'.postDelete') }}" class="btn btn-danger button-delete-all">
		{{ __('Delete') }}
	</a>
	@endif
	<a href="{{ route(SharedData::get('route').'.getCreate') }}" class="btn btn-success">
		Create
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
				<option value="work_sheet_ticket_code">
					Ticket</option>
				<option value="work_sheet_code">
					Kode</option>
				<option value="work_type_name">
					Type</option>
				<option value="work_sheet_contract">
					Contract</option>
				<option value="work_sheet_implement_by">
					Implementor</option>
				<option value="product_name">
					Nama Produk</option>
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
		@includeIf(Template::form(SharedData::get('template'),'data'))

		@component(Template::components('pagination'), ['data' => $data])
		@endcomponent

	</div>
</div>
@endsection

@push('javascript')
@include(Template::components('table'))
@endpush