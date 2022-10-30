<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\FloorEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;

class Floor extends Model
{
    use Sortable, FilterQueryString, DataTableTrait, FloorEntity, ActiveTrait, OptionTrait;

    protected $table = 'floor';
    protected $primaryKey = 'floor_id';

    protected $fillable = [
        'floor_id',
        'floor_name',
        'floor_building_id',
        'floor_description',
    ];

    public $sortable = [
        'floor_name',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function filter($query, $value)
    {
        $search = request()->get('search');
        if ($search) {
            return $query->where($value ?? $this->fieldSearching(), 'like', "%{$search}%");
        }
    }

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
        ];
    }

    public function has_building()
    {
        return $this->hasOne(Building::class, Building::field_primary(), self::field_building_id());
    }
}
