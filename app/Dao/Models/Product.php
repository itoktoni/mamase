<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\ProductEntity;
use App\Dao\Enums\BooleanType;
use App\Dao\Enums\KontrakType;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Plugins\Query;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Wildside\Userstamps\Userstamps;

class Product extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ProductEntity, Userstamps, SoftDeletes, ActiveTrait, PowerJoins, OptionTrait;

    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $with = ['has_location'];

    protected $fillable = [
        'product_id',
        'product_name',
        'product_serial_number',
        'product_internal_number',
        'product_auto_number',
        'product_image',
        'product_category_id',
        'product_type_id',
        'product_brand_id',
        'product_unit_code',
        'product_description',
        'product_location_id',
        'product_supplier_id',
        'product_department_id',
        'product_is_asset',
        'product_price',
        'product_buy_date',
        'product_prod_year',
        'product_acqu_year',
        'product_created_at',
        'product_updated_at',
        'product_deleted_at',
        'product_deleted_by',
        'product_updated_by',
        'product_created_by',
        'product_status',
        'product_tech_id',
        'product_contract',
        'product_vendor_id',
        'product_teknisi_data',
    ];

    public $sortable = [
        'product_name',
        'category.category_name',
        'search',
        'brand.brand_name',
        'unit.unit_name',
    ];

    protected $filters = [
        'filter',
    ];

    protected $casts = [
        'product_active' => 'integer',
    ];

    public $timestamps = true;
    public $incrementing = true;

    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';
    const DELETED_AT = 'product_deleted_at';

    const CREATED_BY = 'product_created_by';
    const UPDATED_BY = 'product_updated_by';
    const DELETED_BY = 'product_deleted_by';

    public function fieldSearching()
    {
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('ID')->show(false),
            DataBuilder::build($this->field_serial_number())->name('Serial Number')->show(true),
            DataBuilder::build(Category::field_name())->name('Category')->sort(),
            DataBuilder::build(ProductType::field_name())->name('Type')->sort(),
            DataBuilder::build(Brand::field_name())->name('Brand')->sort(),
            DataBuilder::build($this->field_name())->name('Product Name')->sort(),
            DataBuilder::build(Location::field_name())->name('Location')->sort(),
            DataBuilder::build($this->field_status())->name('Status')->class('column-active text-center'),
        ];
    }

    public function has_category(){

		return $this->hasOne(Category::class, Category::field_primary(), self::field_category_id());
    }

    public function has_tech(){

		return $this->hasOne(ProductTech::class, ProductTech::field_primary(), self::field_product_tech_id());
	}

    public function has_brand()
    {
		return $this->hasOne(Brand::class, Brand::field_primary(), self::field_brand_id());
    }

    public function has_type()
    {
		return $this->hasOne(ProductType::class, ProductType::field_primary(), self::field_type_id());
	}

    public function has_unit()
    {
		return $this->hasOne(Unit::class, Unit::field_primary(), self::field_unit_code());
	}

    public function has_location()
    {
		return $this->hasOne(Location::class, Location::field_primary(), self::field_location_id());
    }

    public function has_worksheet()
    {
		return $this->hasMany(WorkSheet::class, WorkSheet::field_product_id(), self::field_primary());
    }

    public function has_vendor()
    {
        return $this->hasOne(Supplier::class, Supplier::field_primary(), self::field_vendor_id());
    }

    public function has_teknisi()
    {
        return $this->hasOne(User::class, User::field_primary(), self::field_teknisi_data());
    }

    public function categoryNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Category::field_name(), $direction);
        return $query;
    }

    public function brandNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Brand::field_name(), $direction);
        return $query;
    }

    public function locationNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Location::field_name(), $direction);
        return $query;
    }

    public static function boot()
    {
        parent::creating(function($model){
            $model->{self::field_auto_number()} = Query::autoNumber($model->getTable(), self::field_auto_number(), date('Ymd'));
        });
        parent::saving(function ($model) {

            if (request()->has('file_picture')) {
                $file_logo = request()->file('file_picture');
                $extension = $file_logo->getClientOriginalExtension();
                $name = time() . '.' . $extension;
                $file_logo->storeAs('public/product/', $name);
                $model->{self::field_field_image()} = $name;
            }

            if ($model->{self::field_contract()} == KontrakType::Kontrak) {
                $model->{self::field_vendor_id()} = request()->get(self::field_vendor_id());
            } else {
                $teknisi = request()->get('teknisi') ?? null;
                $model->{self::field_teknisi_data()} = json_encode($teknisi);
            }

        });

        parent::boot();
    }

}
