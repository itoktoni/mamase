<table class="header">
	<tr>
		<td colspan="10">
			<h3>
				MONITORING ALAT KESEHATAN
			</h3>
		</td>
	</tr>
	<tr>
		<td colspan="10">
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

<div class="table-responsive" id="table_data">
	<table border="1" style="border-collapse: collapse;"
		class="table table-bordered table-striped table-responsive-stack">
		<thead>
			<tr>
				<th>NO.</th>
				<th style="width: 150px;">CEK TERAKHIR</th>
				<th>NAMA ALAT</th>
				<th>MERK</th>
				<th>TIPE</th>
				<th>NO. SERI</th>
				<th>NAMA RUANG</th>
				<th>FISIK</th>
				<th>FUNGSI</th>
				<th>KETERANGAN</th>
			</tr>
		</thead>
		<tbody>
			@forelse($data as $table)
			<tr>
				@php
				$sheet = $table->has_worksheet->first() ?? false;
				@endphp
				<td>{{ $loop->iteration }}</td>
				<td>{{ $sheet->field_reported_at ?? '' }}</td>
				<td>{{ $table->field_name }}</td>
				<td>{{ $table->field_brand_name ?? '' }}</td>
				<td>{{ $table->field_type_name ?? '' }}</td>
				<td align="left">{{ $table->field_serial_number ?? '' }}</td>
				<td>{{ $table->field_location_name ?? '' }}</td>

				<td>
					{{ $sheet->field_product_fisik ?? '' }}
				</td>
				<td>
					{{ $sheet->field_product_fungsi ?? '' }}
				</td>
				<td>
					{{ $sheet->field_product_description ?? '' }}
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>