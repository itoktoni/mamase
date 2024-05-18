<?php

namespace App\Http\Requests;

use App\Dao\Enums\RequestStatusType;
use App\Dao\Models\Warehouse;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class DistributionRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'distribution_name' => 'required',
            'distribution_description' => 'required',
            'distribution_location_from' => 'required',
            'distribution_location_to' => 'required',
            'distribution_sparepart_id' => 'required',
            'distribution_qty' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $from = Warehouse::where(Warehouse::field_location_id(), $this->distribution_location_from)
                ->where(Warehouse::field_sparepart_id(), $this->distribution_sparepart_id)
                ->first();

        $qty = $pengurangan = 0;
        if($from){
            $qty = $from->field_qty;
            $pengurangan = $from->field_qty - $this->distribution_qty;
        }

        $validator->after(function ($validator) use ($pengurangan) {
            if($pengurangan <= 0){
                $validator->errors()->add('distribution_qty', 'Qty tidak cukup !');
            }
        });
    }

    public function prepareForValidation()
    {
        $merge = [
            'distribution_date' => $this->distribution_date.' '.date('H:i:s') ?? date('Y-m-d H:i:s'),
        ];

        $this->merge($merge);
    }
}
