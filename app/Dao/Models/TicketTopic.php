<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\TicketTopicEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\OptionTrait;
use App\Dao\Traits\DataTableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class TicketTopic extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, TicketTopicEntity, ActiveTrait, OptionTrait;

    protected $table = 'ticket_topic';
    protected $primaryKey = 'ticket_topic_id';

    protected $fillable = [
        'ticket_topic_id',
        'ticket_topic_name',
        'ticket_topic_active',
    ];

    public $sortable = [
        'ticket_topic_name',
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
            DataBuilder::build($this->field_primary())->show(false)->name('ID'),
            DataBuilder::build($this->field_name())->name('Name')->sort(),
            DataBuilder::build($this->field_active())->name('Active')->show(false),
        ];
    }

    public function has_user()
    {
        return $this->belongsToMany(User::class, 'ticket_topic_user', 'ticket_topic_id', 'id');
    }
}