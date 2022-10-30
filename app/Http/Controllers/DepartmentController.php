<?php

namespace App\Http\Controllers;

use App\Dao\Models\User;
use App\Dao\Repositories\DepartmentRepository;
use App\Http\Requests\DepartmentRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Template;

class DepartmentController extends MasterController
{
    public function __construct(DepartmentRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $user = User::getOptions();
        self::$share = [
            'user' => $user,
        ];
    }

    public function postCreate(DepartmentRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, DepartmentRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
