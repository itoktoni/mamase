@extends(Template::master())

@section('title')
<h4>Master Alat</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
	@if($model->product_id)
	<button onclick="ajax_print({{ route('product.getPrint', ['code' => $model->product_id]) }},this)">Test</button>
	<a href="{{ route('product.getPrint', ['code' => $model->product_id ?? '']) }}" class="btn btn-danger" id="modal-btn-save">{{ __('Print') }}</a>
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

@include('pages.product.partial')

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))

<script>
	// for php demo call
	function ajax_print(url, btn) {
		b = $(btn);
		b.attr('data-old', b.text());
		b.text('wait');
		$.get(url, function (data) {
			window.location.href = data;  // main action
		}).fail(function () {
			alert("ajax error");
		}).always(function () {
			b.text(b.attr('data-old'));
		})
	}
</script>

@endpush