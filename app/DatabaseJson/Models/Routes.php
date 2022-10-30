<?php

namespace App\DatabaseJson\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\RoutesEntity;
use App\Dao\Enums\BooleanType;
use App\Dao\Traits\DataTableTrait;
use DatabaseJson\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable;

class Routes extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, RoutesEntity;

    protected $table = 'routes';
    protected $primaryKey = 'route_code';
    protected $connection = 'sqlite';

    protected $fillable = [
        'route_code',
        'route_name',
        'route_group',
        'route_active',
        'route_controller',
        'route_description',
    ];

    public $sortable = [
        'route_name',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function fieldSearching()
    {
        return 'route_name';
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build('id')->name('ID')->show(false),
            DataBuilder::build('route_group')->name('Group'),
            DataBuilder::build('route_name')->name('Name'),
            DataBuilder::build('route_code')->name('Slug'),
            DataBuilder::build('route_active')->name('Active')->show(false),
            DataBuilder::build('route_description')->name('Description')->show(false),
            DataBuilder::build('route_controller')->name('Controller'),
        ];
    }
}
