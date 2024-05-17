<?php

namespace App\Http\Requests;

use App\Dao\Enums\RequestStatusType;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class RequestRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'request_start_date' => 'required',
            'request_end_date' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $segment = request()->segment(5);
        $merge = [];

        if($segment == 'create'){
            $merge = array_merge($merge, [
                'request_status' => RequestStatusType::Dibuat,
                'request_code' => Uuid::uuid1()->toString(),
            ]);
        }

        $this->merge($merge);
    }
}
