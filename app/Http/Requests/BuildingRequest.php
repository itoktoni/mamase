<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'building_name' => 'required|min:3',
        ];
    }
}
