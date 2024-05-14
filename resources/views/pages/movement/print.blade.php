<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Movement Check {{ $master->field_primary ?? '' }}</title>

	@component('components.print')
	@endcomponent

</head>

<body>
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
							BERITA ACARA
							@if($master->field_type == MovementType::Recall)
							PENARIKAN PERALATAN (RECALL)
							@elseif($master->field_type == MovementType::Pindah)
							PERPINDAHAN ALAT
							@elseif($master->field_type == MovementType::Vendor)
							PERBAIKAN OLEH VENDOR
							@elseif($master->field_type == MovementType::Gudangkan)
							ALAT DIGUDANGKAN
							@endif
						</h1>
					</td>
				</tr>
				<tr class="destination">
					<td colspan='8'>
						<strong>
							Nama Pengguna :
							{{ $master->field_requested_name ?? strtoupper($master->has_user_by->field_name ?? '' ) ?? '' }}
						</strong>
					</td>
				</tr>
				<tr class="contact">
					<td colspan='8'>
						<strong>
							No. Berita Acara ({{ strtoupper($master->field_primary) ?? '' }})
						</strong>
					</td>
				</tr>

				@if($product = $master->has_product)

				<tr class="destination">
					<td colspan='4'>
						<strong>Alat : {{ $product->field_name ?? '' }}
							({{ $product->field_serial_number ?? '' }})</strong>
					</td>
					<td colspan='4'>
						<strong>Description</strong>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<p>
							Category : {{ $product->has_category->field_name ?? '' }} <br>
							Merek : {{ $product->has_brand->field_name ?? '' }} <br>
							Type : {{ $product->has_type->field_name ?? '' }} <br>
						</p>
					</td>
					<td colspan="4">
						<p>
							{{ $product->field_description }}
						</p>
					</td>
				</tr>

				@endif

				<tr class="destination">
					<td colspan='4'>
						<strong>Keterangan</strong>
					</td>
					<td colspan='4'>
						<strong>Tindakan</strong>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<p>
							{{ $master->field_description ?? '' }}
						</p>
					</td>
					<td colspan="4">
						<p>
							{{ $master->field_action ?? '' }}
						</p>
					</td>
				</tr>

				@if($master->field_type == MovementType::Recall)
				<tr class="location-old">
					<td colspan="8">
						<strong>
							Lokasi Alat : {{ $master->has_location_old->field_name ?? '' }}
						</strong>
					</td>
				</tr>
				@elseif($master->field_type == MovementType::Pindah)
				<tr class="location-old">
					<td colspan="4">
						<strong>
							Lokasi Alat : {{ $master->has_location_old->field_name ?? '' }}
						</strong>
					</td>
					<td colspan="4">
						<strong>
							Lokasi Baru : {{ $master->has_location->field_name ?? '' }}
						</strong>
					</td>
				</tr>
				@elseif($master->field_type == MovementType::Vendor)
				<tr class="location-old">
					<td colspan="8">
						<strong>
							Vendor : {{ $master->has_vendor->field_name }}
						</strong>
					</td>
				</tr>
				@elseif($master->field_type == MovementType::Gudangkan)
				<tr class="location-old">
					<td colspan="8">
						<strong>
							Keterangan Alat akan digudangkan
						</strong>
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
							<td style="width: 50%;">Diserahkan Kembali</td>
						</tr>
						<tr>
							<td style="padding:50px 0px"></td>
							<td style="padding:50px 0px"></td>
							<td style="padding:50px 0px"></td>
						</tr>
						<tr>
							<td style="text-align: left;">Nama :</td>
							<td style="text-align: left;">Nama :</td>
							<td style="text-align: left;">Nama :</td>
						</tr>
						<tr>
							<td style="text-align: left;">Tanggal :</td>
							<td style="text-align: left;">Tanggal :</td>
							<td style="text-align: left;">Tanggal :</td>
						</tr>
					</table>
				</h1>
			</div>
		</div>

</body>

</html>