<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Print Barcode Location</title>

	<style>
	.page-break {
		page-break-after: always;
	}

	@page {
		margin: 0;
		padding: 0;
	}

	body {
		font-family: Times New Roman;
		font-size: 33px;
		text-align: center;
	}

	.container {
		text-align: left;
		width: 100%;
		margin-left: 5px;
	}
	</style>

</head>

<body>
	<div class="container" style="text-align: center;">
		<p style="font-size: 5px;margin-top:0px;margin-bottom:0px">.</p>
		<h5 style="margin-top:10px;font-size:25px;margin-bottom:-5px;">
			<span style="position: absolute; left:0px;font-size:5px">.</span>
			<span style="margin-left: 10px;padding-right:10px">{{ $item->location_name }}</span>
			<span style="position: absolute; right:0px;font-size:5px">.</span>
		</h5>
		<h5 style="margin: 0px auto;text-align:center">
			<img style="margin-top:10px;height:80px;" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG(strval($item->location_id), 'QRCODE')}}" alt="barcode" />
		</h5>
		<p style="margin-top:0px;margin-bottom:0px;font-size:5px">.</p>
	</div>
</body>

</html>