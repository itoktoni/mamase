<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Receive;
use App\Dao\Models\Stock;
use App\Dao\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Plugins\Alert;
use Plugins\Notes;

class CreateReceiveService extends CreateService
{
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        try {

            DB::beginTransaction();
            foreach ($data->data as $item) {
                if ($item['receive_qty'] > 0) {

                    Receive::create($item);

                    $qty = $item['receive_qty'];

                    $warehouse = Warehouse::where(Warehouse::field_sparepart_id(), $item['receive_sparepart_id'])
                        ->where(Warehouse::field_location_id(), $item['receive_location_id'])->first();

                    if ($warehouse) {

                        $qty = $warehouse->warehouse_qty ?? 0;
                        $akhir = $qty + $item['receive_qty'];

                        $warehouse->update([
                            Warehouse::field_qty() => $akhir,
                        ]);

                    } else {

                        $akhir = $qty + $item['receive_qty'];

                        Warehouse::create([
                            Warehouse::field_qty() => $item['receive_qty'],
                            Warehouse::field_location_id() => $item['receive_location_id'],
                            Warehouse::field_sparepart_id() => $item['receive_sparepart_id'],
                        ]);
                    }

                    Stock::create([
                        Stock::field_awal() => $qty,
                        Stock::field_perubahan() => $item['receive_qty'],
                        Stock::field_akhir() => $akhir,
                        Stock::field_location_id() => $item['receive_location_id'],
                        Stock::field_sparepart_id() => $item['receive_sparepart_id'],
                        Stock::field_date() => date('Y-m-d H:i:s'),
                        Stock::field_description() => "Qty di update di bulk penerimaan",
                    ]);
                }

                DB::commit();
                $check = Notes::create($data->id);
            }

            if (isset($check['status']) && $check['status']) {

                Alert::create();
            } else {
                $message = env('APP_DEBUG') ? $check['data'] : $check['message'];
                Alert::error($message);
                DB::rollBack();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }
}
