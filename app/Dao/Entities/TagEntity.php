<?php

namespace App\Dao\Entities;

trait TagEntity
{
    public static function field_primary()
    {
        return 'tag_code';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'tag_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }
}
