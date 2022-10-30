<?php

namespace App\Http\Controllers;

use App\Dao\Enums\SpkStatus;
use App\Dao\Models\WorkSheet;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Repositories\SpkRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\SpkRequest;
use App\Http\Services\CreateSpkService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Barryvdh\DomPDF\Facade as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Response;
use Plugins\Template;

class SpkController extends MasterController
{
    public function __construct(SpkRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $work_sheet = WorkSheet::getOptions();
        $product = Query::getProduct();
        $status = SpkStatus::getOptions();
        $vendor = Supplier::getOptions();

        $view = [
            'work_sheet' => $work_sheet,
            'product' => $product,
            'product' => Query::getProduct(),
            'status' => $status,
            'vendor' => $vendor,
            'model' => false,
        ];

        return self::$share = array_merge($view, self::$share);
    }

    public function getCreate()
    {
        $this->beforeForm();
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'status' => SpkStatus::getOptions([SpkStatus::Created]),
        ]));
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $this->get($code),
        ]));
    }

    public function postCreate(SpkRequest $request, CreateSpkService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, SpkRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getPdf()
    {
        $data = $this->get(request()->get('code'), [
            'has_work_sheet',
            'has_product',
        ])->first();

        $share = [
            'master' => $data,
        ];

        $pdf = PDF::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }
}
