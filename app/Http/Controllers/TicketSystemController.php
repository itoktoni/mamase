<?php

namespace App\Http\Controllers;

use App\Dao\Enums\RoleType;
use App\Dao\Enums\KontrakType;
use App\Dao\Enums\TicketPriority;
use App\Dao\Enums\TicketStatus;
use App\Dao\Enums\WorkType as EnumsWorkType;
use App\Dao\Models\Department;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\TicketTopic;
use App\Dao\Models\User;
use App\Dao\Models\WorkSheet;
use App\Dao\Models\WorkType;
use App\Dao\Repositories\TicketSystemRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketSystemRequest;
use App\Http\Requests\TicketWorksheetRequest;
use App\Http\Services\CreateTicketService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateTicketService;
use App\Http\Services\UpdateTicketWorksheetService;
use Barryvdh\DomPDF\Facade as PDF;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Plugins\Query;
use Plugins\Response;
use Plugins\Template;

class TicketSystemController extends MasterController
{
    public function __construct(TicketSystemRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    private function getImplementor($model)
    {
        $implementor = $model
            ->where(User::field_role(), RoleType::Teknisi)
            ->pluck(User::field_name(), User::field_primary());
        return $implementor;
    }

    protected function share($data = [])
    {
        $ticket_topic = TicketTopic::getOptions();
        $department = Department::getOptions();
        // $type = WorkType::getOptions();
        $type = EnumsWorkType::getOptions();
        $user = User::getOptions(true);
        $vendor = Supplier::getOptions();

        $status = TicketStatus::getOptions();
        $priority = TicketPriority::getOptions();
        $contract = KontrakType::getOptions();

        $product = Query::getProduct();
        $location = Query::getLocation();

        $view = [
            'ticket_topic' => $ticket_topic,
            'department' => $department,
            'location' => $location,
            'implementor' => Query::getUserByRole(RoleType::Teknisi),
            'model' => false,
            'status' => $status,
            'type' => $type,
            'product' => $product,
            'priority' => $priority,
            'contract' => $contract,
            'vendor' => $vendor,
            'worksheet' => null,
        ];

        return self::$share = array_merge($view, $data, self::$share);
    }

    public function getCreate()
    {
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'status' => TicketStatus::getOptions([TicketStatus::Open]),
        ]));
    }

    public function getUpdate($code)
    {
        $data = $this->get($code, ['has_worksheet', 'has_type', 'has_worksheet.has_vendor', 'has_worksheet.has_implementor']);
        $worksheet = false;
        $sheet = WorkSheet::where(WorkSheet::field_ticket_code(), $code);
        if($sheet->count() > 0){
            $worksheet = $sheet;
        }
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $this->get($code),
            'worksheet' => $worksheet->sortBy('worksheet_created_at'),
        ]));
    }

    public function postCreate(TicketSystemRequest $request, CreateTicketService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, TicketSystemRequest $request, UpdateTicketService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data, true);
    }

    public function postUpdateWorksheet($code, TicketWorksheetRequest $request, UpdateTicketWorksheetService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getTable()
    {
        $data = $this->getData();
        return view(Template::table(SharedData::get('template')))->with([
            'data' => $data,
            'type' => EnumsWorkType::getOptions(),
            'fields' => self::$repository->model->getShowField(),
        ]);
    }

    public function getPdf()
    {
        $implementor = false;
        $data = $this->get(request()->get('code'), [
            'has_category',
            'has_department',
            'has_location',
            'has_reported',
        ]);

        $share = [
            'master' => $data,
        ];

        $pdf = PDF::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }
}
