<?php

namespace App\Http\Controllers;

use App\Dao\Enums\CategoryRequestType;
use App\Dao\Enums\RequestStatusType;
use App\Dao\Models\Location;
use App\Dao\Models\Request;
use App\Dao\Models\Sparepart;
use App\Dao\Models\User;
use App\Dao\Models\WorkSheet;
use App\Dao\Repositories\CategoryRepository;
use App\Dao\Repositories\RequestRepository;
use App\Http\Requests\CategoryRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;
use App\Http\Requests\ReceiveRequest;
use App\Http\Requests\RequestDetailProductRequest;
use App\Http\Requests\RequestRequest;
use App\Http\Services\CreateRequestService;
use App\Http\Services\DeleteReceiveService;
use App\Http\Services\DeleteRequestProductService;
use App\Http\Services\UpdateReceiveService;
use App\Http\Services\UpdateRequestDetailProductService;
use Barryvdh\DomPDF\Facade\Pdf;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Support\Facades\DB;
use Plugins\Query;
use Plugins\Template;

class RequestController extends MasterController
{
    public function __construct(RequestRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $status = RequestStatusType::getOptions();
        $category = CategoryRequestType::getOptions();
        $sparepart = Sparepart::getOptions();
        $user = User::getOptions();

        self::$share = [
            'status' => $status,
            'user' => $user,
            'sparepart' => $sparepart,
            'category' => $category,
        ];
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);
        $data = Request::with([
            'has_sparepart',
        ])->find($code);

        $data_worksheet = DB::table('work_sheet_sparepart')
        ->select('work_sheet_code')
        ->where('request_code', $code)
        ->get()
        ->pluck('work_sheet_code')
        ->unique('work_sheet_code')
        ->toArray() ?? false;

        $status = RequestStatusType::getOptions();

        if($data->request_approval_by != auth()->user()->id)
        {
            $status = RequestStatusType::getOptions([RequestStatusType::Dibuat, RequestStatusType::Diajuakan]);
        }

        if($data->request_status >= RequestStatusType::Disetujui)
        {
            $status = RequestStatusType::getOptions([RequestStatusType::Diajuakan, RequestStatusType::Disetujui]);
        }

        $worksheet = WorkSheet::whereIn('work_sheet_code', $data_worksheet)->get();

        $part = $data->has_sparepart ?? false;

        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $data,
            'worksheet' => $worksheet,
            'part' => $part,
            'status' => $status,
        ]));
    }

    public function postCreate(RequestRequest $request, CreateRequestService $service)
    {
        $data = $service->save(self::$repository, $request);
        if($data['status']){
            return Response::redirectToRoute('permintaan.getUpdate', ['code' => $data['data']->request_code]);
        }

        return Response::redirectBack($data);
    }

    public function postUpdate($code, RequestRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function postUpdateProduct($code, RequestDetailProductRequest $request, UpdateRequestDetailProductService $service)
    {
        $data = $service->update($request, $code);
        return Response::redirectBack($data);
    }

    public function getDeleteProduct($code, $id, DeleteRequestProductService $service)
    {
        $variable = ['code' => $code, 'id' => $id];
        $data = $service->delete($variable);
        return Response::redirectBack($data);
    }

    public function getPrint($code)
    {
        $data = Request::with([
            'has_sparepart',
        ])->find($code);

        $data_worksheet = DB::table('work_sheet_sparepart')
        ->select('work_sheet_code')
        ->where('request_code', $code)
        ->get()
        ->pluck('work_sheet_code')
        ->unique('work_sheet_code')
        ->toArray() ?? false;

        $worksheet = WorkSheet::whereIn('work_sheet_code', $data_worksheet)->get();

        $part = $data->has_sparepart ?? false;

        $share = [
            'model' => $data,
            'worksheet' => $worksheet,
            'part' => $part,
        ];
        $pdf = Pdf::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }
}
