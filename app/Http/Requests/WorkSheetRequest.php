<?php

namespace App\Http\Requests;

use App\Dao\Enums\KontrakType;
use App\Dao\Models\WorkSheet;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class WorkSheetRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $vendor = $implement_by = $implementor = null;
        if ($this->{WorkSheet::field_contract()} == KontrakType::Kontrak) {
            $vendor = $this->work_sheet_vendor_id ?? auth()->user()->vendor;
            $implement_by = null;
        } else {
            $implementor_request = $this->{WorkSheet::field_implementor()} ?? null;
            $implement_by = $implementor_request[0] ?? null;
            $implementor = isset($implementor_request) ? json_encode($implementor_request) : null;
        }

        $this->merge([
            WorkSheet::field_vendor_id() => $vendor,
            WorkSheet::field_implement_by() => $implement_by,
            WorkSheet::field_implementor() => $implementor,
        ]);
    }

    public function validation() : array
    {
        return [
            'work_sheet_name' => 'required',
            'work_sheet_description' => 'required',
            'work_sheet_type_id' => 'required',
        ];
    }
}
