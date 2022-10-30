<?php

namespace App\Http\Controllers;

use App\Dao\Enums\RoleType;
use App\Dao\Enums\TicketContract;
use App\Dao\Enums\TicketStatus;
use App\Dao\Enums\WorkStatus;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\User;
use App\Dao\Models\WorkType;
use App\Dao\Repositories\TicketSystemRepository;
use App\Dao\Repositories\WorkSheetRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\WorkSheetRequest;
use App\Http\Services\CreateWorkSheetService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateWorkSheetService;
use Barryvdh\DomPDF\Facade as PDF;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Response;
use Plugins\Template;
use Plugins\Views;

class WorkSheetController extends MasterController
{
    public function __construct(WorkSheetRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    private function getUser($user)
    {
        if (auth()->user()->{User::field_role()} == RoleType::User) {
            $user = $user->where(User::field_primary(), auth()->user()
                    ->{User::field_primary()});
        }

        return $user->pluck(User::field_name(), User::field_primary());
    }

    private function getImplementor($model)
    {
        $implementor = $model
            ->where(User::field_role(), RoleType::Pelaksana)
            ->pluck(User::field_name(), User::field_primary());
        return $implementor;
    }

    protected function share($data = [])
    {
        $work_type = WorkType::getOptions();
        $user = User::getOptions(true);
        $status = WorkStatus::getOptions();
        $contract = TicketContract::getOptions();
        $vendor = Supplier::getOptions();
        $product = Query::getProduct();
        $location = Query::getLocation();

        $ticket = TicketSystem::getOptions(true)
            ->where(TicketSystem::field_status(), '!=', TicketStatus::Close)->mapWithKeys(function ($item) {
            return [$item->{TicketSystem::field_primary()} => Views::uiiShort($item->{TicketSystem::field_primary()}) . ' - ' . $item->{TicketSystem::field_name()}];
        });

        $data_ticket = false;
        if (request()->has('ticket_id')) {
            $data_ticket = (new TicketSystemRepository())
                ->getTicketByCode(request()
                        ->get('ticket_id'));
        }

        $view = [
            'work_type' => $work_type,
            'data_ticket' => $data_ticket,
            'ticket' => $ticket,
            'user' => $this->getUser($user),
            'model' => false,
            'status' => $status,
            'contract' => $contract,
            'location' => $location,
            'product' => $product,
            'vendor' => $vendor,
            'implementor' => $this->getImplementor($user),

        ];

        return self::$share = array_merge($view, $data, self::$share);
    }

    public function getCreate()
    {
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'status' => WorkStatus::getOptions([WorkStatus::Open]),
        ]));
    }

    public function getUpdate($code)
    {
        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $this->get($code, 'has_ticket'),
        ]));
    }

    public function postCreate(WorkSheetRequest $request, CreateWorkSheetService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, WorkSheetRequest $request, UpdateWorkSheetService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getPdf()
    {
        $data = $this->get(request()->get('code'), [
            'has_work_type',
            'has_product',
            'has_ticket',
            'has_reported_by',
        ])->first();

        $share = [
            'master' => $data,
        ];
        $pdf = PDF::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }
}
