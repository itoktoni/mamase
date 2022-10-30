<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\TagEntity;
use App\Dao\Enums\UserType;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Tag extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, TagEntity, ActiveTrait;

    protected $table = 'tag';
    protected $primaryKey = 'tag_code';

    protected $fillable = [
        'tag_code',
        'tag_name',
    ];

    public $sortable = [
        'tag_name',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = false;

    public function fieldSearching(){
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Tag Code'),
            DataBuilder::build($this->field_name())->name('Tag Name')->sort(),
        ];
    }
}
