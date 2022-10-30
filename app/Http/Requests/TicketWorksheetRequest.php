<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class TicketWorksheetRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $this->merge([
            // 'content' => ''
        ]);
    }

    public function validation(): array
    {
        $validation = [
            'contract' => 'required',
            'name' => 'required',
        ];

        return $validation;
    }
}
