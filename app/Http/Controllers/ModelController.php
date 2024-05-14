<?php

namespace App\Http\Controllers;

use App\Dao\Models\Brand;
use App\Dao\Models\Category;
use App\Dao\Models\ProductModel;
use App\Dao\Models\ProductType;
use App\Dao\Models\Unit;
use App\Dao\Repositories\ProductModelRepository;
use App\Http\Requests\ModelRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Template;

class ModelController extends MasterController
{
    public function __construct(ProductModelRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $product_type = ProductType::getOptions();
        $brand = Brand::getOptions();
        $unit = Unit::getOptions();
        $category = Category::getOptions();

        self::$share = [
            'category' => $category,
            'unit' => $unit,
            'brand' => $brand,
            'product_type' => $product_type,
        ];
    }

    public function getCreate()
    {
        // foreach(ProductModel::with(['has_brand'])->get() as $item){
        //     $name = $item->field_name;
        //     if($item->has_brand){
        //         $name = $name.' - '.$item->has_brand->field_name;
        //     }

        //     $update = ProductModel::find($item->field_primary)->update([
        //         ProductModel::field_name() => $name,
        //     ]);
        // }

        // dd(true);

        $this->beforeForm();
        $this->beforeCreate();
        return view(Template::form(SharedData::get('template')))->with($this->share());
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $this->get($code),
        ]));
    }

    public function postCreate(ModelRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, ModelRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
