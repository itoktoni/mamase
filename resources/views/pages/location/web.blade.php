<body style="position: relative">
	<div style="text-align: center;">
		<div style="margin-top: -10px">.</div>
		<h5 style="text-align: center; margin-top:5px;font-size:20px">
			<span style="position: absolute; left:0px;font-size:15px">.</span>
				{{ $item->field_name ?? '' }}
			<span style="position: absolute; right:0px;font-size:15px">.</span>
		</h5>

		<h5 style="margin-top: -15px;text-align:center">
			<img style="margin-top:0px;margin-bottom:0px;height:80px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(strval($item->field_primary), 'QRCODE')}}"
			alt="barcode" />
		</h5>
	</div>
</body>

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
