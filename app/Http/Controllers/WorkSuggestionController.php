<?php

namespace App\Http\Controllers;

use App\Dao\Repositories\WorkSuggestionRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\WorkSuggestionRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;

class WorkSuggestionController extends MasterController
{
    public function __construct(WorkSuggestionRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function postCreate(WorkSuggestionRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, WorkSuggestionRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
