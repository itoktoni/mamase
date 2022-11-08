<?php

namespace App\Http\Services;

use Illuminate\Validation\Rule;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Sparepart;
use App\Dao\Models\WorkSheet;
use Illuminate\Support\Facades\DB;
use Plugins\Alert;
use Plugins\Notes;

class DeleteSparepartService
{
    public function delete(CrudInterface $repository, $code)
    {
        $rules = ['code' => 'required'];
        request()->validate($rules, ['code.required' => 'Please select any data !']);
        $data = DB::table('work_sheet_sparepart')
        ->where(WorkSheet::field_primary(), $code['code'])
        ->where(Sparepart::field_primary(), $code['id'])
        ->delete();

        $check = Notes::delete($data);

        if ($check) {
            Alert::delete();
        }

        if (request()->wantsJson()) {

            return response()->json($check)->getData();
        }

        return $check;
    }
}
