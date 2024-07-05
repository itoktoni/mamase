<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\DistributionEntity;
use App\Dao\Entities\ReceiveEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Distribution extends Model
{
    use Sortable, FilterQueryString, PowerJoins, Sanitizable, DataTableTrait, DistributionEntity, OptionTrait, ActiveTrait;

    protected $table = 'distribution';
    protected $primaryKey = 'distribution_id';

    protected $fillable = [
        'distribution_id',
        'distribution_name',
        'distribution_qty',
        'distribution_waste',
        'distribution_date',
        'distribution_request_code',
        'distribution_sparepart_id',
        'distribution_location_from',
        'distribution_location_to',
        'distribution_description',
    ];

    public $sortable = [
        'distribution_name',
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
            DataBuilder::build($this->field_primary())->name('ID'),
            DataBuilder::build($this->field_date())->name('Tanggal'),
            DataBuilder::build($this->field_name())->name('Nama Penerima'),
            DataBuilder::build(Sparepart::field_name())->name('Nama Sparepart')->sort(),
        ];
    }

    public function has_sparepart(){
        return $this->hasOne(Sparepart::class, Sparepart::field_primary(), self::field_sparepart_id());
    }

    public function has_from(){
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_from());
    }

    public function has_to(){
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_to());
    }

    public function has_request(){
        return $this->hasOne(Request::class, Request::field_primary(), self::field_request_id());
    }
}
