<?php

namespace App\Http\Services;

use App\Dao\Models\Receive;
use App\Dao\Models\Stock;
use App\Dao\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Plugins\Alert;

class UpdateReceiveService
{
    public function update($data, $code)
    {
        $check = false;
        DB::beginTransaction();

        try {

            $check = Receive::create($data->all());

            $qty = 0;
            $akhir = 0;

            $warehouse = Warehouse::where(Warehouse::field_sparepart_id(), $data->receive_sparepart_id)
                ->where(Warehouse::field_location_id(), $data->receive_location_id);

            if ($warehouse->count() > 0) {

                $update = $warehouse->first();

                $qty = $update->warehouse_qty ?? 0;
                $akhir = $qty + $data->receive_qty;

                $warehouse->update([
                    Warehouse::field_qty() => $akhir
                ]);

            } else {

                $akhir = $qty + $data->receive_qty;

                Warehouse::create([
                    Warehouse::field_qty() => $data->receive_qty,
                    Warehouse::field_location_id() => $data->receive_location_id,
                    Warehouse::field_sparepart_id() => $data->receive_sparepart_id,
                ]);
            }

            Stock::create([
                Stock::field_awal() => $qty,
                Stock::field_perubahan() => $data->receive_qty,
                Stock::field_akhir() => $akhir,
                Stock::field_location_id() => $data->receive_location_id,
                Stock::field_sparepart_id() => $data->receive_sparepart_id,
                Stock::field_date() => date('Y-m-d H:i:s'),
                Stock::field_description() => "Qty di update di penerimaan",
            ]);

            DB::commit();

            Alert::update();

        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
        }

        return $check;
    }
}
