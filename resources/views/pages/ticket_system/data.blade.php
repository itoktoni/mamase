<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th class="column-checkbox">
					<input class="btn-check-d" type="checkbox">
				</th>
				@foreach($fields as $value)
				<th {{ Template::extractColumn($value) }}>
					@if($value->sort)
					@sortablelink($value->code, __($value->name))
					@else
					{{ __($value->name) }}
					@endif
				</th>
				@endforeach
				<th class="text-center column-action">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@forelse($data as $table)
			<tr>
				<td class="column-checkbox">
					<input type="checkbox" class="checkbox" name="code[]" value="{{ $table->field_primary }}">
				</td>
				<td>
					<b>[ {{ Views::uiiShort($table->field_primary) }} ]</b>
					<br>
					By : <b>{{ $table->field_reported_name }}</b>
					<br>
					{{ $table->field_reported_at }}

				</td>
				<td>
					{{ TicketStatus::getDescription($table->field_status) }}
				</td>
				<td>
					<b>Loc : </b> {{ $table->field_location_name }}
					<br>
					{{ $table->has_location->has_building->field_name ?? '' }}
					<br>
					{{ $table->has_location->has_floor->field_name ?? '' }}
				</td>
				<td>
					Category : <b>{{ $table->field_category_name }}</b>
					<br>
					{{ $table->field_description }}
					<br>
					Priority : <b> {{ $table->field_priority }}</b>
				</td>


				<td class="col-md-2 text-center column-action">
					<a class="badge badge-primary"
						href="{{ route(SharedData::get('route').'.getUpdate', ['code' => $table->field_primary]) }}">
						{{ __('Update') }}
					</a>
					<a class="badge badge-danger button-delete" data="{{ $table->field_primary }}"
						href="{{ route(SharedData::get('route').'.postDelete', ['code' => $table->field_primary]) }}">
						{{ __('Delete') }}
					</a>
				</td>
			</tr>
			@empty
			@endforelse
		</tbody>
	</table>
</div>