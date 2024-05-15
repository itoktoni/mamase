<?php

namespace App\Http\Controllers;

use App\Dao\Models\Location;
use App\Dao\Models\Sparepart;
use App\Dao\Repositories\WarehouseRepository;
use App\Http\Requests\WarehouseRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;
use Plugins\Query;

class WarehouseController extends MasterController
{
    public function __construct(WarehouseRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $sparepart = Sparepart::getOptions();
        $location = Query::getLocation();

        self::$share = [
            'location' => $location,
            'sparepart' => $sparepart,
        ];
    }

    public function postCreate(WarehouseRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, WarehouseRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
