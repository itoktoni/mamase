<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Spk {{ $master->field_primary ?? '' }}</title>

	@component('components.print')
	@endcomponent

</head>

<body>
	<div id='page'>

		<div id="container">
			<table cellpadding="" 5 cellspacing="0" width="100%">
				<tr>
					<td align='left' colspan='8' valign='middle'>
						<h1>
							SURAT PERINTAH KERJA
						</h1>
					</td>
				</tr>
				<tr class="destination">
					<td colspan='8'>
						<strong>Vendor : {{ strtoupper($master->field_vendor_id ?? '' ) ?? '' }}</strong>
					</td>
				</tr>
				<tr class="contact">
					<td colspan='8'>
						<strong>
							No. Spk ({{ strtoupper($master->field_primary) ?? '' }})
						</strong>
						<p>
							Product : {{ strtoupper($master->has_product->field_name) ?? '' }}
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
					<td class="no" colspan="2">
						<strong>Worksheet</strong>
					</td>
					<td class="product" colspan="2">
						<strong>Hasil</strong>
					</td>
					<td class="price" colspan="4">
						<strong>Cek</strong>
					</td>
				</tr>
				{{-- @if($implementor)
                @foreach($implementor as $item) --}}
				<tr class="item">
					<td class="no" colspan="2">
						<p>
							{{ strtoupper($master->field_work_sheet_name) ?? '' }}
						</p>
					</td>
					<td class="product" colspan="2">
						<p>
							{{ $master->field_result ?? '' }}
						</p>
					</td>
					<td class="price" colspan="4">
						<p>
							{{ $master->field_check ?? '' }}
						</p>
					</td>
				</tr>
				{{-- @endforeach
                @endif --}}

			</table>
		</div>
		<br>
		<strong>Dokumen ini akan diserahkan sebagai bukti pemeriksaan dengan status :
			{{ SpkStatus::getDescription($master->field_status) }}</strong>
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