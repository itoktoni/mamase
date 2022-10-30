<?php

namespace App\Dao\Entities;

use App\Dao\Models\Building;
use App\Dao\Models\Floor;
use App\Dao\Models\User;

trait LocationEntity
{
    public static function field_primary()
    {
        return 'location_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'location_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'location_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_building_id()
    {
        return 'location_building_id';
    }

    public function getFieldBuildingNameAttribute()
    {
        return $this->{Building::field_name()};
    }

    public static function field_floor_id()
    {
        return 'location_floor_id';
    }

    public function getFieldFloorNameAttribute()
    {
        return $this->{Floor::field_name()};
    }

    public static function field_pic_user_id()
    {
        return 'location_pic_user_id';
    }

    public function getFieldPicNameAttribute()
    {
        return $this->{User::field_name()};
    }

    public static function field_phone()
    {
        return 'location_phone';
    }

    public function getFieldPhoneNameAttribute()
    {
        return $this->{$this->field_phone()};
    }

    public static function field_jenis_layanan()
    {
        return 'location_jenis_layanan';
    }

    public function getFieldJenisLayananAttribute()
    {
        return $this->{$this->field_jenis_layanan()};
    }

    public function getLocationFullAttribute()
    {
        $string = $this->{$this->field_name()}.PHP_EOL;
        if($building = $this->has_building){
            $string = $string.$building->field_name.PHP_EOL;
        }

        if($floor = $this->has_floor){
            $string = $string.$floor->field_name.PHP_EOL;
        }

        return $string;
    }
}
