<?php

namespace App\Http\Requests;

use App\Dao\Enums\RequestStatusType;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Rfc4122\UuidV1;
use Ramsey\Uuid\Uuid;

class ReceiveBulkRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'location' => 'required',
            'item' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $id = UuidV1::uuid4()->toString();
        $data = collect($this->item)->map(function ($item) use($id){
            return array_merge($item,[
                'receive_date' => date('Y-m-d H:i:s'),
                'receive_group' => $id,
                'receive_location_id' => $this->location,
                'receive_name' => $this->name,
            ]);
        });

        $merge = [
            'data' => $data,
            'id' => $id
        ];

        $this->merge($merge);
    }
}
