<?php

namespace App\Http\Controllers;

use App\Dao\Enums\KontrakType;
use App\Dao\Enums\ProductStatus;
use App\Dao\Enums\RoleType;
use App\Dao\Enums\TicketStatus;
use App\Dao\Enums\WorkStatus;
use App\Dao\Enums\WorkType as EnumsWorkType;
use App\Dao\Models\Product;
use App\Dao\Models\Sparepart;
use App\Dao\Models\Supplier;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\User;
use App\Dao\Models\WorkSuggestion;
use App\Dao\Models\WorkType;
use App\Dao\Repositories\TicketSystemRepository;
use App\Dao\Repositories\WorkSheetRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\WorkSheetRequest;
use App\Http\Requests\WorksheetSparepartRequest;
use App\Http\Services\CreateWorkSheetService;
use App\Http\Services\DeleteSparepartService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateWorkSheetService;
use App\Http\Services\UpdateWorksheetSparepartService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Http\Request;
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
        if (auth()->user()->{User::field_role()} == RoleType::Pengguna) {
            $user = $user->where(User::field_primary(), auth()->user()
                    ->{User::field_primary()});
        }

        return $user->pluck(User::field_name(), User::field_primary());
    }

    private function getImplementor($model)
    {
        $implementor = $model
            ->where(User::field_type(), RoleType::Teknisi)
            ->pluck(User::field_name(), User::field_primary());
        return $implementor;
    }

    protected function share($data = [])
    {
        $work_type = EnumsWorkType::getOptions();
        $user = User::getOptions(true);
        $status = WorkStatus::getOptions();
        $contract = KontrakType::getOptions();
        $vendor = Supplier::getOptions();
        $product = Query::getProduct();
        $location = Query::getLocation();
        $sparepart = Sparepart::getOptions();
        $saran = WorkSuggestion::getOptions();
        $product_status = ProductStatus::getOptions();

        $selected_product = $selected_location = $selected_category = null;

        $ticket = TicketSystem::getOptions(true)
            ->where(TicketSystem::field_status(), '!=', TicketStatus::Finish)->mapWithKeys(function ($item) {
            return [$item->{TicketSystem::field_primary()} => Views::uiiShort($item->{TicketSystem::field_primary()}) . ' - ' . $item->field_reported_name];
        });

        $data_ticket = false;
        if (request()->has('ticket_id')) {
            $data_ticket = (new TicketSystemRepository())
                ->getTicketByCode(request()
                        ->get('ticket_id'));
        }

        if($id = request()->get('id')){
            $selected_product = Product::with(['has_location', 'has_model.has_category', 'has_category'])->find($id);
            $selected_location = $selected_product->has_location ?? null;
            $selected_category = $selected_product->has_model->has_category ?? null;

            if(empty($selected_category)){
                $selected_category = $selected_product->has_category ?? null;
            }

        }

        $view = [
            'work_type' => $work_type,
            'data_ticket' => $data_ticket,
            'ticket' => $ticket,
            'user' => $this->getUser($user),
            'model' => false,
            'status' => $status,
            'contract' => $contract,
            'product_status' => $product_status,
            'saran' => $saran,
            'location' => $location,
            'sparepart' => $sparepart,
            'product' => $product,
            'vendor' => $vendor,
            'implementor' => $this->getImplementor($user),
            'selected_product' => $selected_product,
            'selected_category' => $selected_category,
            'selected_location' => $selected_location,
        ];

        if (Template::isVendor()) {
            $id_vendor = auth()->user()->vendor;
            $view = array_merge($view, [
                'contract' => KontrakType::getOptions([KontrakType::Kontrak]),
                'vendor' => [$id_vendor => $vendor[$id_vendor]],
            ]);
        } else {
            $view = array_merge($view, [
                'contract' => KontrakType::getOptions([KontrakType::TidakKontrak]),
            ]);
        }

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
        $data = $this->get($code, ['has_ticket', 'has_sparepart']);
        $sparepart = $data->has_sparepart ?? false;

        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $data,
            'spareparts' => $sparepart,
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

    public function postUpdateSparepart($code, WorksheetSparepartRequest $request, UpdateWorksheetSparepartService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getDeleteSparepart(Request $request, DeleteSparepartService $service)
    {
        $code = $request->get('code');
        $id = $request->get('id');
        $variable = ['code' => $code, 'id' => $id];
        $data = $service->delete(self::$repository, $variable);
        return Response::redirectBack($data);
    }

    public function getPdf()
    {
        $data = $this->get(request()->get('code'), [
            'has_type',
            'has_product',
            'has_sparepart',
            'has_ticket',
            'has_reported_by',
        ]);

        $share = [
            'master' => $data,
        ];
        $pdf = PDF::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }
}
