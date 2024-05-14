<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\CategoryEntity;
use App\Dao\Entities\ModelEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class ProductModel extends Model
{
    use Sortable, FilterQueryString, PowerJoins, Sanitizable, DataTableTrait, ModelEntity, OptionTrait, ActiveTrait;

    protected $table = 'product_model';
    protected $primaryKey = 'model_id';

    protected $fillable = [
        'model_id',
        'model_group',
        'model_code',
        'model_name',
        'model_image',
        'model_type_id',
        'model_brand_id',
        'model_unit_id',
        'model_category_id',
        'model_tech',
        'model_description',
    ];

    public $sortable = [
        'model_name',
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
            DataBuilder::build(Category::field_name())->name('Kategori')->sort(),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
            DataBuilder::build(ProductType::field_name())->name('Tipe')->show(false),
            DataBuilder::build(ProductModel::field_name())->name('Model')->show(false)->sort(),
            DataBuilder::build(Brand::field_name())->name('Merek')->show(false),
        ];
    }

    public function has_category(){

		return $this->hasOne(Category::class, Category::field_primary(), self::field_category_id());
    }

    public function has_type(){

		return $this->hasOne(ProductType::class, ProductType::field_primary(), self::field_category_id());
    }

    public function has_brand(){

		return $this->hasOne(Brand::class, Brand::field_primary(), self::field_brand_id());
    }

    public function has_unit(){

		return $this->hasOne(Unit::class, Unit::field_primary(), self::field_unit_id());
    }
}
