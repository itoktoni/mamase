<!doctype html>
<html lang="en">

<head>
	@include('layouts.meta')
	@yield('head')

	<!-- App styles -->

	<style>
	@font-face {
		font-family: 'FontAwesome';
		src:url('{{ url('/') }}/fonts/fontawesome-webfont.eot?v=4.7.0');
		src:url('{{ url('/') }}/fonts/fontawesome-webfont.eot?#iefix&v=4.7.0') format('embedded-opentype'),
		url('{{ url('/') }}/fonts/fontawesome-webfont.woff2?v=4.7.0') format('woff2'),
		url('{{ url('/') }}/fonts/fontawesome-webfont.woff?v=4.7.0') format('woff'),
		url('{{ url('/') }}/fonts/fontawesome-webfont.ttf?v=4.7.0') format('truetype'),
		url('{{ url('/') }}/fonts/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular') format('svg');
		font-weight: normal;
		font-style: normal
	}
	</style>

	<link rel="stylesheet" href="{{ url('assets/css/app.min.css') }}" type="text/css">

</head>

<body class="sticky-header sticky-page-header @yield('bodyClass')">

	@include('layouts.header')

	<!-- begin::main -->
	<div id="main" data-turbolinks="true">

		<!-- begin::navigation -->
		<div class="navigation" id="pjax">

			@include('layouts.left')

		</div>
		<!-- end::navigation -->

		<!-- begin::main-content -->
		<div class="main-content">

			@yield('content')

		</div>
		<!-- end::main-content -->

		@include('layouts.modal')

	</div>
	<!-- end::main -->

	@shared
	<!-- Plugin scripts -->
	<script src="{{ url('vendors/bundle.js') }}"></script>

	<!-- App scripts -->
	<script src="{{ url('assets/js/selectize.min.js') }}"></script>
	<script src="{{ url('assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/app.min.js') }}"></script>
	<!-- <script src="{{ url('assets/js/proajax.js') }}"></script> -->

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Pjax-Standalone/0.6.0/pjax-standalone.min.js"></script> -->

	<script>

	// if (Turbolinks.supported) {
	//     Turbolinks.start()
	// } else {
	//     console.warn("browser kamu tidak mendukung Turbolinks")
	// }

	// pjax.connect("pjax");
	</script>

	@stack('footer')

	@include('layouts.alert')

</body>

</html>