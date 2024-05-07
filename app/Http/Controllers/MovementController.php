<?php

namespace App\Http\Controllers;

use App\Dao\Enums\MovementStatus;
use App\Dao\Enums\MovementType;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Repositories\MovementRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\MovementRequest;
use App\Http\Services\CreateMovementService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateMovementService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
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
        $type = MovementType::getOptions();
        $vendor = Supplier::getOptions();

        $data_product = false;

        if ($product_id = request()->get('product_id')) {
            $data_product = Product::find($product_id);
        }

        self::$share = [
            'status' => $status,
            'type' => $type,
            'data_product' => $data_product,
            'product' => $product,
            'location' => $location,
            'vendor' => $vendor,
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

        $share = [
            'master' => $data,
        ];

        $pdf = PDF::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }
}
