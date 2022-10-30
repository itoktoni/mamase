<?php

namespace App\Dao\Entities;

use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Models\WorkSheet;

trait SpkEntity
{
    public static function field_primary()
    {
        return 'spk_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_vendor_id()
    {
        return 'spk_vendor_id';
    }

    public function getFieldVendorIdAttribute()
    {
        return $this->{$this->field_vendor_id()};
    }

    public function getFieldVendorNameAttribute()
    {
        return $this->{Supplier::field_name()};
    }

    public static function field_date()
    {
        return 'spk_date';
    }

    public function getFieldDateAttribute()
    {
        return $this->{$this->field_date()};
    }

    public static function field_code()
    {
        return 'spk_code';
    }

    public function getFieldCodeAttribute()
    {
        return $this->{$this->field_code()};
    }

    public static function field_description()
    {
        return 'spk_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_product_id()
    {
        return 'spk_product_id';
    }

    public function getFieldProductNameAttribute()
    {
        return $this->{Product::field_name()};
    }

    public static function field_check()
    {
        return 'spk_check';
    }

    public function getFieldCheckAttribute()
    {
        return $this->{$this->field_check()};
    }

    public static function field_result()
    {
        return 'spk_result';
    }

    public function getFieldResultAttribute()
    {
        return $this->{$this->field_result()};
    }

    public static function field_work_sheet_code()
    {
        return 'spk_work_sheet_code';
    }

    public function getFieldWorkSheetNameAttribute()
    {
        return $this->{Worksheet::field_name()};
    }

    public static function field_status()
    {
        return 'spk_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{$this->field_status()};
    }

}
