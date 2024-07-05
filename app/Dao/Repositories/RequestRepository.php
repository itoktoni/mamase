<?php

namespace App\Dao\Repositories;

use App\Dao\Enums\RoleType;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Request;

class RequestRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new Request() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model
            ->select($this->model->getSelectedField())
            ->leftJoinRelationship('has_user')
            ->active()->sortable()->filter();

            if(auth()->user()->type < RoleType::Admin){
                $query = $query->where('request_created_by', auth()->user()->id);
            }

            $query->orderBy('request_created_at', 'DESC');

        $query = env('PAGINATION_SIMPLE') ? $query->simplePaginate(env('PAGINATION_NUMBER')) : $query->paginate(env('PAGINATION_NUMBER'));

        return $query;
    }
}
