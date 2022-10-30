<?php

namespace App\Http\Requests;
use App\Dao\Models\WorkSheet;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class WorkSheetRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'work_sheet_name' => 'required',
            'work_sheet_description' => 'required',
            'work_sheet_type_id' => 'required',
        ];
    }
}
