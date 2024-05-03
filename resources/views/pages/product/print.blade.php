<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Print Barcode Product</title>

	<style>
	.page-break {
		page-break-after: always;
	}

	@page {
		margin: 0.3;
		padding: 0.3;
		size: 55mm 40mm landscape;
	}

	body {
		font-family: Times New Roman;
		font-size: 33px;
		text-align: center;
	}

	.container {
		text-align: left;
		width: 100%;
	}
	</style>

</head>

<body>
	<div class="container" style="text-align: center;border:1px solid grey;height:50px">
		<h5 style="margin: 0px auto;text-align:center">
			<img style="margin-top:10px;height:70px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG($item->product_serial_number, 'QRCODE')}}"
			alt="barcode" />
		</h5>
	</div>
</body>

</html>