<?php

namespace App\Dao\Repositories;

use App\Dao\Enums\RoleType;
use App\Dao\Enums\UserType;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\TicketSystem;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Plugins\Query;

class TicketSystemRepository extends MasterRepository implements CrudInterface, FromCollection
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new TicketSystem() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model->with([
            'has_location',
            'has_location.has_floor',
            'has_location.has_building',
            'has_product',
            ])->select('*')
            ->addSelect(self::$paginate ? $this->model->getExcelField() : $this->model->getSelectedField())
            ->leftJoinRelationship('has_category')
            ->leftJoinRelationship('has_location')
            ->leftJoinRelationship('has_reported')
            ->sortable()->orderBy(TicketSystem::CREATED_AT, 'DESC')
            ->filter();

        if(Auth::user()->type == RoleType::Pengguna){
            $query = $query->where(TicketSystem::field_reported_by(), Auth::user()->id);
        }

        if(self::$paginate){
            $query = env('PAGINATION_SIMPLE') ? $query->simplePaginate(env('PAGINATION_NUMBER')) : $query->paginate(env('PAGINATION_NUMBER'));
        }

        return $query;
    }

    public function excel($name)
    {
        $this->model->selected_field = 'excel';
        $data = $this->setDisablePaginate()->dataRepository();
        return $this->model->export($data, $name);
    }

    public function collection()
    {
        return $this->setDisablePaginate()->dataRepository()->get();
    }

    public function getTicketByCode($id)
    {
        return $this->model->find($id);
    }
}
