@extends(Template::master())

@section('title')
<h4>Master Alat</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
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

@include('pages.product.partial')

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))
@endpush