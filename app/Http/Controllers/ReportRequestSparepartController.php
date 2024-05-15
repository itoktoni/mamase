<?php

namespace App\Http\Controllers;

use App\Dao\Enums\KontrakType;
use App\Dao\Enums\RoleType;
use App\Dao\Enums\WorkStatus;
use App\Dao\Enums\WorkType as EnumsWorkType;
use App\Dao\Models\Department;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Models\TicketTopic;
use App\Dao\Models\User;
use App\Dao\Models\WorkType;
use App\Dao\Repositories\WorkSheetRepository;
use App\Http\Controllers\MasterController;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Template;
use Maatwebsite\Excel\Facades\Excel;
use Plugins\Query;

class ReportRequestSparepartController extends MasterController
{
    public function __construct(WorkSheetRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {
        $department = Department::getOptions();
        $user = User::getOptions();
        $work_type = EnumsWorkType::getOptions();
        $product = Query::getProduct();
        $user = User::getOptions();
        $status = WorkStatus::getOptions();
        $location = Location::getOptions();
        $supplier = Supplier::getOptions();
        $kontrak = KontrakType::getOptions();
        $teknisi = Query::getUserByRole(RoleType::Teknisi);
        $ticket_topic = TicketTopic::getOptions();

        self::$share = [
            'department' => $department,
            'ticket_topic' => $ticket_topic,
            'work_type' => $work_type,
            'product' => $product,
            'user' => $user,
            'location' => $location,
            'status' => $status,
            'supplier' => $supplier,
            'kontrak' => $kontrak,
            'teknisi' => $teknisi,
        ];
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
        return Excel::download(new WorkSheetRepository, 'work_sheet.'.date('Ymd').'.xlsx');
    }

    public function getCsv()
    {
        return self::$repository->excel('work_sheet.'.date('Ymd'));
    }
}
