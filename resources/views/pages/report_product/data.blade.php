<div class="table-responsive" id="table_data">
	<table class="table table-bordered table-striped table-responsive-stack">
		<thead>
			<tr>
				@foreach($fields as $value)
				<th {{ Template::extractColumn($value) }}>
					@if($value->sort)
					@sortablelink($value->code, __($value->name))
					@else
					{{ __($value->name) }}
					@endif
				</th>
				@endforeach
				<th class="text-center column-sort">Action</th>
			</tr>
		</thead>
		<tbody>
			@forelse($data as $table)
			<tr>
				<td><input type="checkbox" class="checkbox" name="code[]" value="{{ $table->field_primary }}"></td>
				<td>{{ $table->field_category_name ?? '' }}</td>
				<td>{{ $table->field_brand_name ?? '' }}</td>
				<td>{{ $table->field_location_name ?? '' }}</td>
				<td>{{ $table->field_name }}</td>
				<td>{{ $table->field_unit_name }}</td>
				<td>{{ $table->field_prod_year }}</td>
				<td>{{ $table->field_buy_date }}</td>
				<td class="text-center">
					<btn class="badge badge-{{ $table->field_status == ProductStatus::Good ? 'success' : 'warning' }}">
						{{ ProductStatus::getDescription($table->field_status) }}</btn>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>