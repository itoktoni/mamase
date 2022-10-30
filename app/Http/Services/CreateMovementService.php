<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use App\Events\CreateMovementEvent;
use Plugins\Alert;

class CreateMovementService extends CreateService
{
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($data->all());
            if (isset($check['status']) && $check['status']) {
                if ($data->input('movement_status') == 1 || $data->input('movement_status') == 3) {
                    Alert::create();
                    event(new CreateMovementEvent($check['data']));
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
