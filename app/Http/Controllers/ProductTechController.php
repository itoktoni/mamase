<?php

namespace App\Http\Controllers;

use App\Dao\Repositories\ProductTechRepository;
use App\Dao\Repositories\ProductTypeRepository;
use App\Http\Requests\ProductTechRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;

class ProductTechController extends MasterController
{
    public function __construct(ProductTechRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function postCreate(ProductTechRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, ProductTechRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
