<table class="header" style="margin-top: 20px">
	<tr>
		<td colspan="14">
			<h3>
				LAPORAN  DISTRIBUSI BARANG
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
				<th style="width: 10px">NO.</th>
				<th style="width: 200px">Nama_Sparepart</th>
				<th style="width: 15px">Unit</th>
				@foreach ($location as $loc)
				<th class="rotate"><div>{{ $loc }}</div></th>
				@endforeach
				<th style="width: 20px">Total</th>
			</tr>
		</thead>
		<tbody>
			@forelse($sparepart as $category => $data_category)
			<tr>
				<td colspan="{{ 4 + count($location) }}" style="background-color: lightgray">{{ $category }}</td>
			</tr>
			@foreach ($data_category as $item)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $item->sparepart_name }}</td>
				<td>{{ $item->sparepart_unit_code }}</td>
				@foreach ($location as $id => $loc)
				@php
				$qty = $warehouse->where('warehouse_sparepart_id', $item->sparepart_id)
								->where('warehouse_location_id', $id)
								->first()->warehouse_qty ?? '';
				@endphp
				<td>
					{{ $qty }}
				</td>

				@endforeach
				<td>
					@php
				$total = $warehouse->where('warehouse_sparepart_id', $item->sparepart_id)
								->sum('warehouse_qty') ?? '';
				@endphp
				{{ $total }}
				</td>
			</tr>
			@endforeach
			@empty
			@endforelse
		</tbody>
	</table>
</div>

<style>

	.table-responsive tr th{
		font-size: 10px;
	}

	.table-responsive tr td{
		font-size: 10px;
	}

	th.rotate {
		/* Something you can count on */
		height: {{ $count + 200}}px;
		white-space: nowrap;
	}

	th.rotate > div {
		transform:
		/* Magic Numbers */
		translate(0px, {{ $count + 70 ?? 0 }}px)
		/* 45 is really 360 - 45 */
		rotate(-90deg);
		width: 10px;
	}

	.csstransforms th.rotate {
		height: 140px;
		white-space: nowrap;
	}

	@page {
		size: auto;   /* auto is the initial value */
		margin: 0 20px;  /* this affects the margin in the printer settings */
	}
</style>
