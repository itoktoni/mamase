<?php

namespace App\Http\Controllers;

use App\Dao\Enums\BooleanType;
use App\Dao\Models\Building;
use App\Dao\Models\Floor;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\User;
use App\Dao\Repositories\LocationRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\LocationRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateLocationService;
use App\Http\Services\UpdateService;
use Barryvdh\DomPDF\Facade\Pdf;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Response;
use Plugins\Template;
use Ramsey\Uuid\Uuid;

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

    public function postUpdate($code, LocationRequest $request, UpdatelocationService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getCheck()
    {
        $this->beforeForm();
        $data = $this->get(request()->get('code'));
        $product = Product::where(Product::field_checked(), BooleanType::Yes)
                ->get();

        return view('pages.location.check')->with($this->share([
            'model' => $data,
            'product' => $product,
        ]));
    }

    public function postCheck($code, LocationRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getPrint($code)
    {
        $location = Location::find($code);
        $data = [
            'item' => $location
        ];

        $pdf = Pdf::loadView(Template::print(SharedData::get('template'), 'print'), $data);
        return $pdf->setPaper(array( 0 , 0 , 155 , 160 ))->stream(Uuid::uuid4()->toString().'.pdf');
    }
}
