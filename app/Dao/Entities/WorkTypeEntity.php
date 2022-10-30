<?php

namespace App\Dao\Entities;

trait WorkTypeEntity
{
    public static function field_primary()
    {
        return 'work_type_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'work_type_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }
}
