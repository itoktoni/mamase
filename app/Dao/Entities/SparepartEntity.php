<?php

namespace App\Dao\Entities;

use App\Dao\Models\Brand;
use App\Dao\Models\Product;
use App\Dao\Models\ProductType;
use App\Dao\Models\Unit;

trait SparepartEntity
{
    public static function field_primary()
    {
        return 'sparepart_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'sparepart_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_location_id()
    {
        return 'sparepart_location_id';
    }

    public function getFieldLocationIdAttribute()
    {
        return $this->{$this->field_location_id()};
    }

    public static function field_description()
    {
        return 'sparepart_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_stock()
    {
        return 'sparepart_stock';
    }

    public function getFieldStockAttribute()
    {
        return $this->{$this->field_stock()};
    }

    public static function field_product_id()
    {
        return 'sparepart_product_id';
    }

    public function getFieldproductNameAttribute()
    {
        return $this->{Product::field_name()};
    }

    public static function field_brand_id()
    {
        return 'sparepart_brand_id';
    }

    public function getFieldBrandNameAttribute()
    {
        return $this->{Brand::field_name()};
    }

    public static function field_type_id()
    {
        return 'sparepart_type_id';
    }

    public function getFieldTypeNameAttribute()
    {
        return $this->{ProductType::field_name()};
    }

    public static function field_unit_code()
    {
        return 'sparepart_unit_code';
    }

    public function getFieldUnitNameAttribute()
    {
        return $this->{Unit::field_name()};
    }
}
