<?php

namespace App\Http\Services;

use App\Dao\Enums\ScheduleEvery;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\TicketSystem;
use App\Events\CreateScheduleEvent;
use Illuminate\Support\Carbon;
use Plugins\Alert;

class CreateScheduleService extends CreateService
{
    private function saveTicket($request, $value)
    {
        $ticket = [
            TicketSystem::field_name() => $request->schedule_name,
            TicketSystem::field_description() => $request->schedule_description,
            TicketSystem::field_location_id() => $request->schedule_location_id,
            TicketSystem::field_product_id() => $request->schedule_product_id,
            TicketSystem::field_work_type_id() => $request->schedule_status,
        ];

        TicketSystem::create(array_merge($value, $ticket));
    }
    public function save(CrudInterface $repository, $data)
    {
        $check = false;
        try {
            $check = $repository->saveRepository($data->all());
            if (isset($check['status']) && $check['status']) {

                $times = $data->schedule_times;
                $number = $data->schedule_number;
                $date = Carbon::createFromFormat('Y-m-d', $data->schedule_start_date)->addDay(-1);
                for ($i = 0; $i < $times; $i++) {
                    switch ($data->schedule_every) {
                        case ScheduleEvery::Day:
                            $date = $date->addDay($number);
                            break;
                        case ScheduleEvery::Week:
                            $date = $date->addWeek($number);
                            break;
                        case ScheduleEvery::Month:
                            $date = $date->addMonth($number);
                            break;
                        case ScheduleEvery::Year:
                            $date = $date->addYear($number);
                            break;
                        default:
                            # code...
                            break;
                    }

                    $this->saveTicket($data, [
                        TicketSystem::field_schedule_id() => $check['data']->schedule_id,
                        TicketSystem::field_reported_at() => $date->format('Y-m-d'),
                        TicketSystem::field_reported_name() => auth()->user()->name,
                    ]);
                }

                Alert::create();

                if ($data->input('schedule_notification') == 1 || true) {
                    event(new CreateScheduleEvent($check['data']));
                }
            } else {
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
