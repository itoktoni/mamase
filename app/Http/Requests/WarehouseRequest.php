<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'warehouse_sparepart_id' => 'required',
            'warehouse_location_id' => 'required',
            'warehouse_qty' => 'required|integer',
        ];
    }
}
