@extends(Template::master())

@section('title')
<h4>Data Riwayat Perawatan {{ $model->field_name ?? '' }}</h4>
@endsection

@section('container')

@if(!request()->ajax())
<div class="">
	<div class="header-container container-fluid d-sm-flex justify-content-between">
		@yield('title')
	</div>
</div>
@endif

<div class="card mt-3">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12 mb-3">
				<h5 class="text-center">
					{{ $product->product_name ?? '' }}
				</h5>

				<h5 style="margin: 0px auto;text-align:center">
					<img style="margin-top:10px;height:70px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(route('detail', ['code' => $product->product_id]), 'QRCODE')}}"
					alt="barcode" />
				</h5>

				<div id="test">
					<div>
						content to print
					</div>
					<a href="#test" onclick="print()">Print</a>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
	function printInfo(ele) {
		var openWindow = window.open("", "title", "attributes");
		openWindow.document.write(ele.previousSibling.innerHTML);
		openWindow.document.close();
		openWindow.focus();
		openWindow.print();
		openWindow.close();
	}
</script>

@endsection