<?php

namespace App\Dao\Entities;

trait NotificationEntity
{
    public static function field_primary()
    {
        return 'notification_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'notification_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'notification_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_phone()
    {
        return 'notification_phone';
    }

    public function getFieldPhoneAttribute()
    {
        return $this->{$this->field_phone()};
    }

    public static function field_status()
    {
        return 'notification_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{$this->field_status()};
    }

    public static function field_eta()
    {
        return 'notification_eta';
    }

    public function getFieldEtaAttribute()
    {
        return $this->{$this->field_eta()};
    }

    public static function field_etd()
    {
        return 'notification_etd';
    }

    public function getFieldEtdAttribute()
    {
        return $this->{$this->field_etd()};
    }

    public static function field_image()
    {
        return 'notification_image';
    }

    public function getFieldImageAttribute()
    {
        return $this->{$this->field_image()};
    }

    public static function field_type()
    {
        return 'notification_type';
    }

    public function getFieldTypeAttribute()
    {
        return $this->{$this->field_type()};
    }

    public static function field_error()
    {
        return 'notification_error';
    }

    public function getFieldErrorAttribute()
    {
        return $this->{$this->field_error()};
    }
}
