<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Events\CreateMovementEvent;
use Plugins\Alert;

class UpdateMovementService extends UpdateService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $check = $repository->updateRepository($data->all(), $code);
        if ($check['status']) {
            if (request()->wantsJson()) {
                return response()->json($check)->getData();
            }
            Alert::update();
            if ($data->input('movement_status') == 1 || $data->input('movement_status') == 3) {
                event(new CreateMovementEvent($check['data']));
            }
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }
}
