<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Tiket Pengaduan {{ $master->field_primary ?? '' }}</title>

	@component('components.print')
	@endcomponent

</head>

<body>
	<div id='page'>

		@if(env('APP_HEADER'))
		<div class="header-logo" style="margin-top: -50px;margin-bottom:30x">
			<img style="margin-top:1px;width:100%" src="{{ public_path('storage/'.env('APP_HEADER')) }}" alt="">
		</div>
		@endif

		<div id="container">
			<table cellpadding="" 5 cellspacing="0" width="100%">
				<tr>
					<td align='left' colspan='8' valign='middle'>
						<h1 id="headline">
							TIKET PENGADUAN
						</h1>
					</td>
				</tr>
				<tr class="destination">
					<td colspan='8'>
						<strong>Nama Pelapor : {{ $master->field_reported_name ?? strtoupper($master->has_reported->field_name ?? '' ) ?? '' }}</strong>
					</td>
				</tr>
				<tr class="contact">
					<td colspan='8'>
						<strong>
							No. Tiket ({{ strtoupper($master->field_primary) ?? '' }})
						</strong>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<p>
							{{ $master->field_description ?? '' }}
						</p>
					</td>
				</tr>

			</table>
		</div>
		<br>
		<strong>Dokumen ini akan diserahkan sebagai bukti pemeriksaan dengan status :
			{{ TicketStatus::getDescription($master->field_status) }}</strong>
		<br>

		<div id="container" style="margin-top: 20px;width: 60%;">
			<h1 class="row-table" style="text-align:center">
				<table style="text-align: center;">
					<tr>
						<td>Pelapor</td>
						<td>Pengawas</td>
					</tr>
					<tr>
						<td style="padding:50px 0px"></td>
						<td style="padding:50px 0px"></td>
					</tr>
				</table>
			</h1>
		</div>


</body>

</html>