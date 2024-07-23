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
        $filename = 'data-stock.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'ID Sparepart',
                'Nama Sparepart',
                'ID Lokasi',
                'Nama Lokasi',
                'Stock',
            ]);

            Warehouse::with(['has_location', 'has_sparepart'])->chunk(500, function ($items) use ($handle) {
                foreach ($items as $item) {

                    $sparepart = $item->has_sparepart;
                    $location = $item->has_location;

                    $data = [
                        $item->warehouse_sparepart_id ?? '',
                        $sparepart->field_name ?? '',
                        $item->warehouse_location_id ?? '',
                        $location->field_name ?? '',
                        $item->warehouse_qty ?? '',
                    ];

             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });

            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }

    public function postImport(Request $request)
    {
        $request->validate([
            'import_csv' => 'required',
        ]);
        //read csv file and skip data
        $file = $request->file('import_csv');
        $handle = fopen($file->path(), 'r');

        //skip the header row
        fgetcsv($handle);

        $chunksize = 25;
        while(!feof($handle))
        {
            $chunkdata = [];

            for($i = 0; $i<$chunksize; $i++)
            {
                $data = fgetcsv($handle);
                if($data === false)
                {
                    break;
                }
                $chunkdata[] = $data;
            }

            $check = $this->getchunkdata($chunkdata);
        }
        fclose($handle);

        if($check){
            return redirect()->back()->with('success', 'Import data sukses !');
        }

        return redirect()->back()->with('error', 'Import data gagal !');

    }

    public function getchunkdata($chunkdata)
    {
        DB::beginTransaction();

        try {
            foreach($chunkdata as $column)
            {
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
            }

            DB::commit();

            return true;

        } catch (\Throwable $th) {
            DB::rollBack();

            return false;
        }

    }
}
