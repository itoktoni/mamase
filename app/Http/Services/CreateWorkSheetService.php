<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Events\CreateWorkSheetEvent;
use Plugins\Alert;

class CreateWorkSheetService extends CreateService
{
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($data->all());
            if (isset($check['status']) && $check['status']) {
                Alert::create();
                if ($data->input('work_sheet_status') == 1 || $data->input('work_sheet_status') == 3) {
                    event(new CreateWorkSheetEvent($check['data']));
                }
            } else {
                $message = env('APP_DEBUG') ? $check['data'] : $check['message'];
                Alert::error($message);
            }
        } catch (\Throwable$th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }
}
