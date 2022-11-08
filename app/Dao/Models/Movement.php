<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\MovementEntity;
use App\Dao\Enums\MovementStatus;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\ExcelTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Ramsey\Uuid\Uuid;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Wildside\Userstamps\Userstamps;

class Movement extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, MovementEntity, Userstamps, ActiveTrait, PowerJoins, OptionTrait, ExcelTrait;

    protected $table = 'movement';
    protected $primaryKey = 'movement_code';
    protected $with = ['has_location', 'has_location_old'];

    protected $fillable = [
        'movement_code',
        'movement_description',
        'movement_action',
        'movement_date',
        'movement_product_id',
        'movement_vendor_id',
        'movement_location_old',
        'movement_location_new',
        'movement_status',
        'movement_type',
        'movement_created_at',
        'movement_created_by',
        'movement_updated_at',
        'movement_updated_by',
        'movement_requested_at',
        'movement_requested_name',
        'movement_requested_by',
        'movement_approved_at',
        'movement_approved_by',
    ];

    public $sortable = [
        'movement_code',
        'movement_date',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = true;
    public $incrementing = false;

    const CREATED_AT = 'movement_created_at';
    const UPDATED_AT = 'movement_updated_at';

    const CREATED_BY = 'movement_created_by';
    const UPDATED_BY = 'movement_updated_by';

    public function fieldSearching()
    {
        return $this->field_primary();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Code')->sort()->excel(),
            DataBuilder::build($this->field_date())->name('Tanggal')->excel(),
            DataBuilder::build($this->field_type())->name('Type')->show(false)->class('column-active text-center')->excel(),
            DataBuilder::build($this->field_requested_name())->name('Keterangan Alat')->sort()->excel(),
            DataBuilder::build($this->field_location_new())->name('Nama New')->show(false)->sort()->excel(),
            DataBuilder::build($this->field_location_old())->name('Nama Old')->show(false)->sort()->excel(),
            DataBuilder::build(Product::field_name())->name('Nama Alat')->sort()->excel(),
            DataBuilder::build(Supplier::field_name())->name('Supplier Name')->show(false)->sort()->excel(),
            DataBuilder::build($this->field_description())->name('Keterangan')->excel(),
            DataBuilder::build($this->field_action())->name('Action')->excel()->show(false),
        ];
    }

    public function has_user()
    {
        return $this->hasOne(User::class, User::field_primary(), self::field_requested_by());
    }

    public function has_product()
    {
        return $this->hasOne(Product::class, Product::field_primary(), self::field_product_id());
    }

    public function has_location()
    {
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_new());
    }

    public function has_vendor()
    {
        return $this->hasOne(Supplier::class, Supplier::field_primary(), self::field_vendor_id());
    }

    public function has_location_old()
    {
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_old());
    }

    public function nameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(User::field_name(), $direction);
        return $query;
    }

    public function productNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Product::field_name(), $direction);
        return $query;
    }

    /*
    using model event
    https://coderflex.com/blog/how-to-use-model-observers-in-laravel
     */

    public static function boot()
    {
        parent::creating(function ($model) {
            $model->{self::field_primary()} = Uuid::uuid1()->toString();

            try {
                $model->{self::field_requested_by()} = auth()->user()->{User::field_primary()};
            } catch (\Exception$e) {}

            $model->{self::field_requested_at()} = date('Y-m-d h:i:s');

            // AMBIL DATA LOKASI DI PRODUCT
            $product = Product::find($model->{self::field_product_id()});
            $model->{self::field_location_old()} = $product->{Product::field_location_id()};

            if (empty($model->{self::field_status()})) {
                $model->{self::field_status()} = MovementStatus::Pending;
            }
        });

        parent::saving(function ($model) {
            if (!empty($model->{self::field_approved_by()})) {
                $model->{self::field_primary()} = null;
            } elseif ($model->{self::field_status()} == MovementStatus::Approve || $model->{self::field_status()} == MovementStatus::Reject) {
                try {
                    $model->{self::field_approved_by()} = auth()->user()->{User::field_primary()};
                } catch (\Exception$e) {
                    $model->{self::field_approved_by()} = 1;
                }
                $model->{self::field_approved_at()} = date('Y-m-d h:i:s');
            }
        });

        parent::saved(function ($model) {
            if ($model->{self::field_status()} == MovementStatus::Approve) {
                // GANTI LOKASI YANG ADA DI TABLE PRODUCT
                $product = Product::find($model->{self::field_product_id()});
                $product->{Product::field_location_id()} = $model->{self::field_location_new()};
                $product->save();
            }
        });

        parent::boot();
    }
}
