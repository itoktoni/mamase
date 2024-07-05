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
				<h5 class="text-left">
					{{ $product->product_name ?? '' }}
				</h5>

				<h5 style="margin: 0px auto;">
					<img style="margin-top:10pxmargin-bottom:20px;height:70px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(route('detail', ['code' => $product->product_id]), 'QRCODE')}}"
					alt="barcode" />
				</h5>
				<br>
				<div id="test">
					<a style="padding:10 15px; background:whitesmoke;margin-top:50px;" target="_blank" onclick="Website2APK.printPage()">Print</a>
				</div>

			</div>
		</div>
	</div>
</div>

<style>

body{
	width : 55mm;
}

@page {
  size: 55mm 40mm;
}

</style>
