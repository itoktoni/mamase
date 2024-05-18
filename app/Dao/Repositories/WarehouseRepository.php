<?php

namespace App\Dao\Repositories;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Warehouse;

class WarehouseRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new Warehouse() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model
            ->select($this->model->getSelectedField())
            ->leftJoinRelationship('has_sparepart')
            ->leftJoinRelationship('has_location')
            ->leftJoinRelationship('has_location.has_building')
            ->sortable()->filter();

        $query = env('PAGINATION_SIMPLE') ? $query->simplePaginate(env('PAGINATION_NUMBER')) : $query->paginate(env('PAGINATION_NUMBER'));

        return $query;
    }

    public function getReport()
    {
        $query = $this->model->select('*')
            ->leftJoinRelationship('has_location')
            ->leftJoinRelationship('has_sparepart')
            ->leftJoinRelationship('has_sparepart.has_category')
            ;

        return $query;
    }
}
