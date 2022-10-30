<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ProductRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'product_name' => 'required|min:3',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
        ]);
    }
}
