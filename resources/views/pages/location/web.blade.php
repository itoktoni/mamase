<div style="text-align: center">
	<div style="margin-top: -10px">.</div>
	<h5 style="text-align: center;margin-top:5px">
		{{ $item->field_name ?? '' }}
	</h5>

	<h5 style="margin-top: -15px;text-align:center">
		<img style="margin-top:0px;margin-bottom:0px;height:60px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(strval($item->field_primary), 'QRCODE')}}"
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
