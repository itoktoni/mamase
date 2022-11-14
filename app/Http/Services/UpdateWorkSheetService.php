<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Events\CreateWorkSheetEvent;
use Plugins\Alert;


class UpdateWorkSheetService extends UpdateService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $check = $repository->updateRepository($data->all(), $code);
        if ($check['status']) {
            if (request()->wantsJson()) {
                return response()->json($check)->getData();
            }
            Alert::update();
            // if ($data->input('work_sheet_status') == 1 || $data->input('work_sheet_status') == 3) {
            //     event(new CreateWorkSheetEvent($check['data']));
            // }
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }
}
