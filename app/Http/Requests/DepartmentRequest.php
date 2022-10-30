<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'department_name' => 'required',
        ];
    }
}
