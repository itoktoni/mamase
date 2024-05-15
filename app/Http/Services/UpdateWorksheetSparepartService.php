<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Sparepart;
use App\Dao\Models\WorkSheet;
use Plugins\Alert;

class UpdateWorksheetSparepartService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $worksheet = WorkSheet::with(['has_ticket', 'has_sparepart'])
        ->find($code);
        $check = false;
        if ($worksheet) {

            $worksheet->has_sparepart()->attach($code,[
                'product_id' => $data->product,
                'sparepart_id' => $data->sparepart,
                'qty' => $data->qty ?? 0,
                'description' => $data->description ?? '',
                'created_at' => date('Y-m-d H:i:s') ?? '',
                'updated_at' => date('Y-m-d H:i:s') ?? '',
            ]);

            $sparepart = Sparepart::find($data->sparepart);
            $sparepart->{Sparepart::field_stock()} = $sparepart->field_qty - $data->qty;
            $sparepart->save();

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
