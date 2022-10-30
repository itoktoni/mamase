<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\UnitEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Unit extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, UnitEntity, ActiveTrait,OptionTrait;

    protected $table = 'unit';
    protected $primaryKey = 'unit_code';

    protected $fillable = [
        'unit_code',
        'unit_name',
    ];

    public $sortable = [
        'unit_name',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = false;

    public function fieldSearching()
    {
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Code'),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
        ];
    }
}