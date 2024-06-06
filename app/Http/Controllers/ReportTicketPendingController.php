<?php

namespace App\Http\Controllers;

use App\Dao\Enums\TicketStatus;
use App\Dao\Models\Department;
use App\Dao\Models\User;
use App\Dao\Enums\TicketPriority;
use App\Dao\Enums\WorkType as EnumsWorkType;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\TicketTopic;
use App\Dao\Models\WorkType;
use App\Dao\Repositories\TicketSystemRepository;
use App\Http\Controllers\MasterController;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Response;
use Plugins\Template;
use Maatwebsite\Excel\Facades\Excel;

class ReportTicketPendingController extends MasterController
{
    public function __construct(TicketSystemRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {
        $ticket_topic = TicketTopic::getOptions();
        $department = Department::getOptions();
        $user = User::getOptions();
        $status = TicketStatus::getOptions();
        $priority = TicketPriority::getOptions();
        $type = EnumsWorkType::getOptions();

        self::$share = [
            'ticket_topic' => $ticket_topic,
            'department' => $department,
            'user' => $user,
            'status' => $status,
            'type' => $type,
            'priority' => $priority,
        ];
    }

    public function getPrint(){
        $query = self::$repository->setDisablePaginate()->dataRepository()->where(TicketSystem::field_status(), '!=', TicketStatus::Finish);
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
