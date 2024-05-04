@extends(Template::master())

@section('title')
<h4>Master Alat</h4>
@endsection

@section('action')
<div class="button">
	<button type="submit" class="btn btn-primary" id="modal-btn-save">{{ __('Save') }}</button>
	@if($model->product_id)
	<a class="btn btn-primary" href="rawbt:data:image/png;base64,{{BARCODE2D::getBarcodePNG($model->product_serial_number, 'QRCODE')}}"> picture </a>
	<a class="btn btn-info" href="rawbt:base64,PGJvZHk+DQoJPGRpdiBjbGFzcz0iY29udGFpbmVyIiBzdHlsZT0idGV4dC1hbGlnbjogY2VudGVyOyI+DQoJCTxoNSBzdHlsZT0ibWFyZ2luLXRvcDoxMHB4O2ZvbnQtc2l6ZToxNXB4O21hcmdpbi1ib3R0b206LTVweDsiPkFORVNUSEVTSSBVTklUPC9oNT4NCgkJPGg1IHN0eWxlPSJtYXJnaW46IDBweCBhdXRvO3RleHQtYWxpZ246Y2VudGVyIj4NCgkJCTxpbWcgc3R5bGU9Im1hcmdpbi10b3A6MTBweDtoZWlnaHQ6NzBweCIgc3JjPSJkYXRhOmltYWdlL3BuZztiYXNlNjQsaVZCT1J3MEtHZ29BQUFBTlNVaEVVZ0FBQUQ4QUFBQS9BUU1BQUFCdGtZS2NBQUFBQmxCTVZFWC8vLzhBQUFCVnd0TitBQUFBQVhSU1RsTUFRT2JZWmdBQUFBbHdTRmx6QUFBT3hBQUFEc1FCbFNzT0d3QUFBS2RKUkVGVUtKRjEwREVPd3lBTUJWQkxETjA0QVZLdXdaWXJoUXMwbk1DNVVqZXVnY1FGeXBZQnhmMXAwNkhnV2d4dnNENjJTV1EzUE10Qkl6SjVzbmdLeXVGTDlNSTYwUE1QN3E0RHlkUHorcUlENWluZndUcWdTcVJQZFpCTnlyYWJxTUR3cllYa1NFRWpMMVVtVm1EcXc2MEo0U1BhNGxzUXd3cFFtV1phRkdDTGpFdXlBdXplMEdNVjRHTE4rc0k2cHBxUXJFTHFPM3dBa3ZONjdqN2luQ2ZJTmRnUFhwZnNDQnhjWEhvL0FBQUFBRWxGVGtTdVFtQ0MiDQoJCQlhbHQ9ImJhcmNvZGUiIC8+DQoJCTwvaDU+DQoJCTxoNSBzdHlsZT0ibWFyZ2luLXRvcDozcHg7Zm9udC1zaXplOjE1cHg7bWFyZ2luLWJvdHRvbTowcHgiPjAxNzExMzA3MDAxNjwvaDU+DQoJCTxzcGFuIHN0eWxlPSJmb250LXNpemU6IDEwcHg7bWFyZ2luLWJvdHRvbjowcHg7cG9zaXRpb246YWJzb2x1dGU7Ym90dG9tOjVweDsiPi48L3NwYW4+DQoJPC9kaXY+DQo8L2JvZHk+"> 64 </a>
	<a class="btn btn-warning" href="rawbt:data:text/html;base64,PGJvZHk+DQoJPGRpdiBjbGFzcz0iY29udGFpbmVyIiBzdHlsZT0idGV4dC1hbGlnbjogY2VudGVyOyI+DQoJCTxoNSBzdHlsZT0ibWFyZ2luLXRvcDoxMHB4O2ZvbnQtc2l6ZToxNXB4O21hcmdpbi1ib3R0b206LTVweDsiPkFORVNUSEVTSSBVTklUPC9oNT4NCgkJPGg1IHN0eWxlPSJtYXJnaW46IDBweCBhdXRvO3RleHQtYWxpZ246Y2VudGVyIj4NCgkJCTxpbWcgc3R5bGU9Im1hcmdpbi10b3A6MTBweDtoZWlnaHQ6NzBweCIgc3JjPSJkYXRhOmltYWdlL3BuZztiYXNlNjQsaVZCT1J3MEtHZ29BQUFBTlNVaEVVZ0FBQUQ4QUFBQS9BUU1BQUFCdGtZS2NBQUFBQmxCTVZFWC8vLzhBQUFCVnd0TitBQUFBQVhSU1RsTUFRT2JZWmdBQUFBbHdTRmx6QUFBT3hBQUFEc1FCbFNzT0d3QUFBS2RKUkVGVUtKRjEwREVPd3lBTUJWQkxETjA0QVZLdXdaWXJoUXMwbk1DNVVqZXVnY1FGeXBZQnhmMXAwNkhnV2d4dnNENjJTV1EzUE10Qkl6SjVzbmdLeXVGTDlNSTYwUE1QN3E0RHlkUHorcUlENWluZndUcWdTcVJQZFpCTnlyYWJxTUR3cllYa1NFRWpMMVVtVm1EcXc2MEo0U1BhNGxzUXd3cFFtV1phRkdDTGpFdXlBdXplMEdNVjRHTE4rc0k2cHBxUXJFTHFPM3dBa3ZONjdqN2luQ2ZJTmRnUFhwZnNDQnhjWEhvL0FBQUFBRWxGVGtTdVFtQ0MiDQoJCQlhbHQ9ImJhcmNvZGUiIC8+DQoJCTwvaDU+DQoJCTxoNSBzdHlsZT0ibWFyZ2luLXRvcDozcHg7Zm9udC1zaXplOjE1cHg7bWFyZ2luLWJvdHRvbTowcHgiPjAxNzExMzA3MDAxNjwvaDU+DQoJCTxzcGFuIHN0eWxlPSJmb250LXNpemU6IDEwcHg7bWFyZ2luLWJvdHRvbjowcHg7cG9zaXRpb246YWJzb2x1dGU7Ym90dG9tOjVweDsiPi48L3NwYW4+DQoJPC9kaXY+DQo8L2JvZHk+"> Content </a>
	<a href="{{ route('product.getPrint', ['code' => $model->product_id]) }}" class="print-file btn btn-danger">.pdf</a>

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

<div class="inner" id="Intent" style="text-align: center;">
	<h5 style="margin-top:10px;font-size:15px;margin-bottom:-5px;">{{ $model->product_name }}</h5>
	<h5 style="margin: 0px auto;text-align:center">
		<img style="margin-top:10px;height:70px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG($model->product_serial_number, 'QRCODE')}}"
		alt="barcode" />
	</h5>
	<h5 style="margin-top:3px;font-size:15px;margin-bottom:0px">{{ $model->product_serial_number }}</h5>
	<span style="font-size: 10px;margin-botton:0px;position:absolute;bottom:5px;">.</span>
</div>

<div class="inner" id="extend" style="text-align: center;">
	<h5 style="margin-top:10px;font-size:15px;margin-bottom:-5px;">{{ $model->product_name }}</h5>
	<h5 style="margin: 0px auto;text-align:center">
		<img style="margin-top:10px;height:70px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG($model->product_serial_number, 'QRCODE')}}"
		alt="barcode" />
	</h5>
	<h5 style="margin-top:3px;font-size:15px;margin-bottom:0px">{{ $model->product_serial_number }}</h5>
	<span style="font-size: 10px;margin-botton:0px;position:absolute;bottom:5px;">.</span>
</div>

@include('pages.product.partial')

{!! Template::form_close() !!}

@endsection

@push('javascript')
@include(Template::components('form'))
@include(Template::components('date'))

<script>
	// for php demo call
	function sendUrlToPrint(url){
		alert('masuk');
		var  beforeUrl = 'intent:';
		var  afterUrl = '#Intent;';
		// Intent call with component
		afterUrl += 'component=ru.a402d.rawbtprinter.activity.PrintDownloadActivity;'
		afterUrl += 'package=ru.a402d.rawbtprinter;end;';
		document.location=beforeUrl+encodeURI(url)+afterUrl;
		return false;
	}

	function BtPrint(prn){
		alert('juga');
			var S = "#Intent;scheme=rawbt;";
			var P =  "package=ru.a402d.rawbtprinter;end;";
			var textEncoded = encodeURI(prn);
			window.location.href="intent:"+textEncoded+S+P;
	}

    $(document).ready(function(e){
        $('.print-file').click(function (e) {
			e.preventDefault();
            return sendUrlToPrint($(this).attr('href'));
        });
    });

</script>

@endpush