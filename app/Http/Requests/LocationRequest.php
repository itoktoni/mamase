<?php

namespace App\Http\Requests;

use App\Dao\Models\Location;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LocationRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            // 'location_name' => 'required|min:1',
        ];
    }
}
