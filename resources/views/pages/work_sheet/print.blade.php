<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Lembar Kerja Perbaikan {{ $master->field_primary ?? '' }}</title>

	@component('components.print')
	@endcomponent

</head>

<body>
	<div id='page'>

		@if(env('APP_HEADER'))
		<div class="header-logo" style="margin-top: -50px;margin-bottom:50x">
			<img style="margin-top:1px;width:100%" src="{{ public_path('files/logo/'.env('APP_HEADER')) }}" alt="">
		</div>
		@endif

		<div id="container">
			<table cellpadding="" 5 cellspacing="0" width="100%">
				<tr>
					<td align='left' colspan='8' valign='middle'>
						<h1 id="headline">
							LEMBAR KERJA
						</h1>
					</td>
				</tr>
				<tr class="destination">
					<td colspan='8'>
						<strong>Nama Pelapor :
							{{ $master->field_reported_name ?? strtoupper($master->has_reported_by->field_name ?? '' ) ?? '' }}</strong>
					</td>
				</tr>
				<tr class="contact">
					<td colspan='8'>
						<strong>
							No. Lembar Kerja ({{ strtoupper($master->field_primary) ?? '' }})
						</strong>
					</td>
				</tr>

				<tr class="header">
					<td class="" colspan="1">
						<strong>Tipe</strong>
					</td>
					<td colspan="1">
						<strong>Status</strong>
					</td>
					<td class="" colspan="1">
						<strong>Kontrak</strong>
					</td>
					<td class="" colspan="2">
						<strong>Pelaksana</strong>
					</td>
					<td class="" colspan="1">
						<strong>Tanggal Laporan</strong>
					</td>
					<td class="" colspan="1">
						<strong>Tanggal Kunjungan</strong>
					</td>
					<td class="" colspan="1">
						<strong>Tanggal Selesai</strong>
					</td>
				</tr>

				<tr class="">
					<td class="no" colspan="1">
						<p>
							{{ strtoupper($master->field_type_name) ?? '' }}
						</p>
					</td>
					<td colspan="1">
						<p>
							{{ $master->field_status ?? '' }}
						</p>
					</td>
					<td colspan="1">
						<p>
							{{ $master->field_contract_name ?? '' }}
						</p>
					</td>
					<td colspan="2">
						<p>
						@if($master->field_contract == KontrakType::Kontrak)
						{{ $master->has_vendor->field_name ?? '' }}
						@else
						{{ Query::getTeknisi(json_decode($master->field_implementor)) ?? '' }}
						@endif
						</p>
					</td>
					<td colspan="1">
						<p>
							{{ $master->work_sheet_created_at ?? '' }}
						</p>
					</td>
					<td colspan="1">
						<p>
							{{ $master->work_sheet_check_at ?? '' }}
						</p>
					</td>
					<td colspan="1">
						<p>
							{{ $master->work_sheet_finished_at ?? '' }}
						</p>
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
						<strong>Permasalahan</strong>
					</td>
					<td colspan='4'>
						<strong>Analisa</strong>
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
							{{ $master->field_check ?? '' }}
						</p>
					</td>
				</tr>

				<tr class="destination">
					<td colspan='4'>
						<strong>Tindakan</strong>
					</td>
					<td colspan='4'>
						<strong>Kesimpulan</strong>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<p>
							{{ $master->field_action ?? '' }}
						</p>
					</td>
					<td colspan="4">
						<p>
							{{ $master->field_result ?? '' }}
						</p>
					</td>
				</tr>

			</table>
		</div>

		@php
		$spareparts = $master->has_sparepart;
		@endphp
		<br>
		@if(!empty($sparepart))
		<div id="container" style="margin-bottom: 10px;">
			<strong>Kebutuhan Suku Cadang : </strong>
			<br>
			<h1 class="row-table" style="text-align:center">
				<table style="text-align: center;">

					<tr class="header">
						<td style="text-align: left;" colspan="2">
							<strong>Nama Suku Cadang</strong>
						</td>
						<td style="text-align: left;" colspan="1">
							<strong>Qty</strong>
						</td>
						<td style="text-align: left;" class="" colspan="6">
							<strong>Deskripsi Penggunaan</strong>
						</td>
					</tr>
					@foreach($spareparts as $sparepart)
					<tr>
						<td style="text-align: left;" colspan="2">
							{{ $sparepart->field_name ?? '' }}
						</td>
						<td style="text-align: left;" colspan="1">
							{{ $sparepart->pivot->qty ?? '' }} {{ $sparepart->field_unit_code }}
						</td>
						<td style="text-align: left;" colspan="6">
							{{ $sparepart->pivot->description ?? '' }}
						</td>
					</tr>
					@endforeach

				</table>
			</h1>
		</div>
		@endif

		<div class="suggestion">
			<span>Saran dan Tindak lanjut :</span>
			<strong>
				<u>{{ $master->has_suggestion->field_name ?? '' }}</u>
			</strong>
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
							<td style="width: 30%;">Pengguna Alat</td>
							<td style="width: 30%;">Teknisi</td>
							<td style="width: 30%;">PIC DIVISI</td>
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
							<td style="text-align: left;">NIP :</td>
							<td style="text-align: left;">NIP :</td>
							<td style="text-align: left;">NIP :</td>
						</tr>
					</table>
				</h1>
			</div>
		</div>

</body>

</html>