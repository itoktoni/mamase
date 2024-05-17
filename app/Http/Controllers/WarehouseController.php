<?php

namespace App\Http\Controllers;

use App\Dao\Models\Location;
use App\Dao\Models\Sparepart;
use App\Dao\Models\Stock;
use App\Dao\Models\Warehouse;
use App\Dao\Repositories\WarehouseRepository;
use App\Http\Requests\WarehouseRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Template;

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

    public function getHistory($sparepart, $location)
    {
        $this->beforeForm();
        $this->beforeUpdate($sparepart);

        $stock = Stock::with(['has_location', 'has_sparepart'])
            ->where(Stock::field_sparepart_id(), $sparepart)
            ->where(Stock::field_location_id(), $location)
            ->get();

        return view(Template::form(SharedData::get('template'), 'history'))->with($this->share([
            'model' => $this->get($sparepart),
            'stock' => $stock
        ]));
    }

    public function postCreate(WarehouseRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);

        Stock::create([
            Stock::field_awal() => 0,
            Stock::field_perubahan() => $request->warehouse_qty,
            Stock::field_akhir() => $request->warehouse_qty,
            Stock::field_location_id() => $request->warehouse_location_id,
            Stock::field_sparepart_id() => $request->warehouse_sparepart_id,
            Stock::field_date() => date('Y-m-d H:i:s'),
            Stock::field_description() => "Qty dari Pembuatan Gudang",
        ]);

        return Response::redirectBack($data);
    }

    public function postUpdate($code, WarehouseRequest $request, UpdateService $service)
    {
        $warehouse = Warehouse::where(Warehouse::field_sparepart_id(), $request->warehouse_sparepart_id)
            ->where(Warehouse::field_location_id(), $request->warehouse_location_id)->first();

        $awal = 0;
        if ($warehouse) {
            $awal = $warehouse->field_qty ?? 0;
        }

        Stock::create([
            Stock::field_awal() => $awal,
            Stock::field_perubahan() => $request->warehouse_qty,
            Stock::field_akhir() => $request->warehouse_qty,
            Stock::field_location_id() => $request->warehouse_location_id,
            Stock::field_sparepart_id() => $request->warehouse_sparepart_id,
            Stock::field_date() => date('Y-m-d H:i:s'),
            Stock::field_description() => "Qty update dari Gudang",
        ]);

        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }
}
