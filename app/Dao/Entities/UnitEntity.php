<?php

namespace App\Dao\Entities;

trait UnitEntity
{
    public static function field_primary()
    {
        return 'unit_code';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'unit_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }
}