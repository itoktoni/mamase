<?php

namespace App\Http\Controllers;

use App\Dao\Enums\MovementStatus;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Repositories\MovementRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\MovementRequest;
use App\Http\Services\CreateMovementService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateMovementService;
use Barryvdh\DomPDF\Facade as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Response;
use Plugins\Template;

class MovementController extends MasterController
{
    public function __construct(MovementRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $status = MovementStatus::getOptions();
        $product = Query::getProduct();
        $location = Query::getLocation();
        self::$share = [
            'status' => $status,
            'product' => $product,
            'location' => $location,
        ];
    }

    public function staticForm()
    {
        if (true) {
            $text = "readonly disabled";
        }
        return $text;
    }

    public function postCreate(MovementRequest $request, CreateMovementService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, MovementRequest $request, UpdateMovementService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getPrint()
    {
        $data = $this->get(request()->get('code'), [
            'has_user',
            'has_product',
            'has_location',
            'has_location_old',
        ]);

        if ($data->field_status == 1 || $data->field_status == 3) {
            $share = [
                'master' => $data,
            ];

            $pdf = PDF::loadView(Template::print(SharedData::get('template')), $share);
            return $pdf->stream();
        }
        return PDF::loadHTML('<h1>Status Pending</h1>')->stream();
    }
}
