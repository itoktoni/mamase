<?php

namespace App\Http\Controllers;

use App\Dao\Enums\BooleanType;
use App\Dao\Models\Groups;
use App\Dao\Models\Menus;
use App\Dao\Repositories\RoutesRepository;
use App\Http\Requests\RoutesRequest;
use App\Http\Requests\SortRequest;
use App\Http\Services\CreateRoutesService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateRoutesService;
use Plugins\Helper;
use Plugins\Response;

class RoutesController extends MasterController
{
    public function __construct(RoutesRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $status = BooleanType::getOptions();
        $data_groups = Groups::getOptions();
        self::$share = [
            'status' => $status,
            'model' => false,
            'data_groups' => $data_groups,
        ];
    }

    protected function beforeUpdate($code)
    {
        $data = $this->get($code);
        $method = Helper::getMethod($data->field_controller, $code);

        self::$share = array_merge([
            'model' => $data,
            'method' => $method,
            'menu' => new Menus(),
        ], self::$share);
    }

    public function postCreate(RoutesRequest $request, CreateRoutesService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, RoutesRequest $request, UpdateRoutesService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function postSort(SortRequest $request, UpdateRoutesService $service)
    {
        $data = $service->sort($request);
        return Response::redirectBack($data);
    }
}
