<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class RequestDetailProductRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $this->merge([
            // 'content' => ''
        ]);
    }

    public function validation(): array
    {
        $validation = [
            'sparepart' => 'required',
            'qty' => 'required',
            'description' => 'required',
        ];

        return $validation;
    }
}
