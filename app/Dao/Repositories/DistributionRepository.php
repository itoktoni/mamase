<?php

namespace App\Dao\Repositories;

use App\Dao\Enums\CategoryRequestType;
use App\Dao\Enums\RequestStatusType;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Distribution;
use Illuminate\Support\Facades\DB;

class DistributionRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new Distribution() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model->select($this->model->getSelectedField())
            ->addSelect('to.location_name as location_name')
            ->leftJoinRelationship('has_request')
            ->leftJoinRelationship('has_sparepart')
            ->leftJoinRelationship('has_from', 'from')
            ->leftJoinRelationship('has_to', 'to')
            ->orderBy($this->model->getKeyName(), 'desc');

            // dd($query->showSql());

        // dd($query->showSql());

        $query = env('PAGINATION_SIMPLE') ? $query->simplePaginate(env('PAGINATION_NUMBER')) : $query->paginate(env('PAGINATION_NUMBER'));

        return $query;
    }
}
