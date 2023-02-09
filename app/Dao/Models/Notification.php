<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\NotificationEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Notification extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, NotificationEntity, OptionTrait, PowerJoins, ActiveTrait;

    protected $table = 'notification';
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'notification_id',
        'notification_name',
        'notification_description',
        'notification_phone',
        'notification_status',
        'notification_created_at',
        'notification_created_by',
        'notification_updated_at',
        'notification_updated_by',
        'notification_eta',
        'notification_etd',
        'notification_image',
        'notification_type',
        'notification_error',
    ];

    public $sortable = [
        'notification_name',
    ];

    protected $filters = [
        'filter',
    ];

    protected $casts = [
        'route_report' => 'integer'
    ];

    public $timestamps = true;
    public $incrementing = true;

    const CREATED_AT = 'notification_created_at';
    const UPDATED_AT = 'notification_updated_at';
    const CREATED_BY = 'notification_created_by';
    const UPDATED_BY = 'notification_updated_by';

    public function fieldSearching()
    {
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Code')->show(false),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
            DataBuilder::build($this->field_description())->width(100)->name('Description'),
        ];
    }
}
