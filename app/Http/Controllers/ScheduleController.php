<?php

namespace App\Http\Controllers;

use App\Dao\Enums\ScheduleEvery;
use App\Dao\Enums\WorkType as EnumsWorkType;
use App\Dao\Models\WorkType;
use App\Dao\Repositories\ScheduleRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\ScheduleRequest;
use App\Http\Services\CreateScheduleService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateScheduleService;
use Barryvdh\DomPDF\Facade as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Response;
use Plugins\Template;

class ScheduleController extends MasterController
{
    public function __construct(ScheduleRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function share($data = [])
    {
        $status = EnumsWorkType::getOptions();
        $type = ScheduleEvery::getOptions();
        $product = Query::getProduct();
        $location = Query::getLocation();

        $view = [
            'status' => $status,
            'location' => $location,
            'product' => $product,
            'every' => $type,
            'model' => false,
        ];

        return self::$share = array_merge($view, $data, self::$share);
    }

    public function postCreate(ScheduleRequest $request, CreateScheduleService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, ScheduleRequest $request, UpdateScheduleService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getPrint()
    {
        $data = $this->get(request()->get('code'), [
            'has_product',
        ]);

        $share = [
            'master' => $data,
        ];

        $pdf = PDF::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }
}
