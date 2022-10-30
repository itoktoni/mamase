<?php

namespace App\Dao\Entities;

trait BuildingEntity
{
    public static function field_primary()
    {
        return 'building_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'building_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'building_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_contact_person()
    {
        return 'building_contact_person';
    }

    public function getFieldContactPersonAttribute()
    {
        return $this->{$this->field_contact_person()};
    }

    public static function field_contact_phone()
    {
        return 'building_contact_phone';
    }

    public function getFieldContactPhoneAttribute()
    {
        return $this->{$this->field_contact_phone()};
    }

    public static function field_address()
    {
        return 'building_address';
    }

    public function getFieldAddressAttribute()
    {
        return $this->{$this->field_address()};
    }

    public static function field_basement()
    {
        return 'building_basement';
    }

    public function getFieldBasementAttribute()
    {
        return $this->{$this->field_basement()};
    }

    public static function field_jumlah_lantai()
    {
        return 'building_jumlah_lantai';
    }

    public function getFieldJumlahLantaiAttribute()
    {
        return $this->{$this->field_jumlah_lantai()};
    }
}
