<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\StockEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Stock extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, StockEntity, OptionTrait, ActiveTrait;

    protected $table = 'stock';
    protected $primaryKey = 'stock_id';

    protected $fillable = [
        'stock_id',
        'stock_awal',
        'stock_perubahan',
        'stock_akhir',
        'stock_sparepart_id',
        'stock_location_id',
        'stock_date',
        'stock_description',
    ];

    public $sortable = [
        'stock_awal',
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
            DataBuilder::build($this->field_active())->name('Active')->show(false),
        ];
    }

    public function has_sparepart(){
        return $this->hasOne(Sparepart::class, Sparepart::field_primary(), self::field_sparepart_id());
    }

    public function has_location(){
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_id());
    }
}
