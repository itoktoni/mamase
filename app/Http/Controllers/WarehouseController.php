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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Plugins\Alert;
use Plugins\Query;
use Plugins\Template;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

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

    public function getStock($sparepart, $location)
    {
        $this->beforeForm();
        $this->beforeUpdate($sparepart);

        $model = Warehouse::where(Warehouse::field_sparepart_id(), $sparepart)
            ->where(Warehouse::field_location_id(), $location)
            ->first();

        return view(Template::form(SharedData::get('template'), 'stock'))->with($this->share([
            'model' => $model,
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

        $data = $warehouse->update([
            Warehouse::field_qty() => $request->warehouse_qty
        ]);

        return Response::redirectBack(Alert::update("qty berhasil di update"));
    }

    public function getExport()
    {
        $filename = 'data-stock.xlsx';

        $writer = SimpleExcelWriter::streamDownload($filename)
        ->addHeader([
            'ID Sparepart',
            'Nama Sparepart',
            'ID Lokasi',
            'Nama Lokasi',
            'Stock',
        ]);

        $count = 0;
        Warehouse::with(['has_location', 'has_sparepart'])->chunk(500, function ($items) use ($writer, $count) {
            foreach ($items as $item) {

                $sparepart = $item->has_sparepart;
                $location = $item->has_location;

                $writer->addRow([
                    $item->warehouse_sparepart_id ?? '',
                    $sparepart->field_name ?? '',
                    $item->warehouse_location_id ?? '',
                    $location->field_name ?? '',
                    $item->warehouse_qty ?? '',
                ]);

                $count++;

                if ($count % 1000 === 0) {
                    flush(); // Flush the buffer every 1000 rows
                }
            }
        });

        return $writer->toBrowser();
    }

    public function postImport(Request $request)
    {
        $request->validate([
            'import_csv' => 'required|mimes:csv,xlsx',
        ]);

        $file = $request->file('import_csv');

        $check = SimpleExcelReader::create($file, 'xlsx')
            ->noHeaderRow()
            ->getRows()
            ->skip(1)
            ->each(function (array $column) {

                $id_sparepart = $column[0];
                $id_location = $column[2];
                $stock = $column[4];

                if(!empty($id_sparepart) && !empty($id_location) && !empty($stock)){
                    Warehouse::where(Warehouse::field_sparepart_id(), $id_sparepart)
                        ->where(Warehouse::field_location_id(), $id_location)
                        ->update([
                        Warehouse::field_qty() => $stock
                    ]);

                    Stock::create([
                        Stock::field_awal() => null,
                        Stock::field_perubahan() => $stock,
                        Stock::field_akhir() => $stock,
                        Stock::field_location_id() => $id_location,
                        Stock::field_sparepart_id() => $id_sparepart,
                        Stock::field_date() => date('Y-m-d H:i:s'),
                        Stock::field_description() => "Qty update dari Import Excel",
                    ]);
                }
            });

        return redirect()->back()->with('success', 'Import data sukses !');
    }
}
