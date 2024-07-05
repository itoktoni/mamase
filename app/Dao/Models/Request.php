<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\RequestEntity;
use App\Dao\Enums\RequestStatusType;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Ramsey\Uuid\Uuid;
use Wildside\Userstamps\Userstamps;

class Request extends Model
{
    use Sortable, FilterQueryString, PowerJoins, Sanitizable, DataTableTrait, RequestEntity, OptionTrait, ActiveTrait, Userstamps;

    protected $table = 'request';
    protected $primaryKey = 'request_code';

    protected $fillable = [
        'request_code',
        'request_name',
        'request_start_date',
        'request_end_date',
        'request_date',
        'request_created_at',
        'request_updated_at',
        'request_created_by',
        'request_updated_by',
        'request_approval_by',
        'request_cc_by',
        'request_status',
        'request_category',
        'request_description',
    ];

    public $sortable = [
        'request_code',
    ];

    protected $filters = [
        'filter',
    ];

    const CREATED_AT = 'request_created_at';
    const UPDATED_AT = 'request_updated_at';
    const DELETED_AT = 'request_deleted_at';

    const CREATED_BY = 'request_created_by';
    const UPDATED_BY = 'request_updated_by';
    const DELETED_BY = 'request_deleted_by';

    protected $casts = [
        'request_category' => 'integer',
        'request_status' => 'integer',
        'request_approval_by' => 'integer',

    ];

    public $timestamps = true;
    public $incrementing = false;

    protected $keyType = 'string';

    public function fieldSearching()
    {
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Kode'),
            DataBuilder::build($this->field_name())->name('Permintaan'),
            DataBuilder::build($this->field_date())->name('Tanggal'),
            DataBuilder::build(User::field_name())->name('Persetujuan Oleh'),
            DataBuilder::build($this->field_start_date())->name('Tgl Mulai'),
            DataBuilder::build($this->field_end_date())->name('Tgl Akhir'),
            DataBuilder::build($this->field_status())->name('Status'),
        ];
    }

    public function has_worksheet()
    {
        return $this->belongsToMany(WorkSheet::class, 'work_sheet_sparepart', self::field_primary(), WorkSheet::field_primary());
    }

    public function has_user(){
        return $this->hasOne(User::class, User::field_primary(), self::field_approval_id());
    }

    public function has_approval(){
        return $this->hasOne(User::class, User::field_primary(), self::field_approval_id());
    }

    public function has_receive(){
        return $this->hasMany(Receive::class, Receive::field_request_id(), self::field_primary());
    }

    public function has_sparepart()
    {
        return $this->belongsToMany(Sparepart::class, 'work_sheet_sparepart', 'request_code', 'sparepart_id')
            ->wherePivotNull('work_sheet_code')
            ->withPivot(['qty', 'description', 'ticket_code', 'sparepart_id', 'work_sheet_code']);
    }

    public function has_part()
    {
        return $this->belongsToMany(Sparepart::class, 'work_sheet_sparepart', 'request_code', 'sparepart_id')
            ->withPivot(['qty', 'description', 'ticket_code', 'sparepart_id', 'work_sheet_code']);
    }
}
