<table class="header">
	<tr>
		<td colspan="14">
			<h3>
				LAPORAN KEGIATAN {{ request()->get('work_sheet_type_id') ? strtoupper(WorkType::getDescription((int)request()->get('work_sheet_type_id'))) : 'MAINTENANCE' }} ALAT KESEHATAN
			</h3>
		</td>
	</tr>
	<tr>
		<td colspan="14">
			<h3>
				INSTALASI PEMELIHARAAN SARANA RUMAH SAKIT
			</h3>
		</td>
	</tr>
	<tr>
		<td>
			<h3>
				RSUD PANDAN ARANG BOYOLALI {{ date('Y') }}
			</h3>
		</td>
	</tr>
</table>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>NO.</th>
				<th>TIKET</th>
				<th>TANGGAL</th>
				<th>NAMA RUANGAN</th>
				<th>TYPE</th>
				<th>NAMA ALAT</th>
				<th>KELUHAN</th>
				<th>ANALISA KERUSAKAN</th>
				<th>TINDAK LANJUT</th>
				<th>BAHAN PENUNJANG</th>
				<th>WAKTU KUNJUNGAN</th>
				<th>WAKTU SELESAI</th>
				<th>JENIS TEKNOLOGI</th>
				<th>KETERANGAN</th>
			</tr>
		</thead>
		<tbody>
			@forelse($data as $table)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ Views::uiiShort($table->field_primary) }}</td>
				<td class="">
					{{ $table->field_reported_at }}
				</td>
				<td class="">
					<b>Loc : </b> {{ $table->field_location_name }}
					<br>
					{{ $table->has_location->has_building->field_name ?? '' }}
					<br>
					{{ $table->has_location->has_floor->field_name ?? '' }}
				</td>
				<td class="">
					{{ $table->field_type_name ?? '' }}
				</td>
				<td class="">
					{{ $table->has_product->field_name ?? '' }}
				</td>
				<td class="">
					{{ $table->field_description ?? '' }}
				</td>
				<td class="">
					{{ $table->field_check ?? '' }}
				</td>
				<td class="">
					{{ $table->field_action ?? '' }}
				</td>
				<td class="">
					@php
					$sparepart = $table->has_sparepart ?? false;
					@endphp
					@foreach($sparepart as $part)
					({{ $part->pivot->qty ?? '' }}) {{ $part->field_name ?? '' }}
					<br>
					Desc : {{ $part->pivot->description ?? '' }}
					<br>
					@endforeach
				</td>
				<td class="">
					{{ $table->field_check_at ?? '' }}
				</td>
				<td class="">
					{{ $table->field_finished_at ?? '' }}
				</td>
				<td class="">
					{{ $table->has_product->has_tech->field_name ?? '' }}
				</td>
				<td class="">
					{{ $table->field_result }}
				</td>

			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>