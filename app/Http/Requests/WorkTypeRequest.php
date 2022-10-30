<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class WorkTypeRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'work_type_name' => 'required|unique:work_type',
        ];
    }
}
