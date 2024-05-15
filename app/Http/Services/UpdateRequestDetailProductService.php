<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Request;
use App\Dao\Models\Sparepart;
use App\Dao\Models\WorkSheet;
use Illuminate\Support\Facades\DB;
use Plugins\Alert;

class UpdateRequestDetailProductService
{
    public function update($data, $code)
    {
        $sparepart = DB::table('work_sheet_sparepart')
        ->where('request_code', $code)
        ->updateOrInsert([
            'request_code' => $code,
            'sparepart_id' => $data->sparepart,
            'qty' => $data->qty,
            'description' => $data->description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $check = false;
        if ($sparepart) {

            if(request()->wantsJson()){
                return response()->json($check)->getData();
            }

            $check = false;
            Alert::update();

        } else {
            $check = false;
            Alert::error($check['data']);
        }
        return $check;
    }
}
