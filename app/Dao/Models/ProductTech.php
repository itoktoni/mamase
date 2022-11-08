<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\BrandEntity;
use App\Dao\Entities\ProductEntity;
use App\Dao\Entities\ProductTechEntity;
use App\Dao\Entities\ProductTypeEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class ProductTech extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ProductTechEntity, ActiveTrait, OptionTrait;

    protected $table = 'product_tech';
    protected $primaryKey = 'product_tech_id';

    protected $fillable = [
        'product_tech_id',
        'product_tech_name',
        'product_tech_description',
    ];

    public $sortable = [
        'product_tech_name',
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
            DataBuilder::build($this->field_primary())->name('Code')->show(false),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
            DataBuilder::build($this->field_description())->name('Description'),
        ];
    }
}
