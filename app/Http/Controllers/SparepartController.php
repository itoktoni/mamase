<?php

namespace App\Http\Controllers;

use App\Dao\Models\Brand;
use App\Dao\Models\Category;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\ProductType;
use App\Dao\Models\Unit;
use App\Dao\Repositories\SparepartRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\SparepartRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;

class SparepartController extends MasterController
{
    public function __construct(SparepartRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $location = Location::getOptions();
        $brand = Brand::getOptions();
        $unit = Unit::getOptions();
        $type = ProductType::getOptions();
        $product = Product::getOptions();
        $category = Category::getOptions();

        self::$share = [
            'type' => $type,
            'unit' => $unit,
            'brand' => $brand,
            'location' => $location,
            'category' => $category,
            'product' => $product,
        ];
    }

    public function postCreate(SparepartRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, SparepartRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
