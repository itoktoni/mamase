<?php

namespace App\Dao\Entities;

use App\Dao\Models\Brand;
use App\Dao\Models\Category;
use App\Dao\Models\Department;
use App\Dao\Models\Location;
use App\Dao\Models\ProductTech;
use App\Dao\Models\ProductType;
use App\Dao\Models\Supplier;
use App\Dao\Models\Unit;

trait ProductEntity
{
    public static function field_primary()
    {
        return 'product_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{self::field_primary()};
    }

    public static function field_name()
    {
        return 'product_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{self::field_name()};
    }

    public static function field_description()
    {
        return 'product_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{self::field_description()};
    }

    public static function field_status()
    {
        return 'product_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{self::field_status()};
    }

    public static function field_serial_number()
    {
        return 'product_serial_number';
    }

    public function getFieldSerialNumberAttribute()
    {
        return $this->{self::field_serial_number()};
    }

    public static function field_internal_number()
    {
        return 'product_internal_number';
    }

    public function getFieldInternalNumberAttribute()
    {
        return $this->{self::field_internal_number()};
    }

    public static function field_auto_number()
    {
        return 'product_auto_number';
    }

    public function getFieldAutoNumberAttribute()
    {
        return $this->{self::field_auto_number()};
    }

    public static function field_price()
    {
        return 'product_price';
    }

    public function getFieldPriceAttribute()
    {
        return $this->{self::field_price()};
    }

    public static function field_buy_date()
    {
        return 'product_buy_date';
    }

    public function getFieldBuyDateAttribute()
    {
        return $this->{self::field_buy_date()};
    }

    public static function field_prod_year()
    {
        return 'product_prod_year';
    }

    public function getFieldProdYearAttribute()
    {
        return $this->{self::field_prod_year()};
    }

    public static function field_acqu_year()
    {
        return 'product_acqu_year';
    }

    public function getFieldAcquYearAttribute()
    {
        return $this->{self::field_acqu_year()};
    }

    public static function field_is_asset()
    {
        return 'product_is_asset';
    }

    public function getFieldIsAssetAttribute()
    {
        return $this->{self::field_is_asset()};
    }

    public static function field_location_id()
    {
        return 'product_location_id';
    }

    public function getFieldLocationIdAttribute()
    {
        return $this->{self::field_location_id()};
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public static function field_vendor_id()
    {
        return 'movement_vendor_id';
    }

    public function getFieldVendorIdAttribute()
    {
        return $this->{self::field_vendor_id()};
    }

    public function getFieldVendorNameAttribute()
    {
        return $this->{Supplier::field_name()};
    }

    public static function field_type_id()
    {
        return 'product_type_id';
    }

    public function getFieldTypeNameAttribute()
    {
        return $this->{ProductType::field_name()};
    }

    public static function field_supplier_id()
    {
        return 'product_supplier_id';
    }

    public function getFieldSupplierNameAttribute()
    {
        return $this->{Supplier::field_name()};
    }

    public static function field_department_id()
    {
        return 'product_department_id';
    }

    public function getFieldDepartmentNameAttribute()
    {
        return $this->{Department::field_name()};
    }

    public static function field_brand_id()
    {
        return 'product_brand_id';
    }

    public function getFieldBrandNameAttribute()
    {
        return $this->{Brand::field_name()};
    }

    public static function field_unit_code()
    {
        return 'product_unit_code';
    }

    public function getFieldUnitNameAttribute()
    {
        return $this->{Unit::field_name()};
    }

    public static function field_category_id()
    {
        return 'product_category_id';
    }

    public function getFieldCategoryNameAttribute()
    {
        return $this->{Category::field_name()};
    }

    public static function field_product_tech_id()
    {
        return 'product_tech_id';
    }

    public function getFieldProductTechIdAttribute()
    {
        return $this->{self::field_product_tech_id()};
    }

    public function getFieldProductTechNameAttribute()
    {
        return $this->{ProductTech::field_name()};
    }

    public static function field_image()
    {
        return 'product_image';
    }

    public function getFieldImageAttribute()
    {
        return $this->{self::field_image()};
    }

    public function getFieldImageUrlAttribute()
    {
        return url('storage/product/'.$this->{self::field_image()});
    }

}
