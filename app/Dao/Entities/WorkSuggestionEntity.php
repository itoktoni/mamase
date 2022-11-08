<?php

namespace App\Dao\Entities;

trait WorkSuggestionEntity
{
    public static function field_primary()
    {
        return 'work_suggestion_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'work_suggestion_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }
}
