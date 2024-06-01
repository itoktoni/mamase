<?php

namespace App\Http\Controllers;

use App\Dao\Enums\ScheduleType;
use App\Dao\Enums\TicketStatus;
use App\Dao\Models\Department;
use App\Dao\Models\User;
use App\Dao\Enums\TicketPriority;
use App\Dao\Models\Category;
use App\Dao\Models\Product;
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
use DateInterval;
use DatePeriod;
use DateTime;
use Plugins\Response;
use Plugins\Template;
use Maatwebsite\Excel\Facades\Excel;
use Plugins\Views;

class ReportCheckLocationController extends MasterController
{
    public function __construct(ScheduleRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {
        $user = User::getOptions();
        $category = Category::getOptions();
        $type = ScheduleType::getOptions();

        $periode = new DatePeriod(
            new DateTime(request('start_date')),
            new DateInterval('P1D'),
            new DateTime(request('end_date'))
       );

       $query = WorkSheet::select([
            'model_category_id',
            'work_sheet_reported_at',
            'work_sheet_implementor',
       ])
            ->leftJoinRelationship('has_product')
            ->leftJoinRelationship('has_product.has_model');

        if(request('start_date') && request('end_date')){
            $query = $query
                ->whereBetween('work_sheet_reported_at', [
                    request('start_date'),
                    request('end_date'),
                ]);
        }

        if(request('user_id')){
            $query = $query->whereIn(WorkSheet::field_implementor(), [request()->get('user_id')]);
            $teknisi = User::where('id', request()->get('user_id'))->first();
        }

        self::$share = [
            'category' => $category,
            'user' => $user,
            'type' => $type,
            'periode' => $periode,
            'teknisi' => $teknisi ?? false,
            'matrix' => $query->get(),
        ];
    }

    public function getPrint(){
        $this->beforeForm();

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
