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
			<img style="margin-top:1px;width:100%"
				src="{{ public_path('storage/'.env('APP_HEADER')) }}" alt="">
		</div>
		@endif

		<div id="container">
			<table cellpadding="" 5 cellspacing="0" width="100%">
				<tr>
					<td align='left' colspan='8' valign='middle'>
						<h1 id="headline">
							BERITA ACARA PEMINDAHAN BARANG
						</h1>
					</td>
				</tr>
				<tr class="contact">
					<td colspan='8'>
						<strong>
							No. ID ({{ strtoupper($master->field_primary) ?? '' }})
						</strong>
						<p>
							Deskripsi : {{ $master->field_description ?? '' }}
						</p>
						<p>
							Alasan : {{ $master->field_reason ?? '' }}
						</p>
					</td>
				</tr>
				<tr class="location-old">
					<td colspan="8">
						<strong>
							Lokasi Lama : {{ $master->has_location_old->field_name ?? '' }}
						</strong>
					</td>
				</tr>
				<tr class="location-new">
					<td colspan="8">
						<strong>
							Lokasi Baru : {{ $master->has_location->field_name ?? '' }}
						</strong>
					</td>
				</tr>

				<tr class="header">
					<td class="no">
						<strong>No.</strong>
					</td>
					<td class="product" colspan="4">
						<strong>Disetujui</strong>
					</td>
					<td class="price" colspan="3">
						<strong>Tanda Tangan</strong>
					</td>
				</tr>
				<tr class="item">
					<td class="no">
						1
					</td>
					<td class="product" colspan="4">
						{{ $master->has_user->field_name ?? '' }}
					</td>
					<td class="price" colspan="3" style="padding: 50px 0;">

					</td>
				</tr>

			</table>
		</div>
		<br>
		<strong>Dokumen ini akan diserahkan sebagai bukti pemeriksaan dengan status :
			{{ MovementStatus::getDescription($master->field_status) }}</strong>
		<br>

</body>

</html>
