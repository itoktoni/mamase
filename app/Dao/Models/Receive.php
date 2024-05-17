<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\CategoryEntity;
use App\Dao\Entities\ReceiveEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Receive extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ReceiveEntity, OptionTrait, ActiveTrait;

    protected $table = 'receive';
    protected $primaryKey = 'receive_id';

    protected $fillable = [
        'receive_id',
        'receive_name',
        'receive_ask',
        'receive_qty',
        'receive_date',
        'receive_request_code',
        'receive_sparepart_id',
        'receive_location_id',
        'receive_description',
    ];

    public $sortable = [
        'receive_name',
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
            DataBuilder::build(Request::field_primary())->name('Request Kode')->sort(),
        ];
    }

    public function has_sparepart(){
        return $this->hasOne(Sparepart::class, Sparepart::field_primary(), self::field_sparepart_id());
    }

    public function has_location(){
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_id());
    }

    public function has_request(){
        return $this->hasOne(Request::class, Request::field_primary(), self::field_request_id());
    }
}
