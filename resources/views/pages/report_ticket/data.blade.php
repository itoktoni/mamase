<table class="header">
	<tr>
		<td colspan="14">
			<h3>
				LAPORAN PERMINTAAN PERBAIKAN ALAT KESEHATAN
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
				<th>TOPIK</th>
				<th>TYPE</th>
				<th>NAMA PELAPOR</th>
				<th>NAMA RUANGAN</th>
				<th>NAMA ALAT</th>
				<th>PERMASALAHAN</th>
				<th>TINDAK LANJUT</th>
				<th>WAKTU KUNJUNGAN</th>
				<th>WAKTU SELESAI</th>
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
					{{ $table->has_category->field_name ?? '' }}
				</td>
				<td class="">
					{{ $table->field_work_type_name ?? '' }}
				</td>
				<td class="">
					{{ $table->field_reported_name ?? '' }}
				</td>
				<td class="">
					<b>Loc : </b> {{ $table->has_location->field_name ?? '' }}
					<br>
					{{ $table->has_location->has_building->field_name ?? '' }}
					<br>
					{{ $table->has_location->has_floor->field_name ?? '' }}
				</td>
				<td class="">
					{{ $table->has_product->field_name ?? '' }}
				</td>
				<td class="">
					{{ $table->field_description ?? '' }}
				</td>
				<td class="">
					{{ $table->field_action ?? '' }}
				</td>
				<td class="">
					{{ $table->field_checked_at }}
				</td>
				<td class="">
					{{ $table->field_finished_at }}
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