<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\WorkTypeEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class WorkType extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, WorkTypeEntity, ActiveTrait, OptionTrait;

    protected $table = 'work_type';
    protected $primaryKey = 'work_type_id';

    protected $fillable = [
        'work_type_id',
        'work_type_name',
    ];

    public $sortable = [
        'work_type_name',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function fieldSearching()
    {
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('ID'),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
        ];
    }
}
