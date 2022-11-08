<?php

namespace App\Http\Controllers;

use App\Dao\Models\User;
use App\Dao\Repositories\TicketTopicRepository;
use App\Http\Controllers\MasterController;
use App\Http\Requests\TicketTopicRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use App\Http\Services\UpdateTicketTopicService;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Query;
use Plugins\Response;
use Plugins\Template;

class TicketTopicController extends MasterController
{
    public function __construct(TicketTopicRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function postCreate(TicketTopicRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, TicketTopicRequest $request, UpdateTicketTopicService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    protected function beforeForm()
    {
        $user = Query::getUserWhatsapp();
        self::$share = [
            'user' => $user,
        ];
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);

        $data = $this->get($code, ['has_user']);
        $selected = $data->has_user->pluck('id') ?? [];

        return view(Template::form(SharedData::get('template')))->with($this->share([
            'model' => $data,
            'selected' => $selected,
        ]));
    }
}
