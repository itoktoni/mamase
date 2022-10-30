<?php

namespace App\Http\Requests;

use App\Dao\Models\Roles;
use App\Dao\Models\SystemRole;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RolesRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $this->merge([
            SystemRole::field_primary() =>  Str::snake($this->system_role_name)
        ]);
    }

    public function validation() : array
    {
        return [
            'system_role_name' => 'required|min:3',
        ];
    }
}
