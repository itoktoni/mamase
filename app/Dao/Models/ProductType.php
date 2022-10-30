<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\BrandEntity;
use App\Dao\Entities\ProductEntity;
use App\Dao\Entities\ProductTypeEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class ProductType extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ProductTypeEntity, ActiveTrait, OptionTrait;

    protected $table = 'product_type';
    protected $primaryKey = 'product_type_id';

    protected $fillable = [
        'product_type_id',
        'product_type_name',
        'product_type_description',
    ];

    public $sortable = [
        'product_type_name',
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
