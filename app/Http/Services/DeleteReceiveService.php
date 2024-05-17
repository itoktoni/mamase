<?php

namespace App\Http\Services;

use App\Dao\Models\Receive;
use App\Dao\Models\Request;
use App\Dao\Models\Stock;
use App\Dao\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Plugins\Alert;
use Plugins\Notes;

class DeleteReceiveService
{
    public function delete($code)
    {
        $check = false;
        DB::beginTransaction();
        try {
            $data = Receive::find($code);

            if (!empty($data)) {
                $location = $data->field_location_id;
                $sparepart = $data->field_sparepart_id;

                $warehouse = Warehouse::where(Warehouse::field_location_id(), $location)
                    ->where(Warehouse::field_sparepart_id(), $sparepart)
                    ->first();

                $qty = $warehouse->field_qty ?? 0;

                if ($qty > 0) {

                    $akhir = $qty - $data->field_qty;

                    Warehouse::where(Warehouse::field_location_id(), $location)
                    ->where(Warehouse::field_sparepart_id(), $sparepart)
                    ->update([
                        Warehouse::field_qty() => $akhir
                    ]);

                    Stock::create([
                        Stock::field_awal() => $qty,
                        Stock::field_perubahan() => -($data->field_qty),
                        Stock::field_akhir() => $akhir,
                        Stock::field_location_id() => $data->receive_location_id,
                        Stock::field_sparepart_id() => $data->receive_sparepart_id,
                        Stock::field_date() => date('Y-m-d H:i:s'),
                        Stock::field_description() => "Qty di delete di penerimaan",
                    ]);
                }

            }

            $data->delete();

            DB::commit();

            $check = Notes::delete($data);

            if ($check) {
                Alert::delete();
            }

            if (request()->wantsJson()) {

                return response()->json($check)->getData();
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error($th->getMessage());
            //throw $th;
        }

        return $check;
    }
}
