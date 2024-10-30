<?php

namespace App\Http\Controllers;

use App\Dao\Enums\ScheduleType;
use App\Dao\Enums\TicketStatus;
use App\Dao\Models\Department;
use App\Dao\Models\User;
use App\Dao\Enums\TicketPriority;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\TicketTopic;
use App\Dao\Models\WorkSheet;
use App\Dao\Repositories\ScheduleRepository;
use App\Dao\Repositories\TicketSystemRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketSystemRequest;
use App\Http\Services\CreateTicketService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Response;
use Plugins\Template;
use Maatwebsite\Excel\Facades\Excel;
use Plugins\Views;

class ReportScheduleController extends MasterController
{
    public function __construct(ScheduleRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {
        $user = User::getOptions();
        $type = ScheduleType::getOptions();

        self::$share = [
            'user' => $user,
            'type' => $type,
        ];
    }

    public function getCalendar(){

        $data = [];
        $ticket = TicketSystem::with(['has_type', 'has_location', 'has_reported', 'has_location.has_building'])->get();
        foreach($ticket as $item){
            $title = __('Tiket').PHP_EOL;
            if($item->has_type){
                $title = $title.' '.$item->has_type->field_name.PHP_EOL ?? '';
            }
            if($item->has_location){
                $title = $title.' '.$item->has_location->has_building->field_name.PHP_EOL ?? '';
                $title = $title.' '.$item->has_location->field_name.PHP_EOL ?? '';
            }
            if($item->has_reported){
                $title = $title.' '.$item->has_reported->field_name.PHP_EOL ?? '';
            }
            $data[] = [
                'title' => $title,
                'start' => $item->field_reported_at,
                'end' => $item->field_reported_at,
                'color' => Views::randomColor()
            ];
        }

        $worksheet = WorkSheet::with(['has_type', 'has_location', 'has_reported_by', 'has_location.has_building'])->get();
        foreach($worksheet as $item){
            $title = __('Work Sheet').PHP_EOL;
            if($item->has_work_type){
                $title = $title.' '.$item->has_work_type->field_name.PHP_EOL ?? '';
            }
            if($item->has_location){
                $title = $title.' '.$item->has_location->has_building->field_name.PHP_EOL ?? '';
                $title = $title.' '.$item->has_location->field_name.PHP_EOL ?? '';
            }
            if($item->has_reported_by){
                $title = $title.' '.$item->has_reported_by->field_name.PHP_EOL ?? '';
            }
            $data[] = [
                'title' => $title,
                'start' => $item->field_reported_at,
                'end' => $item->field_reported_at,
                'color' => Views::randomColor()
            ];
        }

        return response()->json($data);
    }

    public function getPrint(){
        $query = self::$repository->setDisablePaginate()->dataRepository();
        return view(Template::print(SharedData::get('template')))->with($this->share([
            'data' => $query->get(),
            'fields' => self::$repository->model->getShowField(),
        ]));
    }

    public function getExcel()
    {
        return Excel::download(new TicketSystemRepository, 'ticket_system.'.date('Ymd').'.xlsx');
    }

    public function getCsv()
    {
        return self::$repository->excel('ticket_system.'.date('Ymd'));
    }
}
