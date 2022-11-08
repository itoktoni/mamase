<?php

namespace App\Dao\Entities;

trait LocationCategoryEntity
{
    public static function field_primary()
    {
        return 'location_category_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'location_category_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'location_category_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }
}
