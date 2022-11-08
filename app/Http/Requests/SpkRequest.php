<?php

namespace App\Http\Requests;


use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class SpkRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'spk_description' => 'required',
            'spk_vendor_id' => 'required',
        ];
    }
}
