<div style="text-align: center;position: relative;padding:0px 10px;">
	<div style="margin-top: -10px">.</div>
	<h5 style="text-align: center;margin-top:5px">
		<span style="position: absolute; left:0px;font-size:5px">.</span>
		{{ $item->field_name ?? '' }}
		<span style="position: absolute; right:0px;font-size:5px">.</span>
	</h5>

	<h5 style="margin-top: -15px;text-align:center">
		<img style="margin-top:0px;margin-bottom:0px;height:60px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(route('detail', ['code' => $item->field_primary]), 'QRCODE')}}"
		alt="barcode" />
	</h5>

	<h5 style="text-align:center;font-size:15px;margin-top:-15px">{{ $item->product_serial_number }}</h5>

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
