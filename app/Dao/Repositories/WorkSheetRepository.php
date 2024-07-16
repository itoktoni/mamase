<?php

namespace App\Dao\Repositories;

use App\Dao\Enums\KontrakType;
use App\Dao\Enums\RoleType;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\WorkSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Plugins\Query;
use Plugins\Template;

class WorkSheetRepository extends MasterRepository implements CrudInterface, FromCollection
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new WorkSheet() : $this->model;
    }

    public function dataRepository()
    {
        $query = $this->model->select('*')
            ->with([
                'has_vendor',
                'has_implementor',
                'has_ticket',
                'has_ticket.has_category',
                'has_location',
                'has_location.has_building',
                'has_location.has_floor',
            ])
            ->addSelect(self::$paginate ? $this->model->getExcelField() : $this->model->getSelectedField())
            ->leftJoinRelationship('has_ticket')
            ->leftJoinRelationship('has_product')
            ->leftJoinRelationship('has_implementor')
            ->leftJoinRelationship('has_vendor')
            ->sortable()
            ->orderBy(WorkSheet::CREATED_AT, 'DESC')
            ->filter();

        if(!Template::greatherAdmin()){
            if(Template::isVendor()){
                $query = $query->where(WorkSheet::field_vendor_id(), auth()->user()->vendor);
            }
            else{
                $query = $query->whereJsonContains(WorkSheet::field_implementor(), [auth()->user()->id]);
            }
        }
        else{
            $contract = request()->get('work_sheet_contract');
            if(!empty($contract)){
                if(request()->get('work_sheet_contract') == KontrakType::Kontrak){
                    $query = $query->where(WorkSheet::field_vendor_id(), request()->get('work_sheet_vendor_id'));
                }
                else if(request()->get('work_sheet_contract') == KontrakType::TidakKontrak){
                    $query = $query->whereIn(WorkSheet::field_implementor(), request()->get('teknisi'));
                }
            }
        }

        if(!empty(request()->get('ticket_system_topic_id'))){
            $query->where('ticket_system_topic_id', request()->get('ticket_system_topic_id'));
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
}