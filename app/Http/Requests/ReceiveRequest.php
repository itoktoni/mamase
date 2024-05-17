<?php

namespace App\Http\Requests;

use App\Dao\Enums\RequestStatusType;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class ReceiveRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'receive_location_id' => 'required',
            'receive_sparepart_id' => 'required',
            'receive_qty' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $merge = [
            'receive_date' => date('Y-m-d H:i:s')
        ];

        $this->merge($merge);
    }
}
