<?php

namespace App\Dao\Entities;

trait SupplierEntity
{
    public static function field_primary()
    {
        return 'supplier_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'supplier_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_contact()
    {
        return 'supplier_contact';
    }

    public function getFieldContactAttribute()
    {
        return $this->{$this->field_contact()};
    }

    public static function field_address()
    {
        return 'supplier_address';
    }

    public function getFieldAddressAttribute()
    {
        return $this->{$this->field_address()};
    }

    public static function field_email()
    {
        return 'supplier_email';
    }

    public function getFieldEmailAttribute()
    {
        return $this->{$this->field_email()};
    }

    public static function field_phone()
    {
        return 'supplier_phone';
    }

    public function getFieldPhoneAttribute()
    {
        return $this->{$this->field_phone()};
    }

}
