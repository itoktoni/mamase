<?php

namespace App\Dao\Repositories;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Sparepart;

class SparepartRepository extends MasterRepository implements CrudInterface
{
    public $model;

    public function __construct()
    {
        $this->model = empty($this->model) ? new Sparepart() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model
            ->select($this->model->getSelectedField())
            ->addSelect(['qty'])
            ->leftJoinRelationship('has_category')
            ->leftJoinRelationship('has_product')
            ->leftJoin('view_qty', 'warehouse_sparepart_id', 'sparepart_id')
            ->sortable()->filter();

        $query = $query->paginate(env('PAGINATION_NUMBER'));

        return $query;
    }
}
