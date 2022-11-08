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
                <td class="">{{ $table->field_date }}</td>
                <td class="">
                    <b>Type : </b> {{ $table->field_type_name }}
                    <br>
                    <b>Pengguna : </b> {{ $table->field_requested_name }}
                </td>
                <td class="">{{ $table->field_product_name }}</td>
                <td class="">
                    <b>Keterangan : </b> {{ $table->field_description }}
                    <br>
                    <b>Tindakan : </b> {{ $table->field_action }}
                    <br>
                    @if($table->field_type == MovementType::Recall)
                    Lokasi Alat : {{ $table->has_location_old->field_name ?? '' }}
                    @elseif($table->field_type == MovementType::Pindah)
                    Lokasi Alat Lama : {{ $table->has_location_old->field_name ?? '' }}
                    <br>
                    Lokasi Alat Baru : {{ $table->has_location->field_name ?? '' }}
                    @elseif($table->field_type == MovementType::Vendor)
                    Vendor : {{ $table->field_vendor_name }}
                    @elseif($table->field_type == MovementType::Gudangkan)
                    Alat : digudangkan
                    @endif

                </td>
               <td class="text-center column-sort">
                  <div class="dropdown">
                     <a href="#" class="btn btn-sm" data-toggle="dropdown" aria-haspopup="true">
                           <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right">
                           <a class="dropdown-item text-primary" href="{{ route(SharedData::get('route').'.getUpdate', ['code' => $table->field_primary]) }}">Update</a>
                           <a class="dropdown-item text-success" href="{{ route(SharedData::get('route').'.getPrint', ['code' => $table->field_primary]) }}">Print</a>
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
