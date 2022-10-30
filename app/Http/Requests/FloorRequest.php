<?php

namespace App\Http\Requests;

use App\Dao\Models\Floor;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class FloorRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'floor_name' => 'required|min:3',
        ];
    }
}
