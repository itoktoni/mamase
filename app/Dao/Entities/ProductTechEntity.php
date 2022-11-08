<?php

namespace App\Dao\Entities;

trait ProductTechEntity
{
    public static function field_primary()
    {
        return 'product_tech_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'product_tech_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'product_tech_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }
}
