<?php

namespace App\Http\Controllers;

use App\Dao\Repositories\TicketTopicRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketTopicRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;

class TicketTopicController extends MasterController
{
    public function __construct(TicketTopicRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function postCreate(TicketTopicRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, TicketTopicRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
