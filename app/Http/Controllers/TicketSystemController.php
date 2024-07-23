<?php

namespace App\Http\Controllers;

use App\Dao\Enums\RoleType;
use App\Dao\Enums\KontrakType;
use App\Dao\Enums\TicketPriority;
use App\Dao\Enums\TicketStatus;
use App\Dao\Enums\WorkStatus;
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
use App\Events\CreateWorkSheetEvent;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketSystemRequest;
use App\Http\Requests\TicketWorksheetRequest;
use App\Http\Services\CreateTicketService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateTicketService;
use App\Http\Services\UpdateTicketWorksheetService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Plugins\Alert;
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

        $product = Product::getOptions();
        $location = Query::getLocation();

        $selected_product = $selected_location = $selected_category = null;

        if($id = request()->get('id')){
            $selected_product = Product::with(['has_location', 'has_model.has_category', 'has_category'])->find($id);
            $selected_location = $selected_product->has_location ?? null;
            $selected_category = $selected_product->has_model->has_category ?? null;

            if(empty($selected_category)){
                $selected_category = $selected_product->has_category ?? null;
            }

        }

        $view = [
            'ticket_topic' => $ticket_topic,
            'department' => $department,
            'location' => $location,
            'implementor' => Query::getUserByRole(RoleType::Teknisi),
            'model' => false,
            'status' => $status,
            'selected_product' => $selected_product,
            'selected_category' => $selected_category,
            'selected_location' => $selected_location,
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

    public function getAmbil($code)
    {
        $ticket = TicketSystem::find($code);
        $ticket->{TicketSystem::field_assigned_at()} = date('Y-m-d H:i:s');
        $ticket->{TicketSystem::field_assigned_by()} = auth()->user()->id;
        $ticket->{TicketSystem::field_status()} = TicketStatus::Progress;

        if($ticket->{TicketSystem::field_status()} != TicketStatus::Finish){
            $work = WorkSheet::where(WorkSheet::field_ticket_code(), $code)
                ->where('work_sheet_created_by', auth()->user()->id)
                ->first();

            if ($work) {

                return redirect()->route('lembar_kerja.getUpdate', ['code' => $work->field_primary]);

            } else {

                $values = [
                    WorkSheet::field_description() => $ticket->field_description,
                    WorkSheet::field_ticket_code() => $code,
                    WorkSheet::field_status() => WorkStatus::Open,
                    WorkSheet::field_type_id() => EnumsWorkType::Korektif ?? null,
                    WorkSheet::field_name() => 'Perbaikan' ?? null,
                    WorkSheet::field_contract() => 0 ?? null,
                    WorkSheet::field_product_id() => $ticket->ticket_system_product_id ?? null,
                    WorkSheet::field_implementor() => json_encode(strval(auth()->user()->id)) ?? null,
                    WorkSheet::field_location_id() => $ticket->{TicketSystem::field_location_id()} ?? null,
                    WorkSheet::field_reported_at() => date('Y-m-d H:i:s'),
                    WorkSheet::field_reported_by() => $ticket->field_reported_by ?? null,
                    WorkSheet::field_reported_name() => $ticket->field_reported_name ?? $ticket->field_reported_by_name ?? null,
                ];

                $works = WorkSheet::create($values);
                event(new CreateWorkSheetEvent($works));

                return redirect()->route('lembar_kerja.getUpdate', ['code' => $works->field_primary]);
            }

            Alert::update();
        }
    }

    public function getUpdate($code)
    {
        $worksheet = false;
        $sheet = WorkSheet::with(['has_vendor', 'has_implementor'])->where(WorkSheet::field_ticket_code(), $code);
        if($sheet->count() > 0){
            $worksheet = $sheet->get()->sortBy('worksheet_created_at');
        }
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $this->get($code),
            'worksheet' => $worksheet,
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
