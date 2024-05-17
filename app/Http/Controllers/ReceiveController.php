<?php

namespace App\Http\Controllers;

use App\Dao\Models\Receive;
use App\Dao\Models\Request;
use App\Dao\Models\Sparepart;
use App\Dao\Repositories\ReceiveRepository;
use App\Http\Requests\ReceiveRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;
use App\Http\Services\DeleteReceiveService;
use App\Http\Services\UpdateReceiveService;
use Barryvdh\DomPDF\Facade\Pdf;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Template;

class ReceiveController extends MasterController
{
    public function __construct(ReceiveRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function postCreate(ReceiveRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, ReceiveRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getReceive($code, $id)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);

        $data = Request::with(['has_receive', 'has_receive.has_location', 'has_receive.has_sparepart'])->find($code);
        $sparepart = Sparepart::leftJoin('work_sheet_sparepart', 'work_sheet_sparepart.sparepart_id', '=', 'sparepart.sparepart_id')
            ->where('work_sheet_sparepart.request_code', $code)
            ->where('work_sheet_sparepart.sparepart_id', $id)
            ->first();

        $location = Query::getLocation();

        $request = [];

        if($data){
            $request = $data->has_receive ?? [];
        }

        return view(Template::form(SharedData::get('template'), 'receive'))->with($this->share([
            'model' => $data,
            'request' => $request,
            'location' => $location,
            'sparepart' => $sparepart,
        ]));
    }

    public function postReceive($code, ReceiveRequest $request, UpdateReceiveService $service)
    {
        $data = $service->update($request, $code);
        return Response::redirectBack($data);
    }

    public function getDeleteReceive($code, DeleteReceiveService $service)
    {
        $data = $service->delete($code);
        return Response::redirectBack($data);
    }

    public function getPrint($code)
    {
        $data = Receive::with([
            'has_request',
            'has_sparepart',
        ])->find($code);

        $share = [
            'model' => $data,
        ];
        $pdf = Pdf::loadView(Template::print(SharedData::get('template')), $share);
        return $pdf->stream();
    }

}
