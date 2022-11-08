<?php

namespace App\Http\Controllers;

use App\Dao\Repositories\LocationCategoryRepository;
use App\Http\Requests\CategoryRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;

class LocationCategoryController extends MasterController
{
    public function __construct(LocationCategoryRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function postCreate(LocationCategoryRepository $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, LocationCategoryRepository $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
