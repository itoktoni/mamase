<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class SupplierRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'supplier_name' => 'required',
            'supplier_email' => 'required|email',
        ];
    }
}