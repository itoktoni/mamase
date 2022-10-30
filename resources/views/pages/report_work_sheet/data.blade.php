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
                <td class="column-checkbox"><input type="checkbox" class="checkbox" name="code[]" value="{{ $table->field_primary }}"></td>
                <td class="text-primary"><a href="{{ $table->field_ticket_code ? route('ticket_system.getUpdate', ['code' => $table->field_ticket_code]) : '#' }}"><u>{{ Views::uiiShort($table->field_ticket_code) }}</u></a></td>
                <td class="">{{ Views::uiiShort($table->field_primary) }}</td>
                <td class="">{{ $table->field_type_name }}</td>
                <td class="">{{ $table->field_name }}</td>
                <td class="">{{ $table->field_product_name }}</td>
                <!-- <td class="">{{ $table->field_ticket_code }}</td> -->
                <!-- <td class="">{{ $table->field_description }}</td> -->
                <td class="col-md-2 text-center column-action">
                    <a class="badge badge-primary"
                        href="{{ route(SharedData::get('route').'.getUpdate', ['code' => $table->field_primary]) }}">
                        Update
                    </a>
                    <a class="badge badge-danger button-delete" data="{{ $table->field_primary }}"
                        href="{{ route(SharedData::get('route').'.postDelete', ['code' => $table->field_primary]) }}">
                        Delete
                    </a>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
