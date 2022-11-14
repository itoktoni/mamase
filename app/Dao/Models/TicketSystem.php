<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\TicketSystemEntity;
use App\Dao\Enums\TicketPriority;
use App\Dao\Enums\TicketStatus;
use App\Dao\Enums\WorkStatus;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\ExcelTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Ramsey\Uuid\Uuid;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Wildside\Userstamps\Userstamps;

class TicketSystem extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, TicketSystemEntity, Userstamps, ActiveTrait, PowerJoins, OptionTrait, SoftDeletes, ExcelTrait;

    protected $table = 'ticket_system';
    protected $primaryKey = 'ticket_system_code';
    protected $with = ['has_location'];

    protected $fillable = [
        'ticket_system_code',
        'ticket_system_topic_id',
        'ticket_system_location_id',
        'ticket_system_product_id',
        'ticket_system_work_type_id',
        'ticket_system_name',
        'ticket_system_description',
        'ticket_system_priority',
        'ticket_system_status',
        'ticket_system_implementor',
        'ticket_system_department_id',
        'ticket_system_reported_at',
        'ticket_system_reported_name',
        'ticket_system_reported_by',
        'ticket_system_picture',
        'ticket_system_assigned_at',
        'ticket_system_assigned_by',
        'ticket_system_checked_at',
        'ticket_system_checked_by',
        'ticket_system_created_at',
        'ticket_system_created_by',
        'ticket_system_updated_at',
        'ticket_system_updated_by',
        'ticket_system_deleted_at',
        'ticket_system_deleted_by',
        'ticket_system_finished_at',
        'ticket_system_finished_by',
        'ticket_system_schedule_id',
        'ticket_system_check',
        'ticket_system_action',
        'ticket_system_result',
    ];

    public $sortable = [
        'ticket_system_code',
        'ticket_system_priority',
        'ticket_system_topic_id',
        'ticket_system_department_id',
    ];

    protected $filters = [
        'filter',
        'ticket_system_department_id',
        'ticket_system_ticket_id',
        'date',
        'ticket_system_work_type_id',
        'start_date',
        'end_date',
    ];

    public $timestamps = true;
    public $incrementing = false;

    const CREATED_AT = 'ticket_system_created_at';
    const UPDATED_AT = 'ticket_system_updated_at';
    const DELETED_AT = 'ticket_system_deleted_at';

    const CREATED_BY = 'ticket_system_created_by';
    const UPDATED_BY = 'ticket_system_updated_by';
    const DELETED_BY = 'ticket_system_deleted_by';

    public function fieldSearching()
    {
        return $this->field_primary();
    }

    public function date($query){
        $date = request()->get('date');
        if($date){
            $query = $query->where($this->field_reported_at(), $date);
        }

        return $query;
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_reported_name())->name(__('Laporan'))->sort()->excel(),
            DataBuilder::build(WorkType::field_name())->name(__('Type'))->sort()->excel(),
            DataBuilder::build(Location::field_name())->name(__('Ruangan'))->sort()->show(true)->excel(),
            DataBuilder::build($this->field_product_id())->name(__('Description'))->show(false)->excel(),
            DataBuilder::build($this->field_description())->name(__('Description'))->show()->excel(),
            DataBuilder::build($this->field_status())->name(__('Status'))->sort()->excel(),
        ];
    }

    public function has_category()
    {
        return $this->hasOne(TicketTopic::class, TicketTopic::field_primary(), self::field_topic_id());
    }

    public function has_product()
    {
        return $this->hasOne(Product::class, Product::field_primary(), self::field_product_id());
    }

    public function has_department()
    {
        return $this->hasOne(Department::class, Department::field_primary(), self::field_department_id());
    }

    public function has_location()
    {
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_id());
    }

    public function has_reported()
    {
        return $this->hasOne(User::class, User::field_primary(), self::field_reported_by());
    }

    public function has_worksheet()
    {
        return $this->hasMany(WorkSheet::class, WorkSheet::field_ticket_code(), self::field_primary());
    }

    public function has_type()
    {
        return $this->hasOne(WorkType::class, WorkType::field_primary(), self::field_work_type_id());
    }

    public function ticketTopicNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(TicketTopic::field_name(), $direction);
        return $query;
    }

    public function departmentNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Department::field_name(), $direction);
        return $query;
    }

    /*
    using model event
    https://coderflex.com/blog/how-to-use-model-observers-in-laravel
     */

    public static function boot()
    {
        parent::creating(function ($model) {

            if (empty($model->{self::field_status()})) {
                $model->{self::field_status()} = TicketStatus::Open; $model->{self::field_reported_by()} = auth()->user()->id;
            }

            if (empty($model->{self::field_priority()})) {
                $model->{self::field_priority()} = TicketPriority::Low;
            }

            $reported_by = null;
            if (empty($model->{self::field_reported_by()})) {
                $reported_by = $model->{self::field_reported_by()} = auth()->user()->id;
            }

            if (empty($model->{self::field_reported_name()})) {
                $user = User::find($reported_by);
                $model->{self::field_reported_name()} = $user->field_name ?? '';
            }

            $model->{self::field_primary()} = Uuid::uuid1()->toString();

        });

        parent::saving(function ($model) {
            if ($model->{self::field_status()} == TicketStatus::Finish) {
                $model->{self::field_finished_by()} = auth()->user()->id;
                $model->{self::field_finished_at()} = date('Y-m-d H:i:s');

                $relation = $model->has_worksheet;
                $relation = $model->has_worksheet()->update([
                    WorkSheet::field_status() => WorkStatus::Close,
                    WorkSheet::field_finished_at() => date('Y-m-d H:i:s'),
                ]);
            }

            if (request()->has('file_picture')) {
                $file_logo = request()->file('file_picture');
                $extension = $file_logo->getClientOriginalExtension();
                $name = time() . '.' . $extension;
                $file_logo->storeAs('public/ticket/', $name);
                $model->{TicketSystem::field_picture()} = $name;
            }
        });

        parent::boot();
    }

}
