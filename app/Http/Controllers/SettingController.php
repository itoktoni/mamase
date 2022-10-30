<?php

namespace App\Http\Controllers;

use App\Dao\Enums\BooleanType;
use App\Dao\Models\WorkType;
use App\Http\Requests\SettingRequest;
use App\Http\Services\CreateSettingService;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Response;
use Plugins\Template;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    protected function share($data = [])
    {
        $status = BooleanType::getOptions();
        $type = WorkType::getOptions();

        $view = [
            'status' => $status,
            'type' => $type,
            'model' => false,
        ];
        return array_merge($view, $data);
    }

    public function getCreate()
    {
        return view(Template::form(SharedData::get('template')))->with($this->share());
    }

    public function postCreate(SettingRequest $request, CreateSettingService $service)
    {
        $data = $service->save($request);
        return Response::redirectBack($data);
    }
}
