<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class LocationCategoryRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'location_category_name' => 'required|min:3',
            'location_category_active' => 'required',
        ];
    }
}
