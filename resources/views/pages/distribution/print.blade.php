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
							Distribusi Sparepart
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
							Alat : {{ $product->field_name ?? '' }} ( {{ $model->field_qty ?? '' }} {{ $product->field_unit ?? 'Unit' }} )
						</strong>
					</td>
					<td colspan='5'>
						<strong>Tgl {{ $model->field_date ?? '' }}</strong>
					</td>
				</tr>

				@endif
				<tr>
					<td colspan="8">
						<p>
							@php
							$sisa = '';
							if(!empty($model->distribution_waste)){
								$sisa = 'Rusak / Sisa : '.$model->distribution_waste;
							}
							@endphp

							{{ $sisa }}
						</p>
						<p>
							<b>Keterangan</b> : {{ $model->field_description ?? '' }}
						</p>
					</td>
				</tr>

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