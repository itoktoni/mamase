<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Events\CreateScheduleEvent;
use Plugins\Alert;

class UpdateScheduleService extends UpdateService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $check = $repository->updateRepository($data->all(), $code);
        if ($check['status']) {
            if (request()->wantsJson()) {
                return response()->json($check)->getData();
            }
            Alert::update();
            if ($data->input('schedule_notification') == 1) {
                event(new CreateScheduleEvent($check['data']));
            }
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }
}
