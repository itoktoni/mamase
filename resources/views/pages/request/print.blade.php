<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Lembar Kerja Perbaikan {{ $model->field_primary ?? '' }}</title>

	@component('components.print')
	@endcomponent

	<style>
		.table-no-border {
			border: none;
		}

		.table-no-border td {
			border: none;
		}

		.table-no-border {
			width: 0px !important;
			margin: '0px';
			padding: '0px';
		}

		.koma{
			width: 5px !important;
		}

		body{
			margin-bottom: 0px;
		}
	</style>

</head>

<body>
	<div id='page'>

		@if(env('APP_HEADER'))
		<div class="header-logo" style="margin-top: -50px;margin-bottom:50x">
			<img style="margin-top:1px;width:100%" src="{{ public_path('files/logo/'.env('APP_HEADER')) }}" alt="">
		</div>
		@endif

		<div id="container">

			<div class="surat" style="width: 60%;margin-top:20px;margin-bottom:-20px;">
				<div class="judul">
					<p>Boyolali, {{ \Carbon\Carbon::parse($model->field_date)->format('d M Y') }}</p>
					<table>
						<tr>
							<td>No.</td>
							<td class="koma">:</td>
							<td>{{ $model->field_primary ?? '' }}</td>
						</tr>
						<tr>
							<td>Lampiran</td>
							<td class="koma">:</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Hal</td>
							<td class="koma">:</td>
							<td>Laporan kerusakan alat dan permintaan suku cadang</td>
						</tr>
					</table>
					<p>
						Kepada Yth
						<br>
						Kepala Bidang Penungjang Pelayanan
						<br>
						Di tempat
					</p>

					<p>
						Dengan hormat,
						bersama ini kami menyampaikan laporan bahwa ;
					</p>
				</div>

			</div>

			<ol>
			@if ($worksheet)

			@foreach ($worksheet as $work)

				<li style="margin-top: 10px">
					<table style="padding-right:20px">
						<tr>
							<td>Laporan </td>
							<td class="koma">:</td>
							<td><b>{{ strtoupper($model->field_primary) ?? '' }}</b></td>
						</tr>
						<tr>
							<td>Nama Ruangan </td>
							<td class="koma">:</td>
							<td><b>{{ strtoupper($work->has_location->field_name) ?? '' }}</b></td>
						</tr>
						<tr>
							<td>Nama Alat </td>
							<td class="koma">:</td>
							<td style="width: 70%"><b>{{ strtoupper($work->has_product->field_name) ?? '' }}</b></td>
						</tr>

						@if ($work->field_check)
						<tr>
							<td>Analisa </td>
							<td class="koma">:</td>
							<td><b>{{ $work->field_check ?? '' }}</b></td>
						</tr>
						@endif

						@if ($work->field_action)

						<tr>
							<td>Tindak Lanjut </td>
							<td class="koma">:</td>
							<td><b>{{ $work->field_action ?? '' }}</b></td>
						</tr>
						@endif

						<tr>
							<td>Penggantian Sparepart</td>
							<td class="koma">:</td>
							<td>
								@foreach($work->has_sparepart as $sparepart)
									{{ $loop->iteration }}. {{ $sparepart->field_name ?? '' }}  ( {{ $sparepart->pivot->qty }} {{ $sparepart->sparepart_unit_code }} )
								<br>
								@endforeach
							</td>
						</tr>
					</table>
				</li>

			@endforeach

			@endif

			{{-- sparepart --}}
			@if ($part->count() > 0)

			@foreach ($part as $item)


				<li style="margin-top: 10px">
					<table style="padding-right:20px">
						<tr>
							<td>Keterangan </td>
							<td class="koma">:</td>
							<td>{{ $item->pivot->description ?? '' }}</td>
						</tr>
						<tr>
							<td>Penggantian Sparepart</td>
							<td class="koma">:</td>
							<td style="width: 70%">
								{{ $item->field_name ?? '' }} (  {{ $item->pivot->qty ?? '' }} {{ $item->sparepart_unit_code }} )
							</td>
						</tr>
					</table>
				</li>

			@endforeach

			@endif

			</ol>

		</div>


		<div class="suggestion">
			<p>
				Demikian laporan ini disampaikan.
				<br>
				Atas perhatian dan tindak lanjut yang diberikan kami ucapkan terima kasih
			</p>
		</div>
		<br>

		<div class="ttd" style="width: 100%;text-align:right">

			<div style="margin-top: -40px;text-align:right;width:100%">
				<p style="text-align: right">
					<b>Kepala IPSRS</b>
					<br>
					<br>
					<br>
					<br>
					<br>
					Danang Adi Prabowo, SST
					<br>
					NIP.19780221 200604 1 004
				</p>
			</div>
		</div>

</body>

</html>