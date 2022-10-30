<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'category_name' => 'required|min:3',
            'category_active' => 'required',
        ];
    }
}
