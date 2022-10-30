<?php

namespace App\Http\Controllers;

use App\Dao\Enums\RoleType;
use App\Dao\Models\Roles;
use App\Dao\Models\SystemGroup;
use App\Dao\Models\SystemRole;
use App\Dao\Repositories\RolesRepository;
use App\Http\Requests\RolesRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateRoleService;
use App\Http\Services\UpdateService;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Response;
use Plugins\Template;

class RolesController extends MasterController
{
    public function __construct(RolesRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm(){

        $group = SystemGroup::getOptions();

        self::$share = [
            'group' => $group,
        ];
    }

    public function postCreate(RolesRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, RolesRequest $request, UpdateRoleService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);

        $data = $this->get($code, ['has_group']);
        $selected = $data->has_group->pluck('system_group_code') ?? [];

        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $data,
            'selected' => $selected,
        ]));
    }
}
