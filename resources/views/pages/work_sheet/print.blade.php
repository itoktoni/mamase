<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Lembar Kerja {{ $master->field_primary ?? '' }}</title>

	@component('components.print')
	@endcomponent

</head>

<body>
	<div id='page'>

		@if(env('APP_HEADER'))
		<div class="header-logo" style="margin-top: -50px;margin-bottom:50x">
			<img style="margin-top:1px;width:100%" src="{{ public_path('storage/'.env('APP_HEADER')) }}" alt="">
		</div>
		@endif

		<div id="container">
			<table cellpadding="" 5 cellspacing="0" width="100%">
				<tr>
					<td align='left' colspan='8' valign='middle'>
						<h1 id="headline">
							Lembar Kerja
						</h1>
					</td>
				</tr>
				<tr class="destination">
					<td colspan='8'>
						<strong>Nama Pelapor :
							{{ strtoupper($master->has_reported_by->field_name ?? '' ) ?? '' }}</strong>
					</td>
				</tr>
				<tr class="contact">
					<td colspan='8'>
						<strong>
							No. Lembar Kerja ({{ strtoupper($master->field_primary) ?? '' }})
						</strong>
						<p>
							Subjek : {{ $master->field_name ?? '' }}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<p>
							{{ $master->field_description ?? '' }}
						</p>
					</td>
				</tr>

				<tr class="header">
					<td class="" colspan="2">
						<strong>Tipe</strong>
					</td>
					<td colspan="2">
						<strong>Hasil</strong>
					</td>
					<td class="" colspan="4">
						<strong>Cek</strong>
					</td>
				</tr>

				<tr class="">
					<td class="no" colspan="2">
						<p>
							{{ strtoupper($master->has_work_type->field_name) ?? '' }}
						</p>
					</td>
					<td colspan="2">
						<p>
							{{ $master->field_result ?? '' }}
						</p>
					</td>
					<td class="" colspan="4">
						<p>
							{{ $master->field_check ?? '' }}
						</p>
					</td>
				</tr>

			</table>
		</div>
		<br>
		<strong>Dokumen ini akan diserahkan sebagai bukti pemeriksaan dengan status :
			{{ WorkStatus::getDescription($master->field_status) }}</strong>
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