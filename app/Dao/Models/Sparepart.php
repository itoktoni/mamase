<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\SparepartEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;

class Sparepart extends Model
{
    use Sortable, FilterQueryString, DataTableTrait, SparepartEntity, ActiveTrait, PowerJoins, OptionTrait;

    protected $table = 'sparepart';
    protected $primaryKey = 'sparepart_id';

    protected $fillable = [
        'sparepart_id',
        'sparepart_name',
        'sparepart_category_id',
        'sparepart_description',
        'sparepart_stock',
        'sparepart_product_id',
    ];

    public $sortable = [
        'sparepart_name',
        'sparepart_stock',
        'product.product_name',
    ];

    protected $filters = [
        'filter',
        'sparepart_category_id',
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
            DataBuilder::build(self::field_primary())->name('ID')->show(false),
            DataBuilder::build(Category::field_name())->name('Category'),
            DataBuilder::build(self::field_name())->name('Sparepart')->sort(),
            DataBuilder::build(Product::field_name())->name('Product')->sort(),
            DataBuilder::build(self::field_description())->name('Description'),
            DataBuilder::build(self::field_stock())->name('Stock')->class('column-active')->show(false),
        ];
    }

    public function has_category()
    {
        return $this->hasOne(Category::class, Category::field_primary(), self::field_category_id());
    }

    public function has_product()
    {
        return $this->hasOne(Product::class, Product::field_primary(), self::field_product_id());
    }

    public function productNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Product::field_name(), $direction);
        return $query;
    }

}
