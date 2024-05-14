<?php

namespace App\Dao\Repositories;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\Product;

class ProductRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new Product() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model->select($this->model->getSelectedField())
            ->leftJoinRelationship('has_location')
            ->leftJoinRelationship('has_model.has_category')
            ->leftJoinRelationship('has_model.has_type')
            ->leftJoinRelationship('has_model.has_brand')
            ->leftJoinRelationship('has_model.has_unit')
            ->active()->sortable()->filter();
            if(self::$paginate){
                $query = $query->paginate(env('PAGINATION_NUMBER'));
            }

        return $query;
    }
}