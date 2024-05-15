<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\CategoryEntity;
use App\Dao\Entities\WarehouseEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Warehouse extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, PowerJoins, WarehouseEntity, OptionTrait, ActiveTrait;

    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_sparepart_id';

    protected $fillable = [
        'warehouse_sparepart_id',
        'warehouse_location_id',
        'warehouse_qty',
        'warehouse_description',
    ];

    public $sortable = [
        'warehouse_description',
    ];

    protected $casts = [
        'warehouse_sparepart_id' => 'integer',
        'warehouse_location_id' => 'integer',
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
            DataBuilder::build($this->field_primary())->name('ID')->show(false),
            DataBuilder::build(Sparepart::field_name())->name('Sparepart')->sort(),
            DataBuilder::build(Location::field_name())->name('Lokasi')->sort(),
            DataBuilder::build(Warehouse::field_qty())->name('Qty')->sort(),
            DataBuilder::build(Building::field_name())->name('Building')->show(false),
            DataBuilder::build($this->field_description())->name('Description')->show(false),
        ];
    }

    public function has_sparepart(){
        return $this->hasOne(Sparepart::class, Sparepart::field_primary(), $this->field_sparepart_id());
    }

    public function has_location(){
        return $this->hasOne(Location::class, Location::field_primary(), $this->field_location_id());
    }
}
