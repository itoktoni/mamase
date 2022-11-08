<?php

namespace App\Http\Requests;

use App\Dao\Models\Brand;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductTechRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'product_tech_name' => 'required|min:3',
        ];
    }
}
