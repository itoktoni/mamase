<?php

namespace App\Dao\Entities;

use App\Dao\Models\Location;
use App\Dao\Models\Sparepart;

trait DistributionEntity
{
    public static function field_primary()
    {
        return 'distribution_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'distribution_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'distribution_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_ask()
    {
        return 'distribution_ask';
    }

    public function getFieldAskAttribute()
    {
        return $this->{$this->field_ask()};
    }

    public static function field_qty()
    {
        return 'distribution_qty';
    }

    public function getFieldQtyAttribute()
    {
        return $this->{$this->field_qty()};
    }

    public static function field_date()
    {
        return 'distribution_date';
    }

    public function getFieldDateAttribute()
    {
        return $this->{$this->field_date()};
    }

    public static function field_sparepart_id()
    {
        return 'distribution_sparepart_id';
    }

    public function getFieldSparepartIdAttribute()
    {
        return $this->{$this->field_sparepart_id()};
    }

    public function getFieldSparepartNameAttribute()
    {
        return $this->{Sparepart::field_name()};
    }

    public static function field_location_from()
    {
        return 'distribution_location_from';
    }

    public function getFieldLocationFromAttribute()
    {
        return $this->{$this->field_location_from()};
    }

    public function getFieldLocationFromNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public static function field_location_to()
    {
        return 'distribution_location_to';
    }

    public function getFieldLocationToAttribute()
    {
        return $this->{$this->field_location_to()};
    }

    public function getFieldLocationToNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public static function field_request_id()
    {
        return 'distribution_request_code';
    }

    public function getFieldRequestIdAttribute()
    {
        return $this->{$this->field_request_id()};
    }
}
