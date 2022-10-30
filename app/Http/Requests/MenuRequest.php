<?php

namespace App\Http\Requests;

use App\Dao\Enums\MenuType;
use App\Dao\Models\Menus;
use App\Dao\Models\Routes;
use App\Dao\Models\SystemMenu;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class MenuRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'system_menu_name' => 'required|unique:system_menu|min:1',
            'system_menu_type' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            SystemMenu::field_primary() =>  $this->{SystemMenu::field_primary()} ?? Str::snake($this->{SystemMenu::field_name()})
        ]);
    }

}
