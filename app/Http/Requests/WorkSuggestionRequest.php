<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class WorkSuggestionRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'work_suggestion_name' => 'required|unique:work_suggestion',
        ];
    }
}
