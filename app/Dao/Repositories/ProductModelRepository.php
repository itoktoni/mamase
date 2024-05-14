<?php

namespace App\Dao\Repositories;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\ProductModel;

class ProductModelRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new ProductModel() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model
            ->select($this->model->getSelectedField())
            ->leftJoinRelationship('has_category')
            ->leftJoinRelationship('has_brand')
            ->leftJoinRelationship('has_type')
            ->active()->sortable()->filter();

        $query = $query->paginate(env('PAGINATION_NUMBER'));

        return $query;
    }

}
