<table class="header" style="margin-top: 20px">
	<tr>
		<td colspan="14">
			<h3>
				LAPORAN PENGECEKAN ALAT
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

<div class="keterangan" style="margin-bottom: 20px">
	Teknisi : {{ $teknisi->name ?? '' }}
	<br>
	Tanggal : {{ request('start_date') }} - {{ request('end_date') }}
</div>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th style="width: 10px">NO.</th>
				<th style="width: 200px">Kategori</th>
				<th style="width: 15px">Target</th>
				@foreach ($periode as $tgl)
				<th class="rotate"><div>{{ $tgl->format('d') }}</div></th>
				@endforeach
				<th style="width: 20px">Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			@forelse($category as $id => $cat)
				<td>{{ $loop->iteration }}</td>
				<td style="background-color: lightgray">{{ $cat }}</td>
				<td>{{ 100 }}</td>
				@foreach ($periode as $item)
				@php
				$qty = $matrix->where('model_category_id', $id)
					->where('work_sheet_reported_at', $item->format('Y-m-d'))
					->count() ?? 0;
				@endphp
					<td>{{ $qty }}</td>
				@endforeach
				<td>
					@php
					$total = $matrix->where('model_category_id', $id)->count() ?? 0;
					@endphp

					{{ $total }}
				</td>
				</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>