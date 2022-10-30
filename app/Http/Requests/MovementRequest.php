<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class MovementRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'movement_reason' => 'required|min:3',
            'movement_location_new' => 'required',
        ];
    }
}
