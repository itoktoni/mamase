<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\LocationCategoryEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class LocationCategory extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, LocationCategoryEntity, OptionTrait, ActiveTrait;

    protected $table = 'location_category';
    protected $primaryKey = 'location_category_id';

    protected $fillable = [
        'location_category_id',
        'location_category_name',
        'location_category_description',
    ];

    public $sortable = [
        'location_category_name',
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
            DataBuilder::build($this->field_primary())->name('ID')->show(false),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
            DataBuilder::build($this->field_description())->name('Description'),
        ];
    }
}
