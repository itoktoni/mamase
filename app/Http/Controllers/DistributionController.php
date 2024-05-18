<?php

namespace App\Http\Controllers;

use App\Dao\Models\Distribution;
use App\Dao\Models\Location;
use App\Dao\Models\Receive;
use App\Dao\Models\Request;
use App\Dao\Models\Sparepart;
use App\Dao\Models\User;
use App\Dao\Repositories\DistributionRepository;
use App\Http\Requests\DistributionRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Plugins\Response;
use App\Http\Controllers\MasterController;
use App\Http\Services\CreateDistributionService;
use App\Http\Services\DeleteDistributionService;
use App\Http\Services\UpdateDistributionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Template;

class DistributionController extends MasterController
{
    public function __construct(DistributionRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $user = User::getOptions();
        $sparepart = Sparepart::getOptions();
        $location = Location::getOptions();

        $name = null;
        if($code = request()->get('code')){
            $name = Request::find($code)->field_name ?? null;
        }

        self::$share = [
            'location' => $location,
            'sparepart' => $sparepart,
            'user' => $user,
            'name' => $name,
        ];
    }

    public function postCreate(DistributionRequest $request, CreateDistributionService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, DistributionRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getDistribution($code, $id)
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

    public function postDistribution($code, DistributionRequest $request, UpdateDistributionService $service)
    {
        $data = $service->update($request, $code);
        return Response::redirectBack($data);
    }

    public function getDeleteDistribution($code, DeleteDistributionService $service)
    {
        $data = $service->delete($code);
        return Response::redirectBack($data);
    }

    public function getPrint($code)
    {
        $data = Distribution::with([
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
