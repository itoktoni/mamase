<?php

namespace App\Http\Services;

use App\Dao\Enums\WorkStatus;
use App\Dao\Enums\WorkType;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\WorkSheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Plugins\Alert;

class UpdateLocationService
{
    public function update($repository, $data, $code)
    {
        DB::beginTransaction();
        $check = $repository->updateRepository($data->all(), $code);

        $check['data']->has_products()->sync($data->product);

        try {

            if($data->check){
                foreach($data->check as $cek){

                    if(isset($cek['id'])){
                        WorkSheet::create([
                            WorkSheet::field_name() => 'Preventif',
                            WorkSheet::field_description() =>  $cek['description'],
                            WorkSheet::field_check() =>  $cek['action'],
                            WorkSheet::field_result() => 'Hasil Pengecekan '.$data->ruangan_name,
                            WorkSheet::field_status() => WorkStatus::Close,
                            WorkSheet::field_type_id() => WorkType::Preventif,
                            WorkSheet::field_implementor() => json_encode([strval(auth()->user()->id)]),
                            WorkSheet::field_location_id() => $data->location_id,
                            WorkSheet::field_reported_at() => date('Y-m-d H:i:s'),
                            WorkSheet::field_reported_at() => date('Y-m-d H:i:s'),
                            WorkSheet::field_product_id() => $cek['id'],
                            WorkSheet::field_contract() => 0,
                            WorkSheet::field_reported_name() => auth()->user()->name,
                        ]);

                        TicketSystem::create([
                            TicketSystem::field_name() => auth()->user()->name,
                            TicketSystem::field_reported_name() => auth()->user()->name,
                            TicketSystem::field_description() => $cek['description'],
                            TicketSystem::field_location_id() => $data->location_id,
                            TicketSystem::field_product_id() => $cek['id'],
                            TicketSystem::field_work_type_id() => WorkType::Preventif,
                        ]);
                    }
                }
            }

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
        }


        if ($check['status']) {
            // $check['data']->has_user()->sync($data->user);
            if(request()->wantsJson()){
                return response()->json($check)->getData();
            }
            Alert::update();
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }
}
