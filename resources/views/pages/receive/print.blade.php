<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Penerimaan {{ $model->field_primary ?? '' }}</title>

	@component('components.print')
	@endcomponent

</head>

<body style="margin-right: 30px;">
	<div id='page'>

		@if(env('APP_HEADER'))
		<div class="header-logo" style="margin-top: -50px;margin-bottom:30x">
			<img style="margin-top:1px;width:100%" src="{{ public_path('files/logo/'.env('APP_HEADER')) }}" alt="">
		</div>
		@endif

		<div id="container">
			<table cellpadding="" 5 cellspacing="0" width="100%">
				<tr>
					<td align='left' colspan='8' valign='middle'>
						<h1 id="headline">
							Penerimaan Sparepart
						</h1>
					</td>
				</tr>
				<tr class="destination">
					<td colspan='8'>
						<p>
							<strong>Nama Penerima : {{ strtoupper($model->field_name ?? '' ) ?? '' }}</strong>
						</p>
					</td>
				</tr>
				@if($product = $model->has_sparepart)

				<tr class="destination">
					<td colspan='3'>
						<strong>
							Alat : {{ $product->field_name ?? '' }}
						</strong>
					</td>
					<td colspan='5'>
						<strong>Description</strong>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<p>
							Permintaan : {{ $model->field_ask ?? '' }}
						</p>
					</td>
					<td colspan="5">
						<p>
							Penerimaan : {{ $model->field_qty ?? '' }}
						</p>
					</td>
				</tr>

				@endif
				<tr>
					<td colspan="8">
						<p>
							<b>Keterangan Kerusakan</b> : {{ $model->field_description ?? '' }}
						</p>
					</td>
				</tr>

				@if($sheet = $model->has_worksheet)
				<tr class="header">
					<td class="no" colspan="2">
						<strong>Worksheet</strong>
					</td>
					<td class="product" colspan="6">
						<strong>Tambahan Keterangan</strong>
					</td>
				</tr>

				<tr class="item">
					<td class="no" colspan="2">
						<p style="text-align: left;">
							{{ Views::uiiShort($sheet->field_primary) ?? '' }}
						</p>
					</td>
					<td class="product" colspan="6">
						<p>
							<b>Permasalahan</b> : {{ $sheet->field_description ?? '' }}
							<br>
							<b>Analisa</b> : {{ $sheet->field_check ?? '' }}
							<br>
							<b>Tindakan</b> : {{ $sheet->field_action ?? '' }}
							<br>
							<b>Kesimpulan</b> : {{ $sheet->field_result ?? '' }}
						</p>
					</td>
				</tr>
				@endif


			</table>
		</div>
		<br>
		<div class="ttd" style="width: 100%;text-align:right">

			<strong style="text-align: right;">
				{{ env('APP_LOCATION') }}, {{ date('d M Y') }}
			</strong>

			<div id="container" style="margin-top: 20px;text-align:right;margin-left:200px">
				<h1 class="row-table" style="text-align:center">
					<table style="text-align: center;">
						<tr>
							<td style="width: 50%;">Menyetujui User</td>
							<td style="width: 50%;">Yang Menerima</td>
						</tr>
						<tr>
							<td style="padding:50px 0px"></td>
							<td style="padding:50px 0px"></td>
						</tr>
						<tr>
							<td style="text-align: left;">Nama :</td>
							<td style="text-align: left;">Nama :</td>
						</tr>
						<tr>
							<td style="text-align: left;">Tanggal :</td>
							<td style="text-align: left;">Tanggal :</td>
						</tr>
					</table>
				</h1>
			</div>
		</div>

</body>

</html>