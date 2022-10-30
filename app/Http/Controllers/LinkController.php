<?php

namespace App\Http\Controllers;

use App\Dao\Entities\SystemMenuEntity;
use App\Dao\Enums\BooleanType;
use App\Dao\Enums\MenuType;
use App\Dao\Models\Groups;
use App\Dao\Models\Menus;
use App\Dao\Models\SystemLink;
use App\Dao\Repositories\LinkRepository;
use App\Dao\Repositories\MenuRepository;
use App\Http\Requests\LinkRequest;
use App\Http\Requests\RoutesRequest;
use App\Http\Requests\SortRequest;
use App\Http\Services\CreateRoutesService;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateMenuService;
use App\Http\Services\UpdateRoutesService;
use App\Http\Services\UpdateService;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Plugins\Helper;
use Plugins\Response;
use Plugins\Template;

class LinkController extends MasterController
{
    public function __construct(LinkRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm()
    {
        $status = BooleanType::getOptions();
        $type = MenuType::getOptions();
        $link = SystemLink::getOptions();

        $files = Helper::getControllerFile();

        self::$share = [
            'status' => $status,
            'type' => $type,
            'model' => false,
            'link' => $link,
            'file' => $files,
        ];
    }

    public function postCreate(LinkRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, LinkRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);

        $data = $this->get($code);
        $action = Helper::getFunction($data->field_controller, $data->field_primary) ?? [];

        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $data,
            'action' => $action
        ]));
    }
}
