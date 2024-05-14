<?php

namespace App\Http\Requests;

use App\Dao\Models\Location;
use App\Dao\Models\ProductModel;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ProductRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'product_model_id' => 'required',
        ];
    }

    public function prepareForValidation()
    {
        $name = ProductModel::find($this->product_model_id)->field_name ?? null;

        if($this->product_location_id){

            $location = Location::with('has_building')->find($this->product_location_id);

            if($location->has_building){
                $name = $name.' - ('.$location->field_name.' - '.$location->has_building->field_name.')';
            } else{
                $name = $name.' - ('.$location->field_name.')';
            }

        }

        $this->merge([
            'product_name' =>  $name,
        ]);
    }
}
