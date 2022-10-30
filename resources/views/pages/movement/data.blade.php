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
                <th class="text-center column-sort">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $table)
            <tr>
                <td class="column-checkbox"><input type="checkbox" class="checkbox" name="code[]" value="{{ $table->field_primary }}"></td>
                <td class="">{{ Views::uiiShort($table->field_primary) }}</td>
                <td class="">{{ $table->field_requested_by_name }}</td>
                <td class="">{{ $table->field_product_name }}</td>
                <td class="">{{ $table->field_description }}</td>
                <td class="">{{ $table->field_location_name }}</td>
                <td class="text-center">
                     <btn
                        class="badge badge-{{ $table->field_status == MovementStatus::Approve ? 'success' : ($table->field_status == MovementStatus::Reject ? 'danger' : 'warning') }}">
                        {{ MovementStatus::getDescription($table->field_status) }}</btn>
               </td>
               <td class="text-center column-sort">
                  <div class="dropdown">
                     <a href="#" class="btn btn-sm" data-toggle="dropdown" aria-haspopup="true">
                           <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right">
                           @if($table->field_status == 2)
                           <a class="dropdown-item text-primary" href="{{ route(SharedData::get('route').'.getUpdate', ['code' => $table->field_primary]) }}">Update</a>
                           @else
                           <a class="dropdown-item text-success" href="{{ route(SharedData::get('route').'.getPrint', ['code' => $table->field_primary]) }}">Print</a>
                           @endif
                           <a class="dropdown-item text-danger button-delete" data="{{ $table->field_primary }}" href="{{ route(SharedData::get('route').'.postDelete', ['code' => $table->field_primary]) }}">Delete</a>
                     </div>
                  </div>
               </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
