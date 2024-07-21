<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\LocationEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Location extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, LocationEntity, OptionTrait, PowerJoins, ActiveTrait;

    protected $table = 'location';
    protected $primaryKey = 'location_id';
    protected $with = ['has_building', 'has_floor'];

    protected $fillable = [
        'location_id',
        'location_name',
        'location_description',
        'location_building_id',
        'location_floor_id',
        'location_pic_user_id',
        'location_phone',
        'location_jenis_layanan',
    ];

    public $sortable = [
        'location_name',
        'building.building_name',
        'floor.floor_name',
        'users.name',
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
            DataBuilder::build($this->field_primary())->name('Code'),
            DataBuilder::build(Building::field_name())->name('Building')->show(false)->sort(),
            DataBuilder::build(Floor::field_name())->name('Floor')->show(false)->sort(),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
            DataBuilder::build($this->field_jenis_layanan())->name('Jenis Layanan')->sort(),
            DataBuilder::build(User::field_name())->name('PIC')->sort(),
        ];
    }

    public function has_user()
    {
        return $this->hasOne(User::class, User::field_primary(), self::field_pic_user_id());
    }

    public function has_building()
    {
        return $this->hasOne(Building::class, Building::field_primary(), self::field_building_id());
    }

    public function has_floor()
    {
        return $this->hasOne(Floor::class, Floor::field_primary(), self::field_floor_id());
    }

    public function has_product()
    {
        return $this->hasMany(Product::class, Product::field_location_id(), self::field_primary());
    }

    public function has_check()
    {
        return $this->hasMany(Product::class, Product::field_location_id(), self::field_primary())
            ->where(Product::field_checked(), 1);
    }

    public function buildingNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Building::field_name(), $direction);
        return $query;
    }

    public function floorNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Floor::field_name(), $direction);
        return $query;
    }

    public function has_products()
    {
        return $this->belongsToMany(Product::class, 'location_product', 'location_id', 'product_id');
    }
}
