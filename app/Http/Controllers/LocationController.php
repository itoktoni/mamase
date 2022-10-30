<?php

namespace App\Http\Controllers;

use App\Dao\Enums\BooleanType;
use App\Dao\Models\Building;
use App\Dao\Models\Floor;
use App\Dao\Models\User;
use App\Dao\Repositories\LocationRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\LocationRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;

class LocationController extends MasterController
{
    public function __construct(LocationRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $status = BooleanType::getOptions();
        $building = Building::getOptions();
        $floor = Floor::getOptions();
        $user = User::getOptions();

        self::$share = [
            'status' => $status,
            'user' => $user,
            'floor' => $floor,
            'building' => $building,
        ];
    }

    public function postCreate(LocationRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, LocationRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
