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
                <td class="">{{ Views::uiiShort($table->field_primary) }}</td>
                <td class="">{{ $table->field_date }}</td>
                <td class="">{{ $table->field_product_name }}</td>
                <td class="">{{ $table->field_vendor_name }}</td>
                <td class="">{{ $table->field_description }}</td>
                <td class="text-center">
                     <btn class="badge badge-{{ $table->field_status == SpkStatus::Approved ? 'success' : ($table->field_status == SpkStatus::Maintained ? 'danger' : 'warning') }}">
                        {{ SpkStatus::getDescription($table->field_status) }}
                    </btn>
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