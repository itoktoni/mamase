<?php

namespace App\Http\Services;

use App\Dao\Enums\TicketStatus;
use App\Dao\Interfaces\CrudInterface;
use App\Events\CreateTicketEvent;
use Plugins\Alert;

class UpdateTicketService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $check = $repository->updateRepository($data->all(), $code);

        if($data->ticket_system_status == TicketStatus::Recall){
            event(new CreateTicketEvent($check['data']));
        }


        if ($check['status']) {
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
