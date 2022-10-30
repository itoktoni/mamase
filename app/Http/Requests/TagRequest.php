<?php

namespace App\Http\Requests;

use App\Dao\Models\Tag;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TagRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $this->merge([
            Tag::field_primary() => strtoupper(Str::snake($this->{Tag::field_name()})),
        ]);
    }

    public function validation() : array
    {
        return [
            'tag_name' => 'required|unique:tag|min:3',
        ];
    }
}
