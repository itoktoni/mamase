<?php

namespace App\Dao\Entities;

use App\Dao\Models\Location;
use App\Dao\Models\Sparepart;

trait ReceiveEntity
{
    public static function field_primary()
    {
        return 'receive_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'receive_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'receive_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_ask()
    {
        return 'receive_ask';
    }

    public function getFieldAskAttribute()
    {
        return $this->{$this->field_ask()};
    }

    public static function field_qty()
    {
        return 'receive_qty';
    }

    public function getFieldQtyAttribute()
    {
        return $this->{$this->field_qty()};
    }

    public static function field_date()
    {
        return 'receive_date';
    }

    public function getFieldDateAttribute()
    {
        return $this->{$this->field_date()};
    }

    public static function field_sparepart_id()
    {
        return 'receive_sparepart_id';
    }

    public function getFieldSparepartIdAttribute()
    {
        return $this->{$this->field_sparepart_id()};
    }

    public function getFieldSparepartNameAttribute()
    {
        return $this->{Sparepart::field_name()};
    }

    public static function field_location_id()
    {
        return 'receive_location_id';
    }

    public function getFieldLocationIdAttribute()
    {
        return $this->{$this->field_location_id()};
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public static function field_request_id()
    {
        return 'receive_request_code';
    }

    public function getFieldRequestIdAttribute()
    {
        return $this->{$this->field_request_id()};
    }

    public static function field_group()
    {
        return 'receive_group';
    }

    public function getFieldGroupAttribute()
    {
        return $this->{$this->field_group()};
    }
}
