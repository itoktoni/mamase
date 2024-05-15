<?php

namespace App\Http\Services;

use App\Dao\Enums\BooleanType;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Product;
use App\Dao\Models\Request;
use App\Dao\Models\Sparepart;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\WorkSheet;
use App\Events\CreateTicketEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Plugins\Alert;

class CreateRequestService extends CreateService
{
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        try {
            $detail = WorkSheet::joinRelationship('has_sparepart')
            ->addSelect('work_sheet_sparepart.*')
            ->whereNull(WorkSheet::field_flag_request())
            ->whereNull(Request::field_primary())
            ->whereDate(WorkSheet::field_reported_at(), '>=', $data->get('request_start_date'))
            ->whereDate(WorkSheet::field_reported_at(), '<=', $data->get('request_end_date'))
            ->get();

            if($detail->count() > 0){
                foreach($detail as $item){
                        $request = DB::table('work_sheet_sparepart')
                        ->where(WorkSheet::field_primary(), $item->work_sheet_code)
                        ->where(Product::field_primary(), $item->product_id)
                        ->where(Sparepart::field_primary(), $item->sparepart_id)
                        ->update([
                            'request_code' => $data->request_code
                        ]);
                }
            }

            $check = $repository->saveRepository($data->all());

            if(isset($check['status']) && $check['status']){

                Alert::create();
            }
            else{
                $message = env('APP_DEBUG') ? $check['data'] : $check['message'];
                Alert::error($message);
            }
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }
}

