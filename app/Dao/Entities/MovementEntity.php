<?php

namespace App\Dao\Entities;

use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\User;

trait MovementEntity
{
    public static function field_primary()
    {
        return 'movement_code';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{self::field_primary()};
    }

    public static function field_description()
    {
        return 'movement_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{self::field_description()};
    }

    public static function field_reason()
    {
        return 'movement_reason';
    }

    public function getFieldReasonAttribute()
    {
        return $this->{self::field_reason()};
    }

    public static function field_date()
    {
        return 'movement_date';
    }

    public function getFieldDateAttribute()
    {
        return $this->{self::field_date()};
    }

    public static function field_product_id()
    {
        return 'movement_product_id';
    }

    public function getFieldProductNameAttribute()
    {
        return $this->{Product::field_name()};
    }

    public static function field_location_old()
    {
        return 'movement_location_old';
    }

    public function getFieldLocationOldAttribute()
    {
        return $this->{self::field_location_old()};
    }

    public static function field_location_new()
    {
        return 'movement_location_new';
    }

    public function getFieldLocationNewAttribute()
    {
        return $this->{self::field_location_new()};
    }

    public static function field_status()
    {
        return 'movement_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{self::field_status()};
    }

    public static function field_requested_by()
    {
        return 'movement_requested_by';
    }

    public function getFieldRequestedByNameAttribute()
    {
        return $this->{User::field_name()};
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public static function field_requested_at()
    {
        return 'movement_requested_at';
    }

    public function getFieldRequestedAtAttribute()
    {
        return $this->{self::field_requested_at()};
    }

    public static function field_approved_by()
    {
        return 'movement_approved_by';
    }

    public function getFieldApprovedByAttribute()
    {
        return $this->{self::field_approved_by()};
    }

    public static function field_approved_at()
    {
        return 'movement_approved_at';
    }

    public function getFieldApprovedAtAttribute()
    {
        return $this->{self::field_approved_at()};
    }
}
