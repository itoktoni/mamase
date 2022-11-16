<?php

namespace App\Http\Services;

use App\Dao\Enums\ScheduleEvery;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Location;
use App\Dao\Models\Schedule;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\WorkSheet;
use App\Events\CreateScheduleEvent;
use Illuminate\Support\Carbon;
use Plugins\Alert;

class CreateScheduleService extends CreateService
{
    private function saveTicket($request, $value)
    {
        if ($request->get(Schedule::field_location_id())) {
            if ($request->get(Schedule::field_product_id())) {

            }
        }
        $ticket = [
            TicketSystem::field_name() => $request->schedule_name,
            TicketSystem::field_description() => $request->schedule_description,
            TicketSystem::field_location_id() => $request->schedule_location_id,
            TicketSystem::field_product_id() => $request->schedule_product_id,
            TicketSystem::field_work_type_id() => $request->schedule_status,
        ];

        TicketSystem::create(array_merge($value, $ticket));
    }

    private function saveWorksheet($request, $value)
    {
        $ticket = [
            WorkSheet::field_name() => $request->schedule_name,
            WorkSheet::field_description() => $request->schedule_description,
            WorkSheet::field_type_id() => $request->schedule_status,
        ];

        WorkSheet::create(array_merge($value, $ticket));
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
                        case ScheduleEvery::Hari:
                            $date = $date->addDay($number);
                            break;
                        case ScheduleEvery::Minggu:
                            $date = $date->addWeek($number);
                            break;
                        case ScheduleEvery::Bulan:
                            $date = $date->addMonth($number);
                            break;
                        case ScheduleEvery::Tahun:
                            $date = $date->addYear($number);
                            break;
                        default:
                            # code...
                            break;
                    }

                    if (!empty($data->get(Schedule::field_location_id()))) {
                        if (!empty($data->get(Schedule::field_product_id()))) {

                            $this->saveWorksheet($data, [
                                WorkSheet::field_schedule_id() => $check['data']->schedule_id,
                                WorkSheet::field_reported_at() => $date->format('Y-m-d'),
                                WorkSheet::field_reported_name() => auth()->user()->name,
                            ]);
                        }
                        else{

                            $location = Location::with(['has_product'])
                            ->find($data->get(Schedule::field_location_id()));

                            $product = $location->has_product;
                            if(count($product) > 0){
                                foreach($product as $item){
                                    $this->saveWorksheet($data, [
                                        WorkSheet::field_schedule_id() => $check['data']->schedule_id,
                                        WorkSheet::field_reported_at() => $date->format('Y-m-d'),
                                        WorkSheet::field_reported_name() => auth()->user()->name,
                                        WorkSheet::field_contract() => $item->field_contract,
                                        WorkSheet::field_vendor_id() => $item->field_vendor_id,
                                        WorkSheet::field_product_id() => $item->field_primary,
                                        WorkSheet::field_location_id() => $item->field_location_id,
                                        WorkSheet::field_implementor() => json_decode($item->field_teknisi_data),
                                    ]);
                                }
                            }
                        }
                    }


                }

                Alert::create();

                if ($data->input('schedule_notification') == 1 || true) {
                    event(new CreateScheduleEvent($check['data']));
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
