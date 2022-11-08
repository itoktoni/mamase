<?php

namespace App\Dao\Entities;

use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\WorkType;

trait ScheduleEntity
{
    public static function field_primary()
    {
        return 'schedule_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{self::field_primary()};
    }

    public static function field_name()
    {
        return 'schedule_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{self::field_name()};
    }

    public static function field_description()
    {
        return 'schedule_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{self::field_description()};
    }

    public static function field_product_id()
    {
        return 'schedule_product_id';
    }

    public function getFieldProductNameAttribute()
    {
        return $this->{Product::field_name()};
    }

    public static function field_location_id()
    {
        return 'schedule_location_id';
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public static function field_number()
    {
        return 'schedule_number';
    }

    public function getFieldNumberAttribute()
    {
        return $this->{self::field_number()};
    }

    public static function field_times()
    {
        return 'schedule_times';
    }

    public function getFieldTimesAttribute()
    {
        return $this->{self::field_times()};
    }

    public static function field_every()
    {
        return 'schedule_every';
    }

    public function getFieldEveryAttribute()
    {
        return $this->{self::field_every()};
    }

    public static function field_start_date()
    {
        return 'schedule_start_date';
    }

    public function getFieldStartDateAttribute()
    {
        return $this->{self::field_start_date()};
    }

    public static function field_end_date()
    {
        return 'schedule_end_date';
    }

    public function getFieldEndDateAttribute()
    {
        return $this->{self::field_end_date()};
    }

    public static function field_status()
    {
        return 'schedule_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{self::field_status()};
    }

    public function getFieldTypeNameAttribute()
    {
        return $this->{WorkType::field_name()};
    }
}
