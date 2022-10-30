<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\DepartmentEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Department extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, DepartmentEntity, ActiveTrait, PowerJoins, OptionTrait;

    protected $table = 'department';
    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_id',
        'department_name',
        'department_description',
        'department_pic',
        'department_user_id',
    ];

    public $sortable = [
        'department_name',
        'users.name',
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
            DataBuilder::build($this->field_primary())->name('ID')->show(false),
            DataBuilder::build($this->field_user_name())->name('User')->sort(),
            DataBuilder::build($this->field_name())->name('Department Name')->sort(),
            DataBuilder::build($this->field_description())->name('Description'),
        ];
    }

    public function has_user(){

		return $this->hasOne(User::class, User::field_primary(), self::field_user_id());
	}


    public function userNameSortable($query, $direction)
    {
        $query = $this->queryFilter($query);
        $query = $query->orderBy($this->field_user_name(), $direction);
        return $query;
    }

}
