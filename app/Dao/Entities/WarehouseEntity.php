<?php

namespace App\Dao\Entities;

use App\Dao\Models\Building;
use App\Dao\Models\Location;
use App\Dao\Models\Sparepart;

trait WarehouseEntity
{
    public static function field_primary()
    {
        return 'warehouse_sparepart_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return Sparepart::field_name();
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_sparepart_id()
    {
        return 'warehouse_sparepart_id';
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
        return 'warehouse_location_id';
    }

    public function getFieldLocationtIdAttribute()
    {
        return $this->{$this->field_location_id()};
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public function getFieldBuildingNameAttribute()
    {
        return $this->{Building::field_name()};
    }

    public static function field_qty()
    {
        return 'warehouse_qty';
    }

    public function getFieldQtyAttribute()
    {
        return $this->{$this->field_qty()};
    }

    public static function field_description()
    {
        return 'warehouse_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

}
