<?php

namespace App\Http\Requests;

use App\Dao\Models\Brand;
use App\Dao\Models\ProductModel;
use App\Dao\Models\ProductType;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'model_group' => 'required|min:3',
            'model_name' => 'unique:product_models,model_name',
        ];
    }

    public function prepareForValidation()
    {
        $action = request()->segment(5);

        $merge = [];

        if ($this->has('file_picture')) {
            $file_logo = $this->file('file_picture');
            $extension = $file_logo->getClientOriginalExtension();
            $name = time() . '.' . $extension;
            $file_logo->storeAs('model/', $name);
            $merge = array_merge($merge, [
                'model_image' => $name
            ]);
        }

        $type_name = $brand_name = null;
        $name = $this->{ProductModel::field_group()};

        if($type = $this->model_type_id){
            $type_name = ProductType::find($type)->field_name ?? null;
            $name = $name.' - '.$type_name;
        }

        if($brand = $this->model_brand_id){
            $brand_name = Brand::find($brand)->field_name;
            $name = $name.' - '.$brand_name;
        }

        if($action == 'create'){
            $merge = array_merge($merge, [
                ProductModel::field_name() =>  $name,
            ]);
        }

        $merge = array_merge($merge, [
            'model_name' =>  $name,
        ]);

        $this->merge($merge);
    }
}
