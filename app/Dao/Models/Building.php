<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\BuildingEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;

class Building extends Model
{
    use Sortable, FilterQueryString, DataTableTrait, BuildingEntity, ActiveTrait, OptionTrait;

    protected $table = 'building';
    protected $primaryKey = 'building_id';

    protected $fillable = [
        'building_id',
        'building_name',
        'building_description',
        'building_contact_person',
        'building_contact_phone',
        'building_address',
        'building_luas_bangunan',
        'building_tahun_pendirian',
        'building_tahun_renovasi',
        'building_sumber_anggaran',
        'building_nilai_anggaran',
        'building_basement',
        'building_jumlah_lantai',
        'building_nomer_imb',
        'building_nomer_ipb',
    ];

    public $sortable = [
        'building_name',
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
            DataBuilder::build($this->field_jumlah_lantai())->name('Lantai'),
            DataBuilder::build($this->field_basement())->name('Basement'),
            DataBuilder::build($this->field_address())->name('Address'),
            DataBuilder::build($this->field_description())->name('Description'),
        ];
    }
}
