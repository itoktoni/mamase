<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Product;
use App\Dao\Models\Request;
use App\Dao\Models\Sparepart;
use App\Dao\Models\Stock;
use App\Dao\Models\Warehouse;
use App\Dao\Models\WorkSheet;
use Illuminate\Support\Facades\DB;
use Plugins\Alert;

class CreateDistributionService extends CreateService
{
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        DB::beginTransaction();
        try {

            $check = $repository->saveRepository($data->all());

            $from = Warehouse::where(Warehouse::field_location_id(), $data->distribution_location_from)
            ->where(Warehouse::field_sparepart_id(), $data->distribution_sparepart_id)
            ->first();

            $qty = $pengurangan = 0;
            if($from){
                $qty = $from->field_qty;
                $perubahan = $data->distribution_qty;
                $akhir = $qty - $perubahan;

                Warehouse::where(Warehouse::field_location_id(), $data->distribution_location_from)
                    ->where(Warehouse::field_sparepart_id(), $data->distribution_sparepart_id)
                    ->update([
                        Warehouse::field_qty() => $akhir
                    ]);

                Stock::create([
                    Stock::field_awal() => $qty,
                    Stock::field_perubahan() => $perubahan,
                    Stock::field_akhir() => $akhir,
                    Stock::field_location_id() => $data->distribution_location_from,
                    Stock::field_sparepart_id() => $data->distribution_sparepart_id,
                    Stock::field_date() => date('Y-m-d H:i:s'),
                    Stock::field_description() => "Distribusi dari Gudang",
                ]);
            }

            $to = Warehouse::where(Warehouse::field_location_id(), $data->distribution_location_to)
            ->where(Warehouse::field_sparepart_id(), $data->distribution_sparepart_id)
            ->first();

            $qty = $perubahan = $penambahan = $akhir = $sisa = 0;

            if (!empty($data->distribution_waste) && $data->distribution_waste > 0) {
                $sisa = $data->distribution_waste;
            }

            if($to){
                $qty = $to->field_qty;
                $perubahan = $data->distribution_qty;
                $penambahan = ($qty + $perubahan);
                $akhir = $penambahan - $sisa;

                Warehouse::where(Warehouse::field_location_id(), $data->distribution_location_to)
                ->where(Warehouse::field_sparepart_id(), $data->distribution_sparepart_id)
                ->update([
                    Warehouse::field_qty() => $akhir
                ]);

                Stock::create([
                    Stock::field_awal() => $qty,
                    Stock::field_perubahan() => $perubahan,
                    Stock::field_akhir() => $penambahan,
                    Stock::field_location_id() => $data->distribution_location_to,
                    Stock::field_sparepart_id() => $data->distribution_sparepart_id,
                    Stock::field_date() => date('Y-m-d H:i:s'),
                    Stock::field_description() => "Distribusi ke Lokasi",
                ]);

                if (!empty($data->distribution_waste) && $data->distribution_waste > 0) {
                    Stock::create([
                        Stock::field_awal() => $penambahan,
                        Stock::field_perubahan() => $sisa,
                        Stock::field_akhir() => $akhir,
                        Stock::field_location_id() => $data->distribution_location_to,
                        Stock::field_sparepart_id() => $data->distribution_sparepart_id,
                        Stock::field_date() => date('Y-m-d H:i:s'),
                        Stock::field_description() => "Sisa / Rusak",
                    ]);
                }

            } else{

                Stock::create([
                    Stock::field_awal() => $qty,
                    Stock::field_perubahan() => $data->distribution_qty,
                    Stock::field_akhir() => $data->distribution_qty,
                    Stock::field_location_id() => $data->distribution_location_to,
                    Stock::field_sparepart_id() => $data->distribution_sparepart_id,
                    Stock::field_date() => date('Y-m-d H:i:s'),
                    Stock::field_description() => "Distribusi ke Lokasi",
                ]);

                if (!empty($data->distribution_waste) && $data->distribution_waste > 0) {
                    Stock::create([
                        Stock::field_awal() => $data->distribution_qty,
                        Stock::field_perubahan() => $sisa,
                        Stock::field_akhir() => $data->distribution_qty - $sisa,
                        Stock::field_location_id() => 2000,
                        Stock::field_sparepart_id() => $data->distribution_sparepart_id,
                        Stock::field_date() => date('Y-m-d H:i:s'),
                        Stock::field_description() => "Sisa / Rusak",
                    ]);
                }

                Warehouse::create([
                    Warehouse::field_qty() => $data->distribution_qty - $sisa,
                    Warehouse::field_location_id() => $data->distribution_location_to,
                    Warehouse::field_sparepart_id() => $data->distribution_sparepart_id,
                ]);
            }

            DB::commit();

            if(isset($check['status']) && $check['status']){

                Alert::create();
            }
            else{
                $message = env('APP_DEBUG') ? $check['data'] : $check['message'];
                Alert::error($message);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }
}
