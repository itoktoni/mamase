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
            'movement_requested_name' => 'required|min:3',
            'movement_action' => 'required|min:3',
            'movement_description' => 'required|min:3',
        ];
    }
}
