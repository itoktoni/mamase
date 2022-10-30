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
	}

	body {
		font-family: Times New Roman;
		font-size: 33px;
		text-align: center;
	}

	.container {
		text-align: left;
	}
	</style>

</head>

<body>
	@foreach($data as $item)
	<div class="container">
		<img style="float: left;margin-top:30px;margin-left:20px" src="data:image/png;base64,{{BARCODE2D::getBarcodePNG($item->product_serial_number, 'QRCODE')}}"
			alt="barcode" />
		<h5 style="float: left;font-size:25px;margin-left:10px">{{ $item->product_serial_number }}</h5>
		<div class="page-break"></div>
	</div>
	@endforeach
</body>

</html>