<?php

namespace App\Http\Controllers;

use App\Dao\Enums\KontrakType;
use App\Dao\Enums\RoleType;
use App\Dao\Enums\WorkStatus;
use App\Dao\Enums\WorkType as EnumsWorkType;
use App\Dao\Models\Category;
use App\Dao\Models\Department;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Models\TicketTopic;
use App\Dao\Models\User;
use App\Dao\Models\Warehouse;
use App\Dao\Models\WorkType;
use App\Dao\Repositories\DistributionRepository;
use App\Dao\Repositories\WarehouseRepository;
use App\Dao\Repositories\WorkSheetRepository;
use App\Http\Controllers\MasterController;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Template;
use Maatwebsite\Excel\Facades\Excel;
use Plugins\Query;

class ReportStockSparepartController extends MasterController
{
    public function __construct(WarehouseRepository $repository)
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
        $category = Category::getOptions();

        self::$share = [
            'department' => $department,
            'category' => $category,
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

        $report = self::$repository->getReport()->get();
        $sparepart = $report->unique('sparepart_id')
        ->mapToGroups(function ($item) {
            return [$item->category_name => $item];
        });

        $query = $report->mapToGroups(function ($item) {
            return [$item->category_name => $item];
        });

        $location = Location::getOptions();
        $warehouse = Warehouse::get();

        $count = 0;
        foreach($location as $loc){
            if($count < strlen($loc)){
                $count = strlen($loc);
            }
        }

        return view(Template::print(SharedData::get('template')))->with($this->share([
            'data' => $query,
            'location' => $location,
            'warehouse' => $warehouse,
            'sparepart' => $sparepart,
            'count' => $count,
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
