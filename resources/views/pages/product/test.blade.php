<div class="card mt-3">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h5 style="text-align: center">
					{{ $product->product_name ?? '' }}
				</h5>

				<h5 style="margin-top: -10px;;text-align:center">
					<img style="margin-top:0pxmargin-bottom:20px;height:70px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(route('detail', ['code' => $product->product_id]), 'QRCODE')}}"
					alt="barcode" />
				</h5>

				<h5 style="text-align:center;:3px;font-size:15px;margin-top:-10px">{{ $product->product_serial_number }}</h5>

			</div>
		</div>
	</div>
</div>

<script>
	Website2APK.printPage();
</script>

<style>

body{
	width : 55mm;
}

@page {
  size: 55mm 40mm;
}

</style>