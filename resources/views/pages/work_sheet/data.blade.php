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
                <td style="width: 25%;">
                    @if($table->field_ticket_code)
					<a
						href="{{ $table->field_ticket_code ? route(env('TICKET_ROUTE').'.getUpdate', ['code' => $table->field_ticket_code]) : '#' }}">
						<u>
							<b>[ {{ Views::uiiShort($table->field_ticket_code) }} ]</b>
						</u>
                    </a>
                    <br>
					Category : <b>{{ $table->has_ticket->has_category->field_name ?? '' }}</b>
					<br>
					{{ $table->field_description }}
					<br>
                    Priority : <b> {{ $table->has_ticket->field_priority ?? '' }}</b>
                    <br>
                    @else
                    Desc : {{ $table->field_description ?? '' }}
                    @endif
                </td>
                <td class="">
                    <b>[ {{ Views::uiiShort($table->field_primary) }} ]</b>
                    <br>
                    Status : <b>{{ WorkStatus::getDescription($table->field_status) }}</b>
                    <br>
                    Type : {{ $table->field_type_name }}
                    <br>
                    {{ $table->field_reported_at }}
                </td>
				<td class="" style="width: 35%;">

                    Status : <b>{{ TicketContract::getDescription($table->field_contract) }}</b>
                    <br>
                    Alat : <b>{{ $table->field_product_name }}</b>
                    <br>
                    By : {{ Query::getImplementor($table->field_contract, $table) }}
                    <br>
                    @if($table->field_result)
                    <b>Result</b> : {{ $table->field_result }}
                    @endif
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