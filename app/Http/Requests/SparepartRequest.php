<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class SparepartRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'sparepart_name' => 'required|min:3',
        ];
    }
}
