<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\WorkSheetEntity;
use App\Dao\Enums\KontrakType;
use App\Dao\Enums\TicketStatus;
use App\Dao\Enums\WorkStatus;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\ExcelTrait;
use App\Dao\Traits\OptionTrait;
use App\Events\CreateWorkSheetEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Ramsey\Uuid\Uuid;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Wildside\Userstamps\Userstamps;

class WorkSheet extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, WorkSheetEntity, Userstamps, ActiveTrait, PowerJoins, OptionTrait, SoftDeletes, ExcelTrait;

    protected $table = 'work_sheet';
    protected $primaryKey = 'work_sheet_code';
    protected $with = ['has_vendor', 'has_implementor', 'has_ticket'];

    protected $casts = [
        'work_sheet_contract' => 'integer',
        'work_sheet_status' => 'integer',
        'work_sheet_type_id' => 'integer',
    ];

    protected $fillable = [
        'work_sheet_code',
        'work_sheet_type_id',
        'work_sheet_name',
        'work_sheet_description',
        'work_sheet_check',
        'work_sheet_action',
        'work_sheet_suggestion_id',
        'work_sheet_result',
        'work_sheet_picture',
        'work_sheet_contract',
        'work_sheet_vendor_id',
        'work_sheet_implementor',
        'work_sheet_check_at',
        'work_sheet_implement_at',
        'work_sheet_check_by',
        'work_sheet_implement_by',
        'work_sheet_ticket_code',
        'work_sheet_product_id',
        'work_sheet_location_id',
        'work_sheet_reported_at',
        'work_sheet_reported_name',
        'work_sheet_reported_by',
        'work_sheet_created_at',
        'work_sheet_created_by',
        'work_sheet_updated_at',
        'work_sheet_updated_by',
        'work_sheet_deleted_at',
        'work_sheet_deleted_by',
        'work_sheet_finished_at',
        'work_sheet_finished_by',
        'work_sheet_status',
        'work_sheet_product_fisik',
        'work_sheet_product_fungsi',
        'work_sheet_product_description',
        'work_sheet_schedule_id',
    ];

    public $sortable = [
        'work_sheet_code',
        'work_sheet_name',
        'work_sheet_type_id',
        'work_sheet_product_id',
        'work_sheet_ticket_code',
    ];

    protected $filters = [
        'filter',
        'work_sheet_product_id',
        'work_sheet_type_id',
        'start_date',
        'end_date',
    ];

    public $timestamps = true;
    public $incrementing = false;

    const CREATED_AT = 'work_sheet_created_at';
    const UPDATED_AT = 'work_sheet_updated_at';
    const DELETED_AT = 'work_sheet_deleted_at';

    const CREATED_BY = 'work_sheet_created_by';
    const UPDATED_BY = 'work_sheet_updated_by';
    const DELETED_BY = 'work_sheet_deleted_by';

    public function fieldSearching()
    {
        return $this->field_primary();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_ticket_code())->name(__('Ticket'))->sort()->excel(),
            DataBuilder::build($this->field_type_id())->name(__('Type'))->sort()->excel(),
            DataBuilder::build($this->field_description())->name(__('Deskripsi'))->sort()->excel(),
            DataBuilder::build($this->field_primary())->name(__('Pekerjaan'))->sort()->excel(),
            DataBuilder::build($this->field_status())->name(__('Status'))->show(true)->sort()->excel(),
            // DataBuilder::build($this->field_implement_by())->name(__('Implementor'))->sort()->excel(),
            // DataBuilder::build(Product::field_name())->name(__('Product Name'))->sort()->excel(),
            // DataBuilder::build($this->field_description())->name(__('Description'))->show(false)->excel(),
            // DataBuilder::build($this->field_check())->name(__('Check'))->show(false),
            // DataBuilder::build($this->field_result())->name(__('Result'))->show(false),
            // DataBuilder::build($this->field_ticket_code())->name(__('Ticket ID'))->sort()->show(false),
        ];
    }

    public function has_type()
    {
        return $this->hasOne(WorkType::class, WorkType::field_primary(), self::field_type_id());
    }

    public function has_suggestion()
    {
        return $this->hasOne(WorkSuggestion::class, WorkSuggestion::field_primary(), self::field_suggestion_id());
    }

    public function has_product()
    {
        return $this->hasOne(Product::class, Product::field_primary(), self::field_product_id());
    }

    public function has_vendor()
    {
        return $this->hasOne(Supplier::class, Supplier::field_primary(), self::field_vendor_id());
    }

    public function has_implementor()
    {
        return $this->hasOne(User::class, User::field_primary(), self::field_implement_by());
    }

    public function has_location()
    {
        return $this->hasOne(Location::class, Location::field_primary(), self::field_location_id());
    }

    public function has_ticket()
    {
        return $this->hasOne(TicketSystem::class, TicketSystem::field_primary(), self::field_ticket_code());
    }

    public function has_reported_by()
    {
        return $this->hasOne(User::class, User::field_primary(), self::field_reported_by());
    }

    public function has_sparepart()
    {
        return $this->belongsToMany(Sparepart::class, 'work_sheet_sparepart', 'work_sheet_code', 'sparepart_id')->withPivot(['qty', 'description'])
        ->withPivot(['qty', 'description']);
    }

    public function workTypeNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(WorkType::field_name(), $direction);
        return $query;
    }

    public function productNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy(Product::field_name(), $direction);
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
                $model->{self::field_status()} = WorkStatus::Open;
            }

            $model->{self::field_primary()} = Uuid::uuid1()->toString();
        });

        parent::saving(function ($model) {

            if (!empty($model->{self::field_check()}) and !empty($model->{self::field_ticket_code()})) {
                $model->{self::field_product_fisik()} = null;
                $ticket = $model->has_ticket;
                if($ticket){
                    $ticket->{TicketSystem::field_checked_at()} = date('Y-m-d H:i:s');
                    $ticket->{TicketSystem::field_checked_by()} = auth()->user()->id;
                    $ticket->{TicketSystem::field_check()} = $model->{self::field_check()};
                    $ticket->{TicketSystem::field_action()} = $model->{self::field_action()};
                    $ticket->{TicketSystem::field_result()} = $model->{self::field_result()};
                    $ticket->{TicketSystem::field_status()} = TicketStatus::Progress;
                    $ticket->save();
                }
            }

            if (empty($model->{self::field_product_id()})) {
                $model->{self::field_product_fisik()} = null;
                $model->{self::field_product_fungsi()} = null;
                $model->{self::field_product_description()} = null;
                $model->{self::field_suggestion_id()} = null;
                $model->{self::field_product_id()} = null;
            }

            if ($model->{self::field_status()} == WorkStatus::Close) {
                $model->{self::field_finished_by()} = auth()->user()->id;
                $model->{self::field_finished_at()} = date('Y-m-d H:i:s');
            }

            if ($model->{self::field_status()} == WorkStatus::Progress || !empty($model->{self::field_check()})) {
                $model->{self::field_check_by()} = auth()->user()->id;
                $model->{self::field_check_at()} = date('Y-m-d H:i:s');
            }

            if (request()->has('file_picture')) {
                $file_logo = request()->file('file_picture');
                $extension = $file_logo->getClientOriginalExtension();
                $name = time() . '.' . $extension;
                $file_logo->storeAs('public/worksheet/', $name);
                $model->{WorkSheet::field_picture()} = $name;
            }
        });

        parent::boot();
    }

}
