<?php

namespace App\Dao\Entities;

trait FloorEntity
{
    public static function field_primary()
    {
        return 'floor_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'floor_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_building_id()
    {
        return 'floor_building_id';
    }

    public function getFieldBuildingIdAttribute()
    {
        return $this->{$this->field_building_id()};
    }

    public static function field_description()
    {
        return 'floor_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }
}
