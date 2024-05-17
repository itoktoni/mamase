<?php

namespace App\Dao\Entities;

use App\Dao\Models\Location;
use App\Dao\Models\Sparepart;

trait StockEntity
{
    public static function field_primary()
    {
        return 'stock_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'stock_awal';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'stock_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_perubahan()
    {
        return 'stock_perubahan';
    }

    public function getFieldPerubahanAttribute()
    {
        return $this->{$this->field_perubahan()};
    }

    public static function field_awal()
    {
        return 'stock_awal';
    }

    public function getFieldAwalAttribute()
    {
        return $this->{$this->field_awal()};
    }

    public static function field_akhir()
    {
        return 'stock_akhir';
    }

    public function getFieldAkhirAttribute()
    {
        return $this->{$this->field_akhir()};
    }

    public static function field_date()
    {
        return 'stock_date';
    }

    public function getFieldDateAttribute()
    {
        return $this->{$this->field_date()};
    }

    public static function field_sparepart_id()
    {
        return 'stock_sparepart_id';
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
        return 'stock_location_id';
    }

    public function getFieldLocationIdAttribute()
    {
        return $this->{$this->field_location_id()};
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }
}
