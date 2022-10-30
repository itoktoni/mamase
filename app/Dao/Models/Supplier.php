<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\SupplierEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Supplier extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, SupplierEntity, ActiveTrait, OptionTrait;

    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_id',
        'supplier_name',
        'supplier_contact',
        'supplier_address',
        'supplier_email',
        'supplier_phone',
    ];

    public $sortable = [
        'supplier_name',
        'supplier_email',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function fieldSearching(){
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('ID')->show(false),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
            DataBuilder::build($this->field_contact())->name('Contact'),
            DataBuilder::build($this->field_address())->name('Address'),
            DataBuilder::build($this->field_email())->name('Email')->sort(),
            DataBuilder::build($this->field_phone())->name('Phone'),
        ];
    }
}