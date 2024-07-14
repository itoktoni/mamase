<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Penerimaan </title>

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

		<div id="container" style="margin-top:20px">

			<div class="surat" style="width: 60%;margin-top:20px;margin-bottom:0px;">
				<div class="judul">
					<table>
						<tr>
							<td>No.</td>
							<td class="koma">:</td>
							<td></td>
						</tr>
						<tr>
							<td>Lampiran</td>
							<td class="koma">:</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Hal</td>
							<td class="koma">:</td>
							<td>Laporan penerimaan Sparepart</td>
						</tr>
					</table>
					<p>
						Kepada Yth
						<br>
						Kepala Bidang Pengadaan
						<br>
						Di tempat
					</p>

				</div>

			</div>

			<table cellpadding="" 5 cellspacing="0" width="100%">
				<thead>
					<th>No.</th>
					<th>Jenis Sparepart/Service</th>
					<th>Satuan</th>
					<th>Volume</th>
					<th>Tgl Terima</th>
					<th>Keterangan</th>
				</thead>

				@if($product = $model)

				@foreach ($model as $category => $data)

				<tr>
					<td colspan="6" style="text-align:center">
						<b>{{ $category ?? '' }}</b>
					</td>
				</tr>

				@foreach ($data as $item)

				<tr class="destination">
					<td style="text-align: center">{{ $loop->iteration }}</td>
					<td>{{ $item->has_sparepart->field_name ?? '' }}</td>
					<td style="text-align: center">{{ $item->has_sparepart->field_unit_code ?? '' }}</td>
					<td style="text-align: center">{{ $item->field_qty ?? '' }}</td>
					<td style="text-align: center">{{ $item->field_date ?? '' }}</td>
					<td style="text-align: center">{{ $item->field_description ?? '' }}</td>
				</tr>

				@endforeach

				@endforeach

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
							<td style="width: 50%;">PPTK</td>
							<td style="width: 50%;">Atasan Langung</td>
							<td style="width: 50%;">Pemohon</td>
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